<?php

$base_dir = 'uploads';
return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'app' => [
            'driver' => 'local',
            'root' => app_path() . DIRECTORY_SEPARATOR,
            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

    'upload' => [
        'max_size'  => 10240,   // kb
        'max_width' => 1080,    // px
        'max_height'=> 2160,    // px
        'quality'   => 60,
        'paths' => [
            'default'  => $base_dir . DIRECTORY_SEPARATOR,
            'user' => $base_dir . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR,
            'article' => $base_dir . DIRECTORY_SEPARATOR . 'articles' . DIRECTORY_SEPARATOR,
            'doctor' => $base_dir . DIRECTORY_SEPARATOR . 'doctors' . DIRECTORY_SEPARATOR,
            'vendor' => $base_dir . DIRECTORY_SEPARATOR . 'vendors' . DIRECTORY_SEPARATOR,
            'vendor_type' => $base_dir . DIRECTORY_SEPARATOR . 'vendor_types' . DIRECTORY_SEPARATOR,
        ],
    ],

];
