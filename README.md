
# Project Title

mini blog project that have users, tags , posts models


## Perquisites
- PHP version +8.1

- Git 
## getting started steps

To deploy this project run

1- Clone the project for github 
```bash
git clone https://github.com/ahmedabdelaziz11/blog.git
```
2. Move to the project folder 
        
```bash
cd blog
```

3. Run Composer install in the project folder

```bash
composer install
```

4. Copy .env.example file in the project folder

```bash
cp .env.example .env
```
5. create file with name database.sqlite in database folder
>  edit the following in your .env file

```env
DB_CONNECTION=sqlite
```

6. Run the following commands in same sequence

```bash
php artisan key:generate
php artisan serve
```

7. open open the following link

<http://localhost:8000>


##To test the Job manually, you can run the following Artisan command:
```bash
php artisan queue:work --once
```
## API Reference

you can find all api links and data in this Postman [link](https://documenter.getpostman.com/view/25927491/2s9XxtxvEc)
