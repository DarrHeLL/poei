#!/bin/bash

#Passage du site en mode maintenance
#drush sset system.maintenance_mode 1
drush config-set readonlymode.settings enabled 1 -y 
drush cr

#On fait un pull 
git pull origin master

#On lance l'installation du / des modules
composer install --no-dev
drush cr

#Mise en relation de la base de données
drush updb
drush cr

#Mise a jours des schémas des types d'entités
drush entup
drush cr

#Export des configs de prod
drush csex prod -y

#Import des configs
drush cim -y
drush cr

#Gestion des fichiers de config PROD dans git
git add config/prod
git commit -m "Ajout des fichiers de config PROD"
git push origin master

#Désactivation du mode maintenance
#drush sset system.maintenance_mode 0
drush config-set readonlymode.settings enabled 0 -y
drush cr
