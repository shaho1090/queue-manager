### Queue Manager Module

#### Installation 

After cloning the repository go the project directory and run:
```
$ cp .env.example .env
```
You need to have docker and docker compose on your local machine.So,
After having .env file run:
```
$ docker-compose up -d 
```
#### Usage
To run commands inside docker container please type the following:
```
$ docker exec -it --user qmuser queue-manager-app-1 /bin/bash
```
Now you can run:
```
$ composer install
```
Then run: 
```
$ php artisan migrate
```
And to have some users to test run:
```
$ php artisan db:seed
```
#### APIs
I have prepared two examples to test running tasks asynchronously. These the endpoints you can run with Postman or Insomnia:   
* Example one: deleting inactive users without any request's body
````
DELETE METHOD : localhost:8082/users/inactive/delete
````
* Example two: verifying selected user emails:
```
POST METHOD : localhost:8082/users/email/verify
```
The request is: 
```json
 {
    "user_ids" : [
        3,6,9
    ]
 }
```
After running this examples, you can check the database to have corresponding records:
```
GET METHOD : http://localhost:8082/tasks
```
And finally to run the tasks in the background you can run this command inside the container you entered before:
```
$ php artisan task-queue:run
```
Also, you can use phpmyadmin service through this address using your browser:
```
http://localhost:8088/
```
