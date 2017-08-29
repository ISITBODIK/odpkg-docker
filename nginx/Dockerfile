FROM nginx:latest

# Setting nginx
ADD nginx.conf /etc/nginx/nginx.conf
RUN mkdir /etc/nginx/ssl
ADD ./ssl /etc/nginx/ssl
RUN chmod -R 600 /etc/nginx/ssl

# Add the script that will start the container.
COPY entrypoint.sh /entrypoint.sh
RUN chmod 755 /entrypoint.sh

# Expose the Ports
EXPOSE 443

CMD ["/bin/bash", "/entrypoint.sh"]
