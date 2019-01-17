<?php

return [
    // base settings
    'name' => env('APP_NAME', 'Statu'),
    'title' => 'Welcome to the <strong>' . env('APP_NAME', 'Statu') . '</strong> status page.',

    // date & time settings
    'date-format' => 'MMM Do, HH:mm',

    // time zone used by the CLI when asking for dates
    'input-time-zone' => 'Europe/Helsinki',

    // api settings

    // slash from current domain root. examples: https://status.tassu.me
    'api-base-url' => '/',

    'force-https-in-assets' => false,

    // please change these
    'api-keys' => array(
        'example-123',
        'app-5687'
    )
];
