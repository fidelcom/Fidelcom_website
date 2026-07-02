<?php

return [
    'paths'                    => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods'          => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
    'allowed_origins'          => [
        env('FRONTEND_ADMIN_URL', 'http://localhost:3001'),
        env('FRONTEND_PUBLIC_URL', 'http://localhost:3002'),
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers'          => ['Accept', 'Authorization', 'Content-Type', 'X-XSRF-TOKEN', 'X-Requested-With'],
    'exposed_headers'          => [],
    'max_age'                  => 86400,
    'supports_credentials'     => true,
];
