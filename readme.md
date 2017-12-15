# A phoquing time-tracker

Phoquing is a simple time-tracker made with Laravel 5.5 and VueJs


![screenshot](https://user-images.githubusercontent.com/3933375/34047393-6b391570-e1b0-11e7-96ad-d9f8bfa10d57.png)

## Requirements (laravel 5.5)
- Node & NPM installed
- Php >= 7.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation
Set up a vhost and set phoquing-folder/public as DocumentRoot
Clone the repository into  your folder  :

    git clone https://github.com/Fwagra/phoquing.git .
   
 Install dependencies :
  
    composer update
    npm run prod
    
  Migrate the tables : 
    
    php artisan key:generate
    php artisan migrate
    
 ## Features
 
 - Track your time and classify it by categories
 - Filter your tracks by a range of days
 - Gather all your comments for a category
 
 ![category_resume](https://user-images.githubusercontent.com/3933375/34047508-ba1e66d6-e1b0-11e7-88c1-847848d63083.gif)
