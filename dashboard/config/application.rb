require_relative 'boot'

require 'rails/all'

# Require the gems listed in Gemfile, including any gems
# you've limited to :test, :development, or :production.
Bundler.require(*Rails.groups)

module DashboardApi
  class Application < Rails::Application
    # Settings in config/environments/* take precedence over those specified here.
    # Application configuration should go into files in config/initializers
    # -- all .rb files in that directory are automatically loaded.

    #config.assets.paths << Rails.root.join('vendor', 'assets', 'images')

    config.middleware.delete ActionDispatch::Cookies
    config.middleware.delete ActionDispatch::Session::CookieStore
    config.middleware.delete ActionDispatch::Flash

    config.middleware.use Rack::Deflater

    config.action_controller.action_on_unpermitted_parameters = :raise
    
    #config.action_dispatch.default_headers.delete('X-Frame-Options')

    #config.middleware.insert_before 0, Rack::Cors do
    #  allow do
    #    origins '*'
    #    resource '*', :headers => :any, :methods => [:get]
    #  end
    #end
    
  end
end
