<p align="center">

</p>

This project is a simple PHP/Vuejs application that ...

This is only a test project, so it does not use any external PHP libraries. In a real application, some parts (such as request/response handling, routing, DI, etc) could be done by using 3rd party libraries and/or framework.

The project scope does not include features like authentication, logging, cache, rate limiting, etc.  

### Backend 

 - checkout code
 - cd to ./backend directory
 - run "composer install"
 - run "composer serve" to test it using PHP's built-in server
 - run "composer unit-test" to execute the unit tests

### Frontend

 - checkout code
 - cd to ./frontend directory
 - run "npm install"
 - optionally update the backend API base URL in ./frontend/.env file
 - run "npm run dev" to run it in dev move
 - OR run "npm run build" && "npm run preview" to build and run compiled version
 
Implemented/tested using node v19.9.0, npm 9.6.3, php 7.4
