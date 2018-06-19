#!/bin/bash

find /var/www/backups/ -type f -mtime +14 -exec rm {} \;
