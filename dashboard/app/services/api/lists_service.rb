class Api::ListsService < ServiceBase

  def initialize
  end

  def perform
    Settings.organizations.collect{|org| org.to_hash}
  end

end
