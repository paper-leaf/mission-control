<?php

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
            'link' => sprintf("https://paper-leaf-1x.sentry.io/issues?environment=%s&project=%s", config('app.env', 'not set'), 'sentry-id'),
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
