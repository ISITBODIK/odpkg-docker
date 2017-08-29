Rails.application.routes.draw do

  root to: 'map#index'

  namespace :api, {format: 'json'} do
    namespace :list do
      get '/', action: :index
      get '/:org', action: :show
    end
    namespace :data, {format: 'json'} do
      get '/polygon/:org/:id', action: :polygon
      get '/point/:id', action: :point
    end
  end

  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html

end
