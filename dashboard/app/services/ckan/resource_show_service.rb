class Ckan::ResourceShowService < ServiceBase

  def initialize(id)
    @id = id
  end

  def perform
    api = Ckan::ApiService.new(Settings.ckan.api)
    response = api.call.get('action/resource_show') do |request|
      request.params[:id] = @id
    end
    hash = response.body

    if hash[:success]
      hash[:result]
    else
      message = 'リソース取得エラー id:%s type:%s message:%s' %
                [@id, hash[:error][:__type], hash[:error][:message]]
      raise ServiceError, message
    end
  end

end
