FROM orchardup/postgresql

#set localedef
RUN localedef -i ja_JP -c -f UTF-8 -A /usr/share/locale/locale.alias ja_JP.UTF-8

#Set timezone
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN dpkg-reconfigure -f noninteractive tzdata

# Add postgresql.conf
ADD postgresql.conf /etc/postgresql/9.3/main/postgresql.conf
RUN chown postgres:postgres /etc/postgresql/9.3/main/postgresql.conf

#Config permission of logs
RUN rm -rf /var/log/postgresql && mkdir -p /var/log/postgresql && chown -R postgres:postgres /var/log/postgresql


#add dbcreate script
ADD run /usr/local/bin/run
RUN chmod +x /usr/local/bin/run
