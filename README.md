# deesynertz/laravel-helper-kit

It suggests a collection of helper utilities specifically tailored for Laravel development

## Features

1. Session Helpers: for developer who want to use maltiple session in deferent time now you can use single helper and provide driver then it will config for you

### Installation

Using Composer run

```php
composer require deesynertz/laravel-helper-kit
```

### Laravel >= 5.5

That's it! The package is auto-discovered on 5.5 and up!

### Laravel <= 5.4

Add the service provider to the `providers` array in your `config/app.php` file:

```php
'providers' => [
    // Other Laravel service providers...

    /*
    * Package Service Providers...
    */
    Deesynertz\HelperKit\HelperKitServiceProvider::class,

    // Other package service providers...
],
```

### Usage

now we have some functions

#### Invoices Helpers

```php
invoiceTypeDisplay($invoice)
invoiceStatusDisplay($invoice)
```

## Contributions

Contributions and feedback are welcome! Feel free to open an issue or submit a pull request on GitHub.

## License

This package is open-source software licensed under the [MIT](https://github.com/deesynertz/laravel-helper-kit/blob/master/LICENSE) license.
