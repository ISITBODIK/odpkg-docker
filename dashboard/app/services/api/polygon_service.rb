class Api::PolygonService < ServiceBase

  def initialize(org, id)
    @org = org
    @id = id
  end

  def perform

    raise ServiceError, '不明な組織' unless Settings.organizations.collect{|org| org[:id]}.include?(@org) 
    raise ServiceError, '組織名不正' unless @id.match(/^[\w-]+$/)
    raise ServiceError, 'リソース名不正' unless @id.match(/^[\w-]+$/)

    resource_show = Ckan::ResourceShowService.new(@id)
    resource = resource_show.call

    csv_load = Util::CsvLoadService.new(resource[:url], resource[:format])
    rows = csv_load.call

    org = Settings.organizations.select{|org| org[:id]==@org}.first
    map_path = Pathname.new('./app/maps/').join(File.basename(org.maps.json))
    geojson = JSON.parse(File::open(map_path).read, symbolize_names: true)

    polygon_data_builder = Geo::PolygonDataBuilderService.new(geojson, rows)
    geojson = polygon_data_builder.call

    geojson
  end

end
