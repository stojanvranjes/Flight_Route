# Flight_Routes

composer update

Start migrations for tables php artisan migrate

Start db:seed

Admin insert:

Admin

123456789
              
User Role insert (admin, regular)

For uploading files start queue - php artisan queue:work

# Routes API

REGISTER (POST) - api/user/register

first_name - required

last_name - required

name - required

password - required

email - optional

LOGIN (POST) - /api/user/login

name - required

password - required

LOGOUT (POST) - /api/user/logout

INSERT CITY (POST) - /api/insert_city

name - required

country - required

description - required

IMPORT AIRPORTS (POST) - api/import_airports

file - required

IMPORT ROUTES (POST) - api/import_routes

file - required

ADD COMMENT (POST) - /api/add_comment

comment - required

city_id - required

UPDATE COMMENT (POST) - /api/update_comment

comment - required

comment_id - required

DELETE COMMENT (DELETE) - /api/delete_comment

comment_id - required

GET TOWNS (POST) - /api/get_towns

search - optional

limit - optional

GET TOWNS (GET) - /api/get_route

city_id_from - required

city_id_to - required
