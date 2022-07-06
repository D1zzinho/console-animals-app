## Info:
1. Docker-container uses php8.1.7-fpm
2. PHP v8.1+ required to run app without docker

## How to start:
1. Open project in terminal and build php container using: `docker-compose up -d --build`
2. You can check built container details using: `docker ps`
3. You can also enter container console using exec interactive: `docker exec -it CONTAINER_NAME bash`
4. You can also run specific command using: `docker exec CONTAINER_NAME command`

## Dogs console manual:
1. Before calling specified command, check if console app works properly:
   1. To run app with your systems' php use: `php src/console.php`.
   2. To run app using built php container use: `docker exec CONTAINER_NAME php console.php`
   3. To run app using docker container interactive bash (when already connected into): `php console.php`
2. Get information about commands using: `php console.php help`

