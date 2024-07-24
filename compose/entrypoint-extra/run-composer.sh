#!/bin/bash

cd /var/www/html/wp-content/plugins/EthosDynamics365IntegrationPlugin

composer install

cd /var/www/html

exec /usr/local/bin/docker-entrypoint.sh apache2-foreground
