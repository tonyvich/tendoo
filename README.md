# Tendoo CMS
Tendoo CMS 5 is a new version of Tendoo CMS build with CodeIgniter.
The purpose of this project is to share with other the skill i've earned during my professional life on CodeCanyon and providing a
better tool to create web application with all outstanding Laravel/Vue2/Bootstrap-Material features.

# Getting Started
You can use this project as any regular laravel installation. 
## 1 - Git Clone or Download
To get started, all you have to do is to download the project from Github by cloning or by downloading.

## 2 - composer install
Install all dependencies to get started quicky.

## 3 - Open the browser at http://localhost:8000/do-setup
Now all you have to do, is to follow the setup instructions

## 4 - Login to the dashboard
Now you have the project installed. You can starte reading the documentation on https://tendoo-cms.readme.io/v5.0
The documentation is currently written as we add/remove feature. 

# How to get involved
Just fork the project and send your pull request :). 
The code is commented and we do follow PSR-2, PSR-4 Standars, hope you're skilled.

# Internal Features

## 1 - Generating a module
`php artisan make:module`

## 2 - Generating a migration for a module

`php artisan module:migration Foo`

Where 'Foo' is the module namespace. You'll have to input the release under which you would like to run a migration. You can input 1.0, as well as 10.5
Then you'll have to provide the migration file name, which will be used as the migration class name as well, like so :

`Create Some Migration Table`

You can create table and table columns like so :

`Create Some Migration Table --table=foo --schema=name:string|birth_date:datetime|role_id:integer`

## 3 - Generating a controller for a module
`php artisan module:controller Foo WhatEverController`

## 4 - Deleting all controllers for a module
`php artisan module:controller Foo --delete=all`
You'll have to confirm your action.

## 5 - Creating Model for modules
`php artisan module:model {module_namespace} {model_name}`
Create a model on the module Model folder.

## 6 - Managing options from CLI
### A - Set a value
`php artisan option:set {key} --v={value}`
### B - Delete a value
`php artisan option:delete {key}`

this will launch the module generator command where you'll have to provide namespae, name, author and description. the default verison is set to 1.0.
We'll add more generator to generate : 
- Settings Pages
- Crud Pages
- Fields Options
...
