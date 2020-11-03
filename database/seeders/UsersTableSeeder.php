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
            [
              'name' => 'Test User',
              'email' => 'test@ecommerce.com',
              'password' => \Hash::make('123123123'),
              'address' => 'Davao City',
              'contact' => '0912345678',
              'role_id' => 1,
              'isVerified' => 1
          ]
        ];
        
        \DB::table('users')->insert($users);
    }
}
