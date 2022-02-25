<?php

return  [
    'customer_app_url' => env('CUSTOMER_APP_URL', 'https://sastowholesale.com'),

    'order_statuses' => ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'],
    'package_statuses' => ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'],
    'business_type' => ['manufacturers','wholesellers','distributors','traders','retailer'],

    'alternative_user_permissions' => [
        'categories' => 'Manage Categories',
        'products' => 'Manage Products',
        'orders' => 'Manage Orders',
        'chat' => 'Access Chat',
        'deal' => 'Manage Deals',
        'transactions' => 'View Transactions',
        'sales_report' => 'View Sales Report',
    ],
];
