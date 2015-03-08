Smarty
======

This package lets you run Smarty3 on Laravel5 elegantly.

## Installation

```
composer require latrell/smarty dev-master
```

Update your packages with ```composer update``` or install with ```composer install```.


## Usage

To use the Smarty Service Provider, you must register the provider when bootstrapping your Laravel application. There are
essentially two ways to do this.

Find the `providers` key in `config/app.php` and register the Smarty Service Provider.

```php
    'providers' => [
        // ...
        'Latrell\Smarty\SmartyServiceProvider',
    ]
```

Then publish the config file with `php artisan vendor:publish`. This will add the file `config/latrell-smarty.php`. This config file is the primary way you interact with Smarty.

Then simply reference templates using the normal dot syntax of Laravel. 

For example to load smarty template `views/blog/post.tpl`, you would use `view('blog.post')`.

In Smarty `{include}` or `{extends}` tags, you should continue to use the full directory syntax, e.g. `{extends file="blog/post.tpl"}`.
