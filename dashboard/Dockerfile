FROM ruby:2.3.3
RUN apt-get update -qq && apt-get install -y build-essential


RUN mkdir /dashboard
WORKDIR /dashboard
ADD . /dashboard
RUN bundle install 

ENV RAILS_SERVE_STATIC_FILES=1
ENV RAILS_ENV=production

EXPOSE  3000
CMD ["bundle", "exec", "rails", "server", "-b", "0.0.0.0"]
