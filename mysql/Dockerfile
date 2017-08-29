FROM mysql:5.7

RUN rm -rf /var/log/mysql && mkdir -p /var/log/mysql && chown -R mysql:mysql /var/log/mysql
ADD conf.d /etc/mysql/conf.d
ADD wordpress.sql /docker-entrypoint-initdb.d

CMD ["--general-log=true","--general-log-file=/var/log/mysql/mysql.log"]
