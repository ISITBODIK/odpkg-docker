class Api::ApiController < ActionController::Base

  rescue_from Exception, with: :handle_exception #unless Rails.env.development?
  rescue_from ServiceError, with: :handle_service_error #unless Rails.env.development?

  private

  def handle_exception(e)
    logger.error e.message
    render json: 'エラーが発生しました', status: 500
  end

  def handle_service_error(e)
    logger.error e.message
    render json: 'エラーが発生しました', status: 500
  end

end
