# -*- coding: utf-8 -*-
class Api::PolygonService < ServiceBase

  def initialize(org, id)
    @org = org.to_s
    @id = id
  end

  def perform

    raise ServiceError, '不明な組織' unless Settings.organizations.collect{|org| org[:id].to_s}.include?(@org) 
    raise ServiceError, '組織名不正' unless @id.match(/^[\w-]+$/)
    raise ServiceError, 'リソース名不正' unless @id.match(/^[\w-]+$/)

    resource_show = Ckan::ResourceShowService.new(@id)
    resource = resource_show.call

    csv_load = Util::CsvLoadService.new(resource[:url], resource[:format])
    rows = csv_load.call

    org = Settings.organizations.select{|org| org[:id].to_s==@org}.first
    #map_path = Pathname.new('./app/maps/').join(File.basename(org.maps.json))
    #geojson = JSON.parse(File::open(map_path).read, symbolize_names: true)
    
    #選択されたリソースIDから同じデータセットのGeoJSONを取得 Y.Sakamoto 2017.08.24
    package_show = Ckan::PackageShowService.new(resource[:package_id])
    package = package_show.call

    geojson ={}

    package[:resources].each do |res|
        if ['GeoJSON'].include?(res[:format])
            uri = URI.parse(res[:url])
            res = Faraday.get(uri)
            geojson = JSON.parse(res.body.toutf8, symbolize_names: true)
        end
    end
    
    polygon_data_builder = Geo::PolygonDataBuilderService.new(geojson, rows)
    geojson = polygon_data_builder.call

    geojson
  end

end
