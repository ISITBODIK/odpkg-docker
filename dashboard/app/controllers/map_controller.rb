class MapController < ApplicationController
  layout 'map'

  def index
    render :index
  end

  def show
    @org_id = params[:id]
    render :index
  end

end
