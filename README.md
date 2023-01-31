
# BookTalk


## Prerequiries
- PHP 6
- Composer
- NodeJs
- MySQL
- JWT
- VueJS
- Socket.io
- Redis

## Installation
- Clone the repository
- Build docker `docker-compose build`
- Run docker `docker-compose up`
- Run server Nodejs `cd NodeJS` `node server.js`
- Launch migrations with `php artisan migrate --seed`.
- Launch `php artisan db:seed --class=UserSeeder`
- Build front with `npm run dev`
- Run: `npm run watch`
- Database: http://127.0.0.1:8002/


## Usage

Log as admin with `superAdmin@gmail.com:secret` or as user with `user@test.com:secret`

