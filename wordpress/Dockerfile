FROM wordpress:4.7.3-php7.0-apache

RUN apt-get -q -y update
RUN DEBIAN_FRONTEND=noninteractive apt-get -q -y install \
         unzip

# Add php.ini
ADD php.ini /usr/local/etc/php/conf.d/

# Add wp-content
ADD ./wp-content /usr/src/wordpress/wp-content
RUN cd /usr/src/wordpress/wp-content/plugins && unzip -o './*.zip' 
RUN rm -f /usr/src/wordpress/wp-content/plugins/*.zip
RUN chown -R www-data:www-data /usr/src/wordpress/wp-content
