# Base Laravel/Vue Stack

This is a base stack to build web applications, composed by a Laravel API and a SPA written using VueJS.

There is also a docker-compose based environment config on the env folder.

## Requirements
* docker
* docker-compose
* vue-cli
* yarn

To use the env, follow those steps:

* Clone the repo;
* Go to the env folder;
* To bring the API up, run the commands:
  * `docker-compose build`
  * `docker-compose run api "cp .env.example .env"`
  * `docker-compose run api "composer install"`
  * `docker-compose run api "php artisan migrate --seed"`
  * `docker-compose up -d`
* To start the SPA, inside the spa folder, run the commands:
  * `yarn install`
  * `vue ui`
* Inside the web-ui that will open, navigate to **Tasks** > **Serve**, and click on **Run Task**
