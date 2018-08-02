# See CKAN docs on installation from Docker Compose on usage
# FROM debian:jessie
FROM phusion/baseimage:0.9.19
MAINTAINER Open Knowledge

# Install required system packages
RUN apt-get -q -y update \
    && DEBIAN_FRONTEND=noninteractive apt-get -q -y upgrade \
    && apt-get -q -y install \
        python-dev \
        python-pip \
        python-virtualenv \
        python-wheel \
        libpq-dev \
        libxml2-dev \
        libxslt-dev \
        libgeos-dev \
        libssl-dev \
        libffi-dev \
        postgresql-client \
        build-essential \
        git-core \
        vim \
        wget \
        expect \
        apache2 \
	libapache2-mod-wsgi \
	libapache2-mod-rpaf \
	supervisor \
	emacs \
    && apt-get -q clean \
    && rm -rf /var/lib/apt/lists/*

# Define environment variables
ENV CKAN_HOME /usr/lib/ckan
ENV CKAN_VENV $CKAN_HOME/default
ENV CKAN_CONFIG /etc/ckan
ENV CKAN_STORAGE_PATH=/var/lib/ckan

# Build-time variables specified by docker-compose.yml / .env
ARG CKAN_SITE_URL

# Create ckan user
RUN useradd -r -u 900 -m -c "ckan account" -d $CKAN_HOME -s /bin/false ckan

# Setup virtual environment for CKAN
RUN mkdir -p $CKAN_VENV $CKAN_CONFIG $CKAN_STORAGE_PATH && \
    virtualenv $CKAN_VENV && \
    ln -s $CKAN_VENV/bin/pip /usr/local/bin/ckan-pip && \
    ln -s $CKAN_VENV/bin/paster /usr/local/bin/ckan-paster

# Setup CKAN
ADD ./ckan $CKAN_VENV/src/ckan/
RUN ckan-pip install -U pip && \
    ckan-pip install --upgrade --no-cache-dir -r $CKAN_VENV/src/ckan/requirement-setuptools.txt && \
    ckan-pip install --upgrade --no-cache-dir -r $CKAN_VENV/src/ckan/requirements.txt && \
    ckan-pip install -e $CKAN_VENV/src/ckan/ && \
    ln -s $CKAN_VENV/src/ckan/ckan/config/who.ini $CKAN_CONFIG/who.ini && \
    chown -R ckan:ckan $CKAN_HOME $CKAN_VENV $CKAN_CONFIG $CKAN_STORAGE_PATH

##########################
# Install and setup Apache
##########################
ADD ./ckan/contrib/docker/apache.wsgi $CKAN_CONFIG/apache.wsgi
# Configure apache
ADD ./ckan/contrib/docker/apache.conf /etc/apache2/sites-available/ckan_default.conf
RUN echo "Listen 8080" > /etc/apache2/ports.conf
RUN a2ensite ckan_default
RUN a2dissite 000-default

##########################
# Install and setup ckanext
##########################
#Install Tracking
RUN echo "0 5 * * * root $CKAN_VENV/bin/paster --plugin=ckan tracking update -c $CKAN_CONFIG/production.ini >/dev/null 2>&1 && \
$CKAN_VENV/bin/paster --plugin=ckan search-index rebuild -c $CKAN_CONFIG/production.ini >/dev/null 2>&1" >> /etc/cron.daily/ckan-cron

# Install ckanext-basiccharts
RUN git clone https://github.com/ckan/ckanext-basiccharts.git $CKAN_VENV/src/ckanext-basiccharts
RUN cd $CKAN_VENV/src/ckanext-basiccharts && $CKAN_VENV/bin/python setup.py install

# Install ckanext-harvent
RUN ckan-pip install -e git+https://github.com/ckan/ckanext-harvest.git#egg=ckanext-harvest
RUN ckan-pip install -r $CKAN_VENV/src/ckanext-harvest/pip-requirements.txt
RUN echo "*/15 * * * * root $CKAN_VENV/bin/paster --plugin=ckanext-harvest harvester run \
    -c $CKAN_CONFIG/production.ini >/dev/null 2>&1"  >> /etc/cron.daily/ckan-cron
RUN echo "0 3 * * * root $CKAN_VENV/bin/paster --plugin=ckanext-harvest harvester clean_harvest_log \
    -c $CKAN_CONFIG/production.ini >/dev/null 2>&1" >> /etc/cron.daily/ckan-cron
RUN chmod 0600 /etc/cron.daily/ckan-cron
RUN touch /var/log/cron.log

# Install ckanext-dcat
RUN ckan-pip install -e git+https://github.com/ckan/ckanext-dcat.git#egg=ckanext-dcat
RUN ckan-pip install -r $CKAN_VENV/src/ckanext-dcat/requirements.txt

# Install ckanext-googleanalytics
RUN ckan-pip install -e git+https://github.com/ckan/ckanext-googleanalytics.git#egg=ckanext-googleanalytics

#Add ckanext-googleanalytics
ADD ./ckanext-googleanalytics $CKAN_VENV/src/ckanext-googleanalytics

#Add ckanext-extractor
RUN cd $CKAN_VENV
RUN ckan-pip install -e git+https://github.com/stadt-karlsruhe/ckanext-extractor#egg=ckanext-extractor
RUN ckan-pip install -r $CKAN_VENV/src/ckanext-extractor/requirements.txt

#Add ckanext-pdfview
RUN ckan-pip install ckanext-pdfview

# Add ckanext_bodik_theme28 & run it
ADD ./ckanext-bodik_theme28 $CKAN_VENV/src/ckanext-bodik_theme28
# RUN cd $CKAN_VENV/src && chown -R ckan:ckan ckanext-bodik_theme
# RUN cd $CKAN_VENV/src/ckanext-bodik_theme && $CKAN_VENV/bin/python setup.py develop

##########################
# Install and setup others
##########################
# Add custom_options.ini
ADD ./custom_options.ini $CKAN_CONFIG/custom_options.ini

# Add ckan i18n
ADD ./i18n $CKAN_VENV/src/ckan/ckan/i18n/ja/LC_MESSAGES

# Add ckan license
ADD ./license $CKAN_VENV/src/ckan/ckan

# Make filestore
RUN mkdir -p $CKAN_STORAGE_PATH/storage
RUN chown -R www-data:www-data $CKAN_STORAGE_PATH

# Supervisor
ADD ./ckan_harvesting.conf /etc/supervisor/conf.d/ckan_harvesting.conf

##########################
# Setup init code
##########################
# Change Configure
ADD ./my_init.d /etc/my_init.d
RUN chmod +x /etc/my_init.d/*

# Configure runit
ADD ./svc /etc/service

# Configure permission
RUN chmod +x /etc/service/ckan/run /etc/service/ckan_harvest_fetch_consumer/run /etc/service/ckan_harvest_gather_consumer/run /etc/service/cron-touch/run

##########################
# exec
##########################
CMD ["/sbin/my_init"]

EXPOSE 8080
