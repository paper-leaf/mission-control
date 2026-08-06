# Mission Control

[![Latest Version on Packagist](https://img.shields.io/packagist/v/paper-leaf/mission-control.svg?style=flat-square)](https://packagist.org/packages/paper-leaf/mission-control)
[![Total Downloads](https://img.shields.io/packagist/dt/paper-leaf/mission-control.svg?style=flat-square)](https://packagist.org/packages/paper-leaf/mission-control)

Mission Control is the command center for your Laravel application, giving you a clear view of your site's systems, integrations, and environment. Monitor key services, inspect application details, and perform essential maintenance tasks from one convenient location.

## Installation

You can install the package via composer:

```bash
composer require paper-leaf/mission-control
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the plugin's views to your theme css file or your app's css file if using the standalone packages.

```css
@source '../../../../vendor/paper-leaf/mission-control/resources/**/*.blade.php';
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="mission-control-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mission-control-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="mission-control-views"
```

This is the contents of the published config file:

```php
return [
    /*************************************
     * FILE STORAGE
     *************************************/

    'file_storage' => [
        // If you store your files in a specific directory within the bucket (e.g. per environment) specify that here
        // You can get the prefix from your URL on S3 e.g. https://ca-central-1.console.aws.amazon.com/s3/buckets/name-of-bucket?prefix=prefix-here%2F
        'aws_folder_prefix' => \Illuminate\Support\Str::upper(config('app.env', 'not set')),
    ],

    /*************************************
     * MONITORING
     *************************************/

    // Connects the site to the different monitoring packages that are installed (or SHOULD be installed)
    'monitoring' => [
        'sentry' => [
            'label' => 'Sentry',
            'link' => sprintf("https://paper-leaf-1x.sentry.io/issues?environment=%s&project=4511457401307136", config('app.env', 'not set')),
            'package_type' => 'composer',
            'package_name' => 'sentry/sentry-laravel',
        ],

        'horizon' => [
            'label' => 'Horizon',
            'link' => '/horizon',
            'package_type' => 'composer',
            'package_name' => 'laravel/horizon',
            'status_function' => 'horizonStatus',
        ],

        'health' => [
            'label' => 'Laravel Health',
            'package_type' => 'composer',
            'package_name' => 'spatie/laravel-health',
        ],

        'ray' => [
            'label' => 'Ray',
            'package_type' => 'composer',
            'package_name' => 'spatie/laravel-ray',
        ],

        'debugbar' => [
            'label' => 'Debugbar',
            'package_type' => 'composer',
            'package_name' => 'barryvdh/laravel-debugbar',
            'status_function' => 'envStatus',
            'param' => 'DEBUGBAR_ENABLED',
        ],

        'wirespy' => [
            'label' => 'WireSpy',
            'package_type' => 'composer',
            'package_name' => 'wire-elements/wire-spy',
            'status_function' => 'envStatus',
            'param' => 'WIRE_SPY_ENABLED',
        ],

        // Any other packages that are managed outside of Composer can be added manually
        // 'atatus' => [
        //     'label' => 'Atatus',
        //     'is_installed' => true,
        //     'version' => '123',
        // ],
    ],
];
```

## Usage

Register the plugin in your panel provider to add the Mission Control dashboard to your Filament panel.

```php
->plugin(
    MissionControlPlugin::make()
)
```

Once registered, you can optionally customize how the page appears within your panel using any of the following options.

```php
->plugin(
    MissionControlPlugin::make()
        ->pageTitle('Custom Heading')
        ->pageSubheading('Custom subheading content, page description')
        ->pageIcon('heroicon-o-custom-icon')
        ->pageCluster(Cluster::class)
)
```

## Credits

- [Sarah Tinga](https://github.com/s-tinga)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
