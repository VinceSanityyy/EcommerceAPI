<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [ 
            [
                'role_name' => 'Super Admin',
            ],
            [
                'role_name' => 'Store Admin',
            ],
            [
                'role_name' => 'Customer',
            ],
        ];
        
        \DB::table('roles')->insert($roles);
    }
}
