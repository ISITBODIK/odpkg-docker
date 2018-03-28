# -*- coding: utf-8 -*-
class Geo::PointDataBuilderService < ServiceBase

  def initialize(geojson, rows)
    @geojson = geojson
    @rows = rows
  end

  def perform
    header = @rows.shift

    lat_idx = header.index('緯度')
    if ( lat_idx == nil ) then
      lat_idx = header.index{|item| item =~ /緯度/}
      if ( lat_idx == nil ) then
        raise '緯度エラー'
      end
    end

    lng_idx = header.index('経度')
    if ( lng_idx == nil ) then
      lng_idx = header.index{|item| item =~ /経度/}
      if ( lng_idx == nil ) then
         raise '経度エラー'
      end
    end

    @rows.each do |row|
      feature = {
        geometry: {
          coordinates: [],
          type: 'Point'
        },
        properties: {
        },
        type: 'Feature'
      }

      feature[:geometry][:coordinates] = [row[lng_idx].to_f, row[lat_idx].to_f]

      header.each_with_index do |field, idx|

        if ( ( field != 'iConf' ) &&
             ( field != 'iLvl'  ) ) then

          feature[:properties][field] = row[idx].to_s
        end
      end

      @geojson[:features] << feature
    end

    @geojson
end

end
