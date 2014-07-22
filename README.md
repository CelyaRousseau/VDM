VDM : Usage
=====
Extract the last 200 vdm from [viedemerde.fr](http://www.viedemerde.fr/) and access them via REST Api
```
$ php app/console vdm:flux
```
Installation
====

* clone this repository
```
git clone https://github.com/CelyaRousseau/VDM.git
```
* Install vendors
```
$ php composer.phar install
```
* Create your database and then modify app/config/parameters.yml file with your paramaters
* Update your database schema 
```
$ php app/console doctrine:schema:update --force
```
* execute the next command
```
$ php app/console vdm:flux
```
* Launch Api and have fun -> [ note : Think to configure your web server ! ]

```
$ php app/console router:debug | grep api
 get_posts                GET    ANY    ANY  /api/posts                        
 get_post                 GET    ANY    ANY  /api/posts/{id} 
 ```
