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
# Usage: Trait in Models

- Add the UsesSnowflake trait to any Eloquent model to automatically generate IDs:
``` php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haritsyp\Snowflake\UsesSnowflake;

class Order extends Model
{
    use UsesSnowflake;

    public $incrementing = false; // disable auto-increment
}
```
- Now, whenever you create a new Order:
``` php
$order = Order::create([
    'name' => 'Sample Order',
    'amount' => 1000,
]);

echo $order->id; 
```
# Parsing Snowflake IDs
You can parse a generated ID to get its components:
``` php
$snowflake = app(Haritsyp\Snowflake\Snowflake::class);
$parsed = $snowflake->parse($order->id);

print_r($parsed);
/*
[
    'timestamp' => 1612224000000,
    'datacenter_id' => 1,
    'node_id' => 1,
    'sequence' => 0,
    'datetime' => '2021-02-02 00:00:00'
]
*/ 
```
[ico-version]: https://img.shields.io/badge/packagist-1.0-brightgreen
[ico-license]: https://img.shields.io/badge/license-MIT-green
[link-packagist]: https://packagist.org/packages/haritsyp/laravel-snowflake