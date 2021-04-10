## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```
4. Import `my-db-model.sql` in your SQL server,
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.
7. From this starter kit, create your own web application.

## URLs availables

* Home page at [localhost:8000/](localhost:8000/)
* Articles list at [localhost:8000/article/index](localhost:8000/article/index)
* Article details [localhost:8000/article/index/show/:id](localhost:8000/article/show/2)
* Article edit [localhost:8000/article/index/edit/:id](localhost:8000/article/edit/2)
* Article add [localhost:8000/article/index/add](localhost:8000/article/add)
* Article deletion [localhost:8000/article/index/delete/:id](localhost:8000/article/delete/2)
* Categories list at [localhost:8000/categorie/index](localhost:8000/categorie/index)
* Categorie details [localhost:8000/categorie/index/show/:id](localhost:8000/categorie/show/2)
* Categorie edit [localhost:8000/categorie/index/edit/:id](localhost:8000/categorie/edit/2)
* Categorie add [localhost:8000/categorie/index/add](localhost:8000/categorie/add)
* Categorie deletion [localhost:8000/categorie/index/delete/:id](localhost:8000/categorie/delete/2)

