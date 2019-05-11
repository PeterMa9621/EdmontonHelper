# SimpleWebSite (Version 0.1)
## Currently it just has CRUD features

# Environment
### PHP
* Version: 7.2
### MySql
* Version: 5.7.24
* Workbench: Navicat Premium 12 (Free for Student Version)

# Before to clone it
## Install Wamp or Xampp - A very easy development environment (It includes both PHP and MySql)
* Go to website: http://www.wampserver.com/en/ or https://www.apachefriends.org/index.html
## After Installation
* Run Wamp or Xampp (make sure the port 80 and 3306 is available).
* For Xampp, you need to open the Xampp Control to start Apache and Mysql manually.
## initialize the database
* Create a database named 'Shop'.
* After create the database, run this query to create a table named 'users': create table users (uid char(20) PRIMARY KEY, psw char(30), email text).
# Clone it
* Go to the directory that you installed Wamp or Xampp, there is a folder named "www" for Wamp or "htdocs" for Xampp. This folder is used to contain all your php websites.
* Go to the folder named "www" or "htdocs".
* Run command "git clone https://github.com/PeterMa9621/ShopWebSite.git".
* For now, all my content should be in the folder.
# Run the website
* Go to http://127.0.0.1/user, you can see the user page.
