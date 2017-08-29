class Api::ListController < Api::ApiController

  def index
    service = Api::ListsService.new
    result = service.call
    render json: result
  end

  def show
    service = Api::ListService.new(show_params[:org])
    result = service.call
    render json: result
  end

  private
  
  def show_params
    params.require(:org)
    params.permit(:org, :format)
  end

end
