<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration Validation
    |--------------------------------------------------------------------------
    |
    | This configuration helps validate security settings to prevent
    | common misconfigurations that could lead to security vulnerabilities.
    |
    */

    'debug_allowed_environments' => [
        'local',
        'testing',
        'development',
    ],

    'production_environments' => [
        'production',
        'prod',
        'live',
    ],

    'security_checks' => [
        'validate_debug_environment' => true,
        'validate_app_key' => true,
        'validate_database_credentials' => true,
    ],
];