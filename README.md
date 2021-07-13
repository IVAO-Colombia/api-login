# ivao-socialite
![GitHub release (latest by date)](https://img.shields.io/github/v/release/ivao-brasil/ivao-socialite)
![Test](https://github.com/ivao-brasil/ivao-socialite/workflows/Test/badge.svg)
![GitHub](https://img.shields.io/github/license/ivao-brasil/ivao-socialite)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ivao-brasil_ivao-socialite&metric=alert_status)](https://sonarcloud.io/dashboard?id=ivao-brasil_ivao-socialite)
[![Packagist Version](https://img.shields.io/packagist/v/ivao-brasil/ivao-socialite)](https://packagist.org/packages/ivao-brasil/ivao-socialite)

A [Laravel Socialite](https://laravel.com/docs/master/socialite) Provider for IVAO.

## Getting Started

In order to use this package in your Laravel projects, you must first install it. The recommended way to install this package is through Composer.
```bash
composer require ivao-brasil/ivao-socialite
```

After that, you must add the configuration in your Laravel config file, such as any other Socialite Provider. In order to do it, head over to your `config/services.php` file and add the following session:
```php
"ivao" => [
    "redirect" => "/your-callback"
]
```
This callback will be the URL which will be forwarded by IVAO Login API. You can use either an URL or a route path in configuration.

After that, you're good to go. You can use it in your code as any other Socialite Provider.

```php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class IvaoLoginController
{
    public function redirect()
    {
        return Socialite::driver('ivao')->redirect();
    }

    public function callback()
    {
        $ivaoUser = Socialite::driver('ivao')->user()->getRaw();

        Auth::login(new User($ivaoUser));

        return redirect()->to('home');
    }
}
```

Note that due to restrictions on IVAO API, Socialite user instance is heavily limited: only `getId` and `getName` methods are implemented. We recommend you use the `getRaw()` method, which will return you an associative array with the parsed Login API data. When you call it, you will get something like:
```php
[
  "vid" => 385415,
  "firstName" => "Joao Pedro",
  "lastName" => "Henrique",
  "administrativeRating" => 2,
  "atcRating" => 5,
  "pilotRating" => 5,
  "division" => "BR",
  "country" => "BR",
  "staff" => [ "BR-AWM", "WD9" ]
]
```

In case no User Data can be extracted from the API with the provided token, the Socialite `user` method will return `null`. 

## Issues and contributions
If you found an error/bug/bad behavior, feel free to open an issue reporting it. Also, pull requests are welcome and pretty much appreciated.

## License
This project is [MIT Licensed](LICENSE).
