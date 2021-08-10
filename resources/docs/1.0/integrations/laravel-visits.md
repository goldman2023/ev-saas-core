# Laravel Visits

This section includes all the details about tracking visits for a certain eloquent model.

This project uses [Laravel Visits](https://awssat.com/opensource/laravel-visits/) \
⚠ this package offers two type of storing visits eloquent and redis 
# Hardwiring a model with a Laravel Visits
1- go to `Blog.php`
```php
  public function visit()
    {
        return visits($this)->relation();
    }
```
and later on if you would like to increment a certain Model in our case `Blog`
```php
$blog = Blog::findOrFail(1);
visits($blog)->increment();
// in case you would like to categories increments
//for instance increment counter for login users 
visits($blog,"auth")->increment();
```
to retrieve counts 
```php
$blog = Blog::findOrFail(1);
visits($blog)->count();
// in case you would like to categories increments
//for instance increment counter for login users 
visits($blog,"auth")->count();
```
