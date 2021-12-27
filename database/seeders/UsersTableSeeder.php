<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'info@user.com',
            'password' => bcrypt('secret'),
            'publish' => 1,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'info@admin.com',
            'password' => bcrypt('secret'),
            'publish' => 1,
        ]);

        // User::create([
        //     'name' => 'vendor',
        //     'email' => 'info@vendor.com',
        //     'password' => bcrypt('secret'),
        //     'publish' => 1,
        // ]);

        User::create([
            'name' => 'customer',
            'email' => 'info@customer.com',
            'password' => bcrypt('secret'),
            'publish' => 1,
        ]);
    }
}
