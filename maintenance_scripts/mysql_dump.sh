#!/bin/bash
CUR_DB_HOST=localhost
CUR_DB_NAME=raspberrypints
CUR_DB_USER=beers
CUR_DB_PASS=beer
#make MySQL backup filename
BACKUPMYSQLFILE=/var/www/backups/raspberry-$(date +%Y-%m-%d).sql
#export Database
mysqldump -h localhost -u $CUR_DB_USER -p$CUR_DB_PASS $CUR_DB_NAME > $CUR_PATH$BACKUPMYSQLFILE
