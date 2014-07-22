VDM : Usage
=====

step1

```
$ php app/console vdm:flux
```

Installation
====

1. clone this repository
```
git clone https://github.com/CelyaRousseau/VDM.git
```
2. Install vendors
```
$ php composer.phar install
```
3. Create your database and then modify app/config/config.yml file with your paramaters
4. Update your database schema 
```
$ php app/console doctrine:schema:update --force
```
5. execute the next command
```
$ php app/console vdm:flux
```
6. Launch Api and have fun !

```
$ php app/console router:debug | grep api
 get_posts                GET    ANY    ANY  /api/posts                        
 get_post                 GET    ANY    ANY  /api/posts/{id} 
 ```
