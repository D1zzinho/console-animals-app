FROM php:8.1.7-fpm

WORKDIR /home/console-animals-app

RUN apt-get update
RUN apt-get install -y nano mc
RUN apt-get -y dist-upgrade

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -p $(openssl passwd -1 docker) docker
