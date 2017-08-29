class Ckan::ApiService < ServiceBase

  def initialize(url)
    @url = url
  end

  def perform
    Faraday.new(url: @url) do |faraday|
      faraday.request :multi_json
      #faraday.response :logger
      faraday.response :multi_json, :symbolize_keys => true
      faraday.adapter Faraday.default_adapter
    end
  end

end
