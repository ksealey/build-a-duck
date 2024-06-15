# Build-a-Duck (Bad)
Build-a-Duck allows you to build a duck. That's it.

## Setup
The local environment runs on docker. You can dowload that here: [https://www.docker.com/get-started/](https://www.docker.com/get-started/)

When docker is downloaded and started, clone the project and complete the following steps from the root of the project.

 - Start docker: 
    - Stop any existing containers: `docker stop $(docker ps -qa)`. 
    - Build the images: `docker-compose build --no-cache` This may take a while.
    - When the build is completed, run `docker-compose up -d`. 
 - Log into the web(apache) container: `docker exec -it bad_web bash`
 - Copy .env: `cp .env.example .env`
 - Install backend dependencies: `composer install`
 - Run migrations with seeders(Add indexes): `php artisan migrate --seed`
 - Link the storage folder: `php artisan storage:link`
 - Exit the container: `exit`
 - You'll need node v16+ for the front end
     - If you have at least v16 installed: 
         - `npm install`
         - `npm run dev`
     - If you don't have it installed, install it with nvm: [https://github.com/nvm-sh/nvm](https://github.com/nvm-sh/nvm) then:
         - `nvm use 18`
         - `npm install`
         - `npm run dev`
 - You should now see the application running at http://localhost
 
### Login

 - Username: `test@example.com`
 - Password: `password`