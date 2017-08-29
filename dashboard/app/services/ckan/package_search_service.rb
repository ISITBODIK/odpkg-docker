class Ckan::PackageSearchService < ServiceBase

  def initialize(query)
    @query = query
  end

  def perform
    api = Ckan::ApiService.new(Settings.ckan.api)
    response = api.call.get('action/package_search') do |request|
      request.params[:q] = @query
      request.params[:rows] = 999
    end
    hash = response.body

    if hash[:success]
      hash[:result][:results]
    else
      message = 'パッケージ検索エラー id:%s type:%s message:%s' %
                [@id, hash[:error][:__type], hash[:error][:message]]
      raise ServiceError, message
    end
  end

end
