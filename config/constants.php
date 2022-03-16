<?php

return  [
    'customer_app_url' => env('CUSTOMER_APP_URL', 'https://staging.sastowholesale.com/'),

    'order_statuses' => ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'],
    'package_statuses' => ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'], // Not in use
    'business_type' => ['Manufacturers','Wholesellers','Distributors','Traders','Retailer'],

    'alternative_user_permissions' => [
        'categories' => 'Manage Categories',
        'products' => 'Manage Products',
        'orders' => 'Manage Orders',
        'chat' => 'Access Chat',
        'deals' => 'Manage Deals',
        'transactions' => 'View Transactions',
        'sales_report' => 'View Sales Report',
    ],
];
