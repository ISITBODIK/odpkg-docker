FROM phusion/baseimage:0.9.10
MAINTAINER Open Knowledge

# Disable SSH
RUN rm -rf /etc/service/sshd /etc/my_init.d/00_regen_ssh_host_keys.sh

ENV HOME /root
ENV CKAN_HOME /usr/lib/ckan/default
ENV CKAN_CONFIG /etc/ckan/default
ENV CKAN_DATA /var/lib/ckan

# Install required packages
RUN apt-get -q -y update
RUN DEBIAN_FRONTEND=noninteractive apt-get -q -y install \
        python-minimal \
        python-dev \
        python-virtualenv \
        libevent-dev \
        libpq-dev \
        apache2 \
        libapache2-mod-wsgi \
        build-essential \
        git \
        expect

# Install CKAN
RUN virtualenv $CKAN_HOME
RUN mkdir -p $CKAN_HOME $CKAN_CONFIG $CKAN_DATA
RUN chown www-data:www-data $CKAN_DATA

ADD ./ckan/requirements.txt $CKAN_HOME/src/ckan/requirements.txt
RUN $CKAN_HOME/bin/pip install -r $CKAN_HOME/src/ckan/requirements.txt
ADD ./ckan $CKAN_HOME/src/ckan/
RUN $CKAN_HOME/bin/pip install -e $CKAN_HOME/src/ckan/
RUN ln -s $CKAN_HOME/src/ckan/ckan/config/who.ini $CKAN_CONFIG/who.ini
ADD ./ckan/contrib/docker/apache.wsgi $CKAN_CONFIG/apache.wsgi

# Configure apache
ADD ./ckan/contrib/docker/apache.conf /etc/apache2/sites-available/ckan_default.conf
RUN echo "Listen 8080" > /etc/apache2/ports.conf
RUN a2ensite ckan_default
RUN a2dissite 000-default

#Install Tracking
RUN echo "0 5 * * * root $CKAN_HOME/bin/paster --plugin=ckan tracking update -c $CKAN_CONFIG/ckan.ini >/dev/null 2>&1 && $CKAN_HOME/bin/paster --plugin=ckan search-index rebuild -c $CKAN_CONFIG/ckan.ini >/dev/null 2>&1" >> /etc/cron.d/ckan-cron

# Install ckanext-basiccharts
RUN git clone https://github.com/ckan/ckanext-basiccharts.git $CKAN_HOME/src/ckanext-basiccharts
RUN cd $CKAN_HOME/src/ckanext-basiccharts && $CKAN_HOME/bin/python setup.py install

# Install ckanext-harvent
RUN $CKAN_HOME/bin/pip install -e git+https://github.com/ckan/ckanext-harvest.git#egg=ckanext-harvest
RUN $CKAN_HOME/bin/pip install -r $CKAN_HOME/src/ckanext-harvest/pip-requirements.txt
RUN echo "*/15 * * * * root $CKAN_HOME/bin/paster --plugin=ckanext-harvest harvester run -c $CKAN_CONFIG/ckan.ini >/dev/null 2>&1"  >> /etc/cron.d/ckan-cron
RUN echo "0 3 * * * root $CKAN_HOME/bin/paster --plugin=ckanext-harvest harvester clean_harvest_log -c $CKAN_CONFIG/ckan.ini >/dev/null 2>&1" >> /etc/cron.d/ckan-cron
RUN chmod 0600 /etc/cron.d/ckan-cron
RUN touch /var/log/cron.log

# Install ckanext-dcat
RUN $CKAN_HOME/bin/pip install -e git+https://github.com/ckan/ckanext-dcat.git#egg=ckanext-dcat
RUN $CKAN_HOME/bin/pip install -r $CKAN_HOME/src/ckanext-dcat/requirements.txt

# Install ckanext-googleanalytics
RUN $CKAN_HOME/bin/pip install -e git+https://github.com/ckan/ckanext-googleanalytics.git#egg=ckanext-googleanalytics

#Add ckanext-googleanalytics
ADD ./ckanext-googleanalytics $CKAN_HOME/src/ckanext-googleanalytics

# Add ckanext_bodik_theme & run it
ADD ./ckanext-bodik_theme $CKAN_HOME/src/ckanext-bodik_theme

# Add custom_options.ini
ADD ./custom_options.ini $CKAN_CONFIG/custom_options.ini

# Add ckan i18n
ADD ./i18n $CKAN_HOME/src/ckan/ckan/i18n/ja/LC_MESSAGES

# Add ckan license
ADD ./license $CKAN_HOME/src/ckan/ckan

# Change Configure
ADD ./my_init.d /etc/my_init.d
RUN chmod +x /etc/my_init.d/*

# Configure runit
ADD ./svc /etc/service

# Make filestore
RUN mkdir -p $CKAN_DATA/filestore
RUN chown -R www-data:www-data $CKAN_DATA

# Configure permission
RUN chmod +x /etc/service/ckan/run /etc/service/ckan_harvest_fetch_consumer/run /etc/service/ckan_harvest_gather_consumer/run /etc/service/cron-touch/run

CMD ["/sbin/my_init"]

EXPOSE 8080

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
