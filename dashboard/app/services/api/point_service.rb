# -*- coding: utf-8 -*-

require 'csv'
require 'json'
require 'rest_client'
require 'set'

class Api::PointService < ServiceBase

  def initialize(id)
    @id = id
  end

  def perform
    
    raise ServiceError, 'リソース名不正' unless @id.match(/^[\w-]+$/)

    resource_show = Ckan::ResourceShowService.new(@id)
    resource = resource_show.call

    if ( ( resource[:format] == 'CSV' ) ||
         ( resource[:format] == 'XLS' ) ||
         ( resource[:format] == 'XLSX' ) ) then

      csv_load = Util::CsvLoadService.new(resource[:url], resource[:format])
      rows = csv_load.call

    elsif ( ( resource[:format] == 'JSON' ) ) then

      endpoint  = resource[:url]

      response    = RestClient.get endpoint, :format => "application/sparql-results+json"
      json_string = JSON.parse( response.to_str )

      # find heading
      header    = Array.new()
      lod_row   = Array.new( Array.new() )
      row_count = -1

      json_string.each do |hash|
        hash.each do |item|
          if ( item['vars'] ) then
            item['vars'].each do |elm|
              header << elm
            end
          end
        end
      end

      row_count += 1 
      lod_row[row_count] = header

      # find values for each header items
      json_string.each do |hash|
        hash.each do |hash2|

          if ( hash2['bindings'] ) then
            hash2['bindings'].each do |item|

              row_item = Array.new()

              header.each do |head|
                value = ""

                if ( item[head] ) then
                  item[head].each do |key, elm|
                    if ( key == "value" ) then
                      value = elm
                    end
                  end
                end
                row_item << value

              end
        
              row_count += 1 
              lod_row[ row_count ] = row_item

            end
          end

        end
      end

      # logger.debug ( lod_row )
      rows = lod_row
    end
    # logger.debug ( rows )

    geojson = {
      features: [],
      type: 'FeatureCollection'
    }

    point_data_builder = Geo::PointDataBuilderService.new(geojson, rows)
    geojson = point_data_builder.call

    geojson
  end

end
