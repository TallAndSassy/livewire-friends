# :Helper tools to make livewire play nicely with... stuff.
[![License](https://img.shields.io/github/license/:tallandsassy/:livewire-friends)](https://github.com/:tallandsassy/:livewire-friends/blob/master/LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/:tallandsassy/:livewire-friends.svg?style=flat-square)](https://packagist.org/packages/:tallandsassy/:livewire-friends)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/:tallandsassy/:livewire-friends/run-tests?label=tests)](https://github.com/:tallandsassy/:livewire-friends/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Coverage Status](https://coveralls.io/repos/github/:tallandsassy/:livewire-friends/badge.svg?branch=master)](https://coveralls.io/github/:tallandsassy/:livewire-friends?branch=master)

[![Total Downloads](https://img.shields.io/packagist/dt/:tallandsassy/:livewire-friends.svg?style=flat-square)](https://packagist.org/packages/:tallandsassy/:livewire-friends)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

Please send love

## Installation

You can install the package via composer:

[ ] Make a local table for testing called 'tmp_laravel_package' (per 'phpunit.xml')

```bash
composer require tallandsassy/livewire-friends
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="TallAndSassy\LivewireFriends\LivewireFriendsServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="TallAndSassy\LivewireFriends\LivewireFriendsServiceProvider" --tag="config"
```

You can grok the routes (when .env(local)) by visiting 
    
http://test-tallandsassy.test/grok/TallAndSassy/LivewireFriends/string
http://test-tallandsassy.test/grok/TallAndSassy/LivewireFriends/controller

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$livewire-friends = new TallAndSassy\LivewireFriends();
echo $livewire-friends->echoPhrase('Hello, TallAndSassy!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:jjrohrer](https://github.com/:JJ Rohrer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
