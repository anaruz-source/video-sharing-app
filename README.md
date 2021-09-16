# Todo List application
## based on  Symfony 4 & 5 Web Development Guide: Beginner To Advanced (Udemy)

## 1. installation

### Symfony installation (version 4.4.*)

---

Create a symfony project inside current directory
```
composer create-project symfony/skeleton ./ "4.4.*"
```

### maker/annotations  bundles installation

----

```
composer require symfony/maker-bundle --dev
composer require doctrine/annotations
```

### Create FrontConroller

---
```
bin/console make:controller FrontController
```

### if you get 404! (Apache case: because .htaccess is absent from your application)

---

do install symfony/apache-pack,  in case you could only visualize the root page (/)

```
composer require symfony/apache-pack
```

### Doctrine and Twig templating

---

```
composer require doctrine
composer require twig


```
### Install symfony/asset

---
if you get the following message
Did you forget to run "composer require symfony/asset"? Unknown function "asset".

```
 composer require symfony/asset
```

### Webpack-encore installation
```
$  composer require symfony/webpack-encore-bundle


$ yarn install
                                                                                                                                             12:13:07
```
### Database config and creation

---
### Installation (orm)


$ bin/console make:entity


 [ERROR] Missing package: to use the make:entity command, run:

         composer require orm

```
$  composer require orm
```


Some files have been created and/or updated to configure your new packages.
Please review, edit and commit them: these files are yours.

 doctrine/doctrine-bundle  instructions:

  * Modify your DATABASE_URL config in .env

  * Configure the driver (postgresql) and
    server_version (13) in config/packages/doctrine.yaml

#### configuration
Config consists to uncomment a mysql database and provide username, password and DB name! (.env file)

#### Creation

Following will create todo database (configured in .env)
```
bin/console doctrine:database:create
Created database `todo` for connection named default
```

#### if it errors out!

for this error:

```
An exception occurred in driver: could not find driver
```
check what pdo exentesions are installed, in case of error below, the required driver is not installed.
before:
```
#php -m | grep pdo
pdo_sqlite
```
This is the situation after installing required php extension (centos 8 and Rocky linux 8):

```
# dnf install php-pgsql
# dnf install php-mysqlnd

```
After

```
# php -m | grep pdo
pdo_mysql
pdo_pgsql
pdo_sqlite
```

### Making entities Category and Video
```
$ bin/console make:entity

]$ bin/console make:entity Video

 created: src/Entity/Video.php
 created: src/Repository/VideoRepository.php

 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > title

 Field type (enter ? to see all types) [string]:
 >

 Field length [255]:
 >

 Can this field be null in the database (nullable) (yes/no) [no]:
 >

 updated: src/Entity/Video.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > path

 Field type (enter ? to see all types) [string]:
 >

 Field length [255]:
 >

 Can this field be null in the database (nullable) (yes/no) [no]:
 >

 updated: src/Entity/Video.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > category

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Category

What type of relationship is this?
 ------------ ---------------------------------------------------------------------
  Type         Description
 ------------ ---------------------------------------------------------------------
  ManyToOne    Each Video relates to (has) one Category.
               Each Category can relate to (can have) many Video objects

  OneToMany    Each Video can relate to (can have) many Category objects.
               Each Category relates to (has) one Video

  ManyToMany   Each Video can relate to (can have) many Category objects.
               Each Category can also relate to (can also have) many Video objects

  OneToOne     Each Video relates to (has) exactly one Category.
               Each Category also relates to (has) exactly one Video.
 ------------ ---------------------------------------------------------------------

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Video.category property allowed to be null (nullable)? (yes/no) [yes]:
 >

 Do you want to add a new property to Category so that you can access/update Video objects from it - e.g. $category->getVideos()? (yes/no) [yes]:
 >

 A new property will also be added to the Category class so that you can access the related Video objects from it.

 New field name inside Category [videos]:
 >

 updated: src/Entity/Video.php
 updated: src/Entity/Category.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 >



  Success!


 Next: When you're ready, create a migration with php bin/console make:migration



### Making migrations
[anaruz@localhost netprogs.pl]$ bin/console make:migration



  Success!


 Next: Review the new migration "migrations/Version20210911131232.php"
 Then: Run the migration with php bin/console doctrine:migrations:migrate
 See https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html
[anaruz@localhost netprogs.pl]$ bin/console doctrine:migration:migrate

 WARNING! You are about to execute a migration in database "netprogs.pl" that could result in schema changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:
 >

[notice] Migrating up to DoctrineMigrations\Version20210911131232
[notice] finished in 89.8ms, used 6M memory, 1 migrations executed, 10 sql queries


```
### Data (Fixtures)

[anaruz@localhost netprogs.pl]$ bin/console make:fixtures


 [ERROR] Missing package: to use the make:fixtures command, run:

         composer require orm-fixtures --dev


[anaruz@localhost netprogs.pl]$      composer require orm-fixtures --dev


Some files have been created and/or updated to configure your new packages.
Please review, edit and commit them: these files are yours.

[anaruz@localhost netprogs.pl]$ bin/console make:fixtures

 The class name of the fixtures to create (e.g. AppFixtures):
 > CategoryFixtures

 created: src/DataFixtures/CategoryFixtures.php


  Success!


 Next: Open your new fixtures class and start customizing it.
 Load your fixtures by running: php bin/console doctrine:fixtures:load
 Docs: https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
### More updates to website!
ConrollerToDoListController
::create method updated with necessary code persist tasks!
::switchSatus to update status of a task
::delete to delete a task.
in delete method parameter converter is used, to allow this, install
```
$ composer require sensio/framework-extra-bundle
```


### debug tools!
composer require profiler --dev
composer require symfony/debug-bundle --dev


### Form

$ bin/console make:form


 [ERROR] Missing packages: to use the make:form command, run:

         composer require form validator


$   composer require form validator



Some files have been created and/or updated to configure your new packages.
Please review, edit and commit them: these files are yours.
$ bin/console make:form

 The name of the form class (e.g. GrumpyKangarooType):
 > CategoryType

 The name of Entity or fully qualified model class name that the new form will be bound to (empty for none):
 > Category
