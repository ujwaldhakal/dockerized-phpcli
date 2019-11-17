## Deputy Coding Task
A simple array search is performed for chained parent/child relation using php.

## Installation
* `git clone https://github.com/ujwaldhakal/deputy-php-test`
* `sudo docker-compose up -d` this will download image and setup a working container
* `docker exec -i php-unit-test composer install` this will go inside a container and run given command `composer install`


## Usage
* To get user info `docker exec -it php-unit-test php UserInfo.php $userId` this will output data on array
* To run tests `docker exec -it php-unit-test vendor/bin/phpunit`


## Folder Structure
All working application codes resides here
* A domain can have
  + app
    + Datasource
        + Interfaces
    + Domains
    + Exceptions
  + tests
    + unit
    
* DataSource -: This directory contains datasource to playwith we could also say simple database version
* Datasource/Interfaces -: All interfaces working with datasource resides here just to make sure we type correct bindings. 
* Domains -: All business logic resides here
* Exceptions -: Custom exception handler for our domains
* tests/unit -: All our unit tests will reside here



Note -: A bit over engineering has been done for setting up a architecture for this task. 

Suggestions / feedbacks are heartly welcome please do let me know. 
