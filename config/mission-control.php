<?php

// config for PaperLeaf/MissionControl
return [
    /*************************************
     * FILE STORAGE
     *************************************/

    'file_storage' => [
        // If you store your files in a specific directory within the bucket (e.g. per environment) specify that here
        // You can get the prefix from your URL on S3 e.g. https://ca-central-1.console.aws.amazon.com/s3/buckets/name-of-bucket?prefix=prefix-here%2F
        'aws_folder_prefix' => \Illuminate\Support\Str::upper(config('app.env', 'not set')),
    ],
];
