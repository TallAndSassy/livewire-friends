# Helper tools to make livewire play nicely with... stuff.
[![License](https://img.shields.io/github/license/:tallandsassy/:livewire-friends)](https://github.com/:tallandsassy/:livewire-friends/blob/master/LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/:tallandsassy/:livewire-friends.svg?style=flat-square)](https://packagist.org/packages/:tallandsassy/:livewire-friends)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/:tallandsassy/:livewire-friends/run-tests?label=tests)](https://github.com/:tallandsassy/:livewire-friends/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Coverage Status](https://coveralls.io/repos/github/:tallandsassy/:livewire-friends/badge.svg?branch=master)](https://coveralls.io/github/:tallandsassy/:livewire-friends?branch=master)

[![Total Downloads](https://img.shields.io/packagist/dt/:tallandsassy/:livewire-friends.svg?style=flat-square)](https://packagist.org/packages/:tallandsassy/:livewire-friends)


This is a collection of tools for working with livewire. 

## Support us

Please send love

## Installation

You can install the package via composer:

```bash
composer require tallandsassy/livewire-friends
```

## Usage: lwpmake
Makes a livewire component that works from within the package space.

Similiar to '<code>php artisan livewire:make SomeNewLivewireComponent</code>'


```bash
# Let your vendor name be 'TallAndSassy'
# Let your package name be 'GrokJetUi'
# Let your livewire component name be 'SomeNewLivewireComponent'

php artisan tassy:lwpmake TallAndSassy GrokJetUi SomeNewLivewireComponent

# You'll see something like:
    COMPONENT CREATED  🤙
    CLASS: vendor/tallandsassy/spatie-package17/src/Components/SomeNewLivewireComponent.php
    VIEW:  vendor/tallandsassy/spatie-package17/resources/views/livewire/some-new-livewire-component.blade.php
```
1) See the generated class for inline instructions on how to register this livewire component the app.
2) See the livewire.blade file for inline instructions on how to include this component into your own blades. 



We assume we're using the spatie package pattern (from their package course) of vendor name all lowercase
and package name as kebab case-ish.  If needed, you can override this pattern with the <code>--pathtopackage</code>
option. This seems to come up with funny things, like WordsNextToNumbers17
```bash
# Let your vendor name be 'TallAndSassy'
# Let your package name be 'SpatiePackage17'
# Let your livewire component name be 'SomeNewLivewireComponent'
# have your package at '<code>vendor/tallandsassy/spatie-package-17</code>' vs the expected '<code>vendor/tallandsassy/spatie-package17</code>'

php artisan tassy:lwpmake TallAndSassy SpatiePackage17 SomeNewLivewireComponent  --pathtopackage="vendor/tallandsassy/spatie-package-17"

# You'll see something like:
     COMPONENT CREATED  🤙

    CLASS: vendor/tallandsassy/spatie-package-17/src/Components/SomeNewLivewireComponent.php
    VIEW:  vendor/tallandsassy/spatie-package-17/resources/views/livewire/some-new-livewire-component.blade.php
```

Your livewire components can be deep, like State->City->Districts->Blocks->Party

```bash
php artisan tassy:lwpmake TallAndSassy SpatiePackage17 States/Cities/Districts/Blocks/Party  --pathtopackage="vendor/tallandsassy/spatie-package-17"

# COMPONENT CREATED  🤙
    CLASS: vendor/tallandsassy/spatie-package-17/src/Components/States/Cities/Districts/Blocks/Party.php
    VIEW:  vendor/tallandsassy/spatie-package-17/resources/views/livewire/states/cities/districts/blocks/party.blade.php
```


## Troubleshooting: lwpmake
if you see
```bash
 Access to undeclared static property: TallAndSassy\GrokJetUi\GrokJetUiServiceProvider::$blade_prefix
```
Yup, we're assuming $blade_prefix is a static property in your PackageServiceProvider. (TODO - make me a command line option)


## Assumptions
As of this writing, we assume... 
1) the livewire components (controllers) live in vendor/vendorname/my-package/src/Components...
2) the blade files are vendor/vendorname/my-package/resources/views/livewire...
3) Your MyPackageServiceProvider.php class has a static property $blade_prefix (The Tassy package install inserts this automatically)

## Testing

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:jjrohrer](https://github.com/JJRohrer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
