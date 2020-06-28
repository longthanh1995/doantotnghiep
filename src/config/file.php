<?php

return [
    'acceptable' => [
        'file'  => [
            'application/pdf'          => 'pdf',
            'application/octet-stream' => '',
            'application/zip'          => 'zip',
            'text/plain'               => 'txt',
        ],
        'image' => [
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
        ],
    ],
    'categories' => [
        1 => [
            'name'         => 'cover-image',
            'type'         => 'image',
            'region'       => env('AWS_IMAGE_REGION'),
            'buckets'      => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'         => [1440, 0],
            'thumbnails'   => [
                [400, 300],
                [800, 600],
                [640, 640],  // Instagram
                [735, 1102], // Pinterest
                [1024, 512], // Twitter Card
                [1280, 628], // Facebook OGP
                [1440, 900],
            ],
            'seedPrefix'   => 'article-cover',
            'format'       => 'jpeg',
            'alternatives' => ['webp'],
        ],
    ],
];
