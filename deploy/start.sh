!/bin/bash

sudo systemctl stop httpd
sudo systemctl start httpd
sudo systemctl stop php-fpm
sudo systemctl start php-fpm
sudo systemctl start awslogsd

