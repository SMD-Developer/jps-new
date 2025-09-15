<?php
return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admin',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'user' => [
            'driver' => 'session',
            'provider' => 'clients',
        ],
        
        
        
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'clients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Client::class,
        ]
    ],
    'passwords' => [
        'admin' => [
            'provider' => 'users',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'clients' => [
        'provider' => 'clients',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
        'email' => 'emails.password-reset',
    ],
    ]
];