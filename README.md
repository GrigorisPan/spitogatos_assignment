# Assignment - PHP Project
This project is about an ad management system. It was created with PHP, Javascript, MySQL and TailwindCSS. 
At this project a user can sign up, log in and create/delete a house ad.  

## Installing / Getting started

In order to execute the code you have to follow the steps below:

### Building
#### After the download it is mandatory to place the project in a web server and run inside the project folder the command
```shell
npm install
```
### Database
#### Create a database named "spitogatos"
![spitogatos_db](https://github.com/GrigorisPan/spitogatos_assignment/assets/32704151/ded7a43c-e0af-4fae-8b5a-f402dfbac4cb)

#### Import the files existed in the folder "spitogatos_db". These files contain the code for the creation of the tables. 

#### For the connection of the database with project change the settings of the file "db.php" with your data in the folder "config".

```shell
<?php
return [
  'host' => 'Your Host Name',
  'port' => 'Your DB Port',
  'dbname' => 'Your DB Name',
  'username' => 'Your Username',
  'password' => 'Your Password'
];
```

## Licensing
