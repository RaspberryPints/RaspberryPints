# base image is stratolinux/baseimage-docker
FROM stratolinux/baseimage-docker:0.9.19
MAINTAINER Eric Young <eric@stratolinux.com>

# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]

# To get rid of error messages like "debconf: unable to initialize frontend: Dialog":
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

RUN echo "deb http://archive.ubuntu.com/ubuntu trusty multiverse" >> /etc/apt/sources.list
RUN apt-get -qy update && apt-get -qy -o DPkg::Options::=--force-confdef  upgrade

# ports
EXPOSE 80

# Fix a Debianism of the nobody's uid being 65534
RUN usermod -u 99 nobody && \
    usermod -g 100 nobody

# install the php5.x repo
RUN locale-gen en_US.UTF-8
RUN LC_ALL=en_US.UTF-8  add-apt-repository ppa:ondrej/php

# update apt and install dependencies etc....
RUN apt-get update && \
    apt-get install -qy git wget unzip apache2 php5.6 php5.6-mysql php5.6-mbstring

# Enable apache mods.
RUN a2enmod php5.6 && \
    a2enmod rewrite

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/5.6/apache2/php.ini && \
    sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/5.6/apache2/php.ini

# fetch raspberry pints
ADD pints /var/www/pints
RUN chown -R www-data:www-data /var/www/pints

VOLUME /var/www/pints/data

COPY etc/ /etc/

RUN chmod +x /etc/my_init.d/*
RUN find /etc/service -name run -exec chmod +x {} \;

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
