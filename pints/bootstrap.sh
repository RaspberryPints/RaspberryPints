#!/usr/bin/env bash

apt-get update
apt-get install -y apache2 php5 mysql-client php5-mysql
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant /var/www
fi

/etc/init.d/apache2 restart

