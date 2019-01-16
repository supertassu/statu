<?php

return [
    'name' => env('APP_NAME', 'Statu'),
    'title' => 'Welcome to the <strong>' . env('APP_NAME', 'Statu') . '</strong> status page.',
    'date-format' => 'MMM Do, HH:mm',
    'input-time-zone' => 'Europe/Helsinki', // time zone used by the CLI when asking for dates,

    // please change these
    'api-keys' => array(
        'example-123',
        'app-5687'
    )
];
