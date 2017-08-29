class Api::ListService < ServiceBase

  def initialize(org)
    @org = org
  end

  def perform
    
    raise ServiceError, '不明な組織' unless Settings.organizations.collect{|org| org[:id]}.include?(@org) 
    raise ServiceError, '組織名不正' unless @org.match(/^[\w-]+$/)

    polygon_find_service = Ckan::GeodataFindService.new(@org, Settings.ckan.polygon_tag)
    point_find_service = Ckan::GeodataFindService.new(@org, Settings.ckan.point_tag)

    polygon_groups, polygons = polygon_find_service.call
    point_groups, points = point_find_service.call

    groups = []
    groups.concat(polygon_groups)
    groups.concat(point_groups)

    {
      groups: groups.uniq,
      polygons: polygons,
      points: points
    }
  end

end
