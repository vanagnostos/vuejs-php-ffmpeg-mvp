<p align="center">
<img width="1691" alt="image" src="https://github.com/vanagnostos/vuejs-php-ffmpeg-mvp/assets/16326125/36d73c27-ca99-4488-91e8-5be3180aa5e4">
</p>

### Assumptions

This is only a test project, so it does not use any external PHP libraries. In a real application, some parts (such as request/response handling, routing, DI, etc) 
could be done by using 3rd party libraries and/or framework.

The project scope does not include features like authentication, logging, cache, rate limiting.  

There are some [tests](backend/test/Unit) implemented but a real project should aim for much bigger coverage. Acceptance/functional tests would be useful as well.

The backend API is able to consume directly raw files and convert them on the fly but is currently configured to use processed data (this can be easily changed in [WaveformResourceFactory](backend/src/Api/Resource/Waveform/WaveformResourceFactory.php)). 

Data preprocessing is implemented as a simple [cron script](backend/cron/consumer.php). In real life it may require different implementation. For example, it would perhaps receive the new raw data from 
external service (messaging?). It also could be distributed on many servers, depending on the required capacity, load, etc. There are some related notes in the file too.

### (Invalid) raw data handling

There are three easily configurable options available for raw [data handling](backend/src/Ffmpeg/Loader). 

First one assumes valid input files and does very basic checks. 

Second and third one do more advanced checks (like whether silence_(start|end) alternate in the expected order) and are able to correct some errors by ignoring invalid 
lines and/or by correcting timing errors. 

In a real project, large number of test input files would be required to evaluate as many as possible data issues that may exist. Also, the exact error handling strategy 
should depend on the business requirements and should be a team decision (product owner, business analysts, developers...).   

### Backend 

 - checkout code
 - cd to ./backend directory
 - run "composer install"
 - run "composer serve" to test it using PHP's built-in server
 - run "composer unit-test" to execute the unit tests

### Data preprocessing

 - raw data is stored in backend/data/raw/[conversation id]
 - parsed data is stored in backend/data/parsed/[conversation id]
 - to convert raw files into processed data, cd to ./backend directory and run "php -f cron/consumer.php"

### Frontend

 - checkout code
 - cd to ./frontend directory
 - run "npm install"
 - optionally update the backend API base URL in ./frontend/.env file
 - run "npm run dev" to run it in dev move
 - OR run "npm run build" && "npm run preview" to build and run compiled version
 
Implemented/tested using node v19.9.0, npm 9.6.3, php 7.4
