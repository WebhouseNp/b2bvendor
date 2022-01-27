<?php

return  [
    'customer_app_url' => env('CUSTOMER_APP_URL', 'https://sastowholesale.com'),

    'order_statuses' => ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'],
    'package_statuses' => ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded']
];
