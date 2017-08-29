class Api::PointService < ServiceBase

  def initialize(id)
    @id = id
  end

  def perform
    
    raise ServiceError, 'リソース名不正' unless @id.match(/^[\w-]+$/)

    resource_show = Ckan::ResourceShowService.new(@id)
    resource = resource_show.call

    csv_load = Util::CsvLoadService.new(resource[:url], resource[:format])
    rows = csv_load.call

    geojson = {
      features: [],
      type: 'FeatureCollection'
    }

    point_data_builder = Geo::PointDataBuilderService.new(geojson, rows)
    geojson = point_data_builder.call

    geojson
  end

end
