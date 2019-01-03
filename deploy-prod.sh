#!/bin/bash
drush sset system.maintenance_mode 1
drush cr
git pull origin master
composer install --no-dev
drush cr
drush updb
drush cr
drush csex -y
drush cim -y
drush cr
drush sset system.maintenance_mode 0
drush cr
