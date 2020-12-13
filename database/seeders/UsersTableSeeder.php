<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [ 
            // [
            //   'name' => 'Admin',
            //   'email' => 'test@ecommerce.com',
            //   'password' => \Hash::make('123123123'),
            //   'address' => 'Davao City',
            //   'contact' => '0912345678',
            //   'role_id' => 1,
            //   'isVerified' => 1
            // ],
            // [
            //     'name' => 'Customer ',
            //     'email' => 'customer@ecommerce.com',
            //     'password' => \Hash::make('123123123'),
            //     'address' => 'Davao City',
            //     'contact' => '09123452678',
            //     'role_id' => 2,
            //     'isVerified' => 1
            // ],
            [
                'name' => 'Customer Second',
                'email' => 'customer3@ecommerce.com',
                'password' => \Hash::make('123123123'),
                'address' => 'Davao City',
                'contact' => '09121345267822',
                'role_id' => 2,
                'isVerified' => 1
            ],
            [
                'name' => 'Customer Third',
                'email' => 'customer3@ecommerce.com',
                'password' => \Hash::make('123123123'),
                'address' => 'Davao City',
                'contact' => '09121345267822',
                'role_id' => 2,
                'isVerified' => 1
            ],
        ];
        
        \DB::table('users')->insert($users);
    }
}
