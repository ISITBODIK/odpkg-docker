FROM ruby:2.3.3

RUN echo "deb [check-valid-until=no] http://archive.debian.org/debian jessie-backports main" > /etc/apt/sources.list.d/jessie-backports.list
RUN sed -i '/deb http:\/\/deb.debian.org\/debian jessie-updates main/d' /etc/apt/sources.list
RUN apt-get -o Acquire::Check-Valid-Until=false update

# RUN apt-get update -qq && apt-get install -y build-essential


RUN mkdir /dashboard
WORKDIR /dashboard
ADD . /dashboard
RUN bundle install 

ENV RAILS_SERVE_STATIC_FILES=1
ENV RAILS_ENV=production

EXPOSE  3000
CMD ["bundle", "exec", "rails", "server", "-b", "0.0.0.0"]
