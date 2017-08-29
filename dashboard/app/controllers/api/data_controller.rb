class Api::DataController < Api::ApiController

  def polygon
    service = Api::PolygonService.new(polygon_params[:org], polygon_params[:id])
    json = service.call
    render json: json
  end

  def point
    service = Api::PointService.new(point_params[:id])
    json = service.call
    render json: json
  end

  private

  def polygon_params
    params.require([:id, :org])
    params.permit(:org, :id, :format)
  end

  def point_params
    params.require(:id)
    params.permit(:id, :format)
  end

end
