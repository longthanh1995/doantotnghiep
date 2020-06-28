<?php

return [
    'base_url_asset' => env('BASE_URL_ASSET'),
    'base_url_api' => env('BASE_URL_API'),
    'notification_url' => env('NOTIFICATION_URL'),
    'notification_key' => env('NOTIFICATION_KEY'),
    'azure_image_container' => env('AZURE_IMAGE_CONTAINER'),
    'azure_client' => env('AZURE_CLIENT'),
    'azure_secret' => env('AZURE_SECRET'),
    'azure_sas_container' => env('AZURE_SAS_CONTAINER'),
    'aws_storage' => [
        'bucket' => env('AWS_BUCKET'),
        'private_bucket' => env('AWS_PRIVATE_BUCKET'),
        'region' => env('AWS_REGION'),
        'key' => env('AWS_KEY'),
        'secret' => env('AWS_SECRET'),
    ],
    'tele_consult_api' => [
        'root_url' => env('TELECONSULT_API_ROOT'),
        'auth_key' => env('TELECONSULT_X_INTERNAL_KEY'),
    ],
    'search_api' => [
        'enabled' => env('SEARCH_API_ENABLED'),
        'base_url' => env('SEARCH_API_BASE_URL'),
        'key' => env('SEARCH_API_KEY'),
        'timeout' => env('SEARCH_API_TIMEOUT'),
        'default' => [
            'skip' => env('SEARCH_API_DEFAULT_SKIP', 0),
            'top' => env('SEARCH_API_DEFAULT_TOP', 20),
        ],
        'search_by_doctor_enabled' => env('SEARCH_API_SEARCH_BY_DOCTOR_ENABLED', false),
    ],
    'alerts_api' => [
        'enabled' => env('ALERTS_API_ENABLED'),
        'base_url' => env('ALERTS_API_BASE_URL'),
        'timeout' => env('ALERTS_API_TIMEOUT', 10),
        'auth_key' => env('ALERTS_API_AUTH_KEY'),
        'default' => [
            'icon_url' => env('ALERTS_API_DEFAULT_ICON_URL', ''),
            'sender_name' => env('ALERTS_API_DEFAULT_SENDER_NAME', 'MaNaDr'),
            'country_id' => env('ALERTS_API_DEFAULT_COUNTRY_ID', '+84'),
        ]
    ],
    'appointment_api' => [
        'base_url' => env('APPOINTMENT_API_BASE_URL'),
        'api_key' => env('APPOINTMENT_API_KEY'),
    ],
    'cme_api' => [
        'enabled' => env('CME_API_ENABLED'),
        'base_url' => env('CME_API_BASE_URL'),
        'timeout' => env('CME_API_TIMEOUT', 10),
        'auth_key' => env('CME_API_AUTH_KEY'),
    ]
];
