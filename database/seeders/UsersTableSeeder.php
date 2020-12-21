<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::disable
        Schema::disableForeignKeyConstraints();
        User::truncate();
        $users = [
            [
              'name' => 'Admin',
              'email' => 'test@ecommerce.com',
              'password' => \Hash::make('123123123'),
              'address' => 'Davao City',
              'contact' => '0912345678',
              'role_id' => 1,
              'isVerified' => 1
            ],
            [
                'name' => 'Customer One',
                'email' => 'customer1@ecommerce.com',
                'password' => \Hash::make('123123123'),
                'address' => 'Davao City',
                'contact' => '09123452678',
                'role_id' => 2,
                'isVerified' => 1
            ],
            [
                'name' => 'Customer Second',
                'email' => 'customer2@ecommerce.com',
                'password' => \Hash::make('123123123'),
                'address' => 'Davao City',
                'contact' => '09121231234',
                'role_id' => 2,
                'isVerified' => 1
            ],
            [
                'name' => 'Customer Third',
                'email' => 'customer3@ecommerce.com',
                'password' => \Hash::make('123123123'),
                'address' => 'Davao City',
                'contact' => '09121231235',
                'role_id' => 2,
                'isVerified' => 1
            ],
        ];

        \DB::table('users')->insert($users);
        Schema::enableForeignKeyConstraints();
    }
}
