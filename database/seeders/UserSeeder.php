<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Head Of UKPBJ',
            'email'     => 'headOfUKPBJ@gmail.com',
            'password'  => bcrypt('headOfUKPBJ'),
            'role'      => User::ROLE_Head_UKPBJ,
            'unit_id'   => 1 

        ]);
        User::create([
            'name'      => 'Unit 1',
            'email'     => 'unit1@gmail.com',
            'password'  => bcrypt('unit1unit1'),
            'role'      => User::ROLE_UNIT,
            'unit_id'   => 1 
        ]);
    }
}
