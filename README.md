# Haritsyp\Snowflake

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)

Snowflake ID generator for Laravel, supports int64 & Base62.

## Install 

In your terminal:

``` bash
# install the package
composer require haritsyp/laravel-snowflake
```

- if you are using laravel <= 5.5, add the following snippet to the config/app.php file under the providers section as follows:
``` php
// Add this line
'providers' => [
    // Laravel default providers
    App\Providers\AppServiceProvider::class,
    // ...
    
    Haritsyp\Snowflake\SnowflakeServiceProvider::class,
],

```

[ico-version]: https://img.shields.io/badge/packagist-1.0-brightgreen
[ico-license]: https://img.shields.io/badge/license-MIT-green
[link-packagist]: https://packagist.org/packages/haritsyp/laravel-snowflake