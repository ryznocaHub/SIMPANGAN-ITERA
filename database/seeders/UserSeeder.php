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
            'identity_number'  =>  '19770527 200003 1 002',
            'identity_type'  =>  'NIP',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('admin'),
            'role'      => User::ROLE_Head_UKPBJ,
            'unit_id'   => 1 

        ]);
        User::create([
            'name'      => 'Unit 1',
            'identity_number'  =>  '19770527 200003 1 002',
            'identity_type'  =>  'NIP',
            'email'     => 'unit1@gmail.com',
            'password'  => bcrypt('unit1unit1'),
            'role'      => User::ROLE_UNIT,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'Pujiono, S.Sos., M.M.',
            'identity_number'  =>  '19770527 200003 1 002',
            'identity_type'  =>  'NIP',
            'email'     => 'ppk1@gmail.com',
            'password'  => bcrypt('ppk1ppk1'),
            'role'      => User::ROLE_PPK,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'pp 1',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'pp1@gmail.com',
            'password'  => bcrypt('pp1pp1'),
            'role'      => User::ROLE_PP,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'hps 1',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'hps1@gmail.com',
            'password'  => bcrypt('hps1hps1'),
            'role'      => User::ROLE_HPS_TEAM,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'hps 2',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'hps2@gmail.com',
            'password'  => bcrypt('hps2hps2'),
            'role'      => User::ROLE_HPS_TEAM,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'hps 3',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'hps3@gmail.com',
            'password'  => bcrypt('hps3hps3'),
            'role'      => User::ROLE_HPS_TEAM,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'kontrak 1',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'kontrak1@gmail.com',
            'password'  => bcrypt('kontrak1kontrak1'),
            'role'      => User::ROLE_CONTRACT_TEAM,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'teknis 1',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'teknis1@gmail.com',
            'password'  => bcrypt('teknis1teknis1'),
            'role'      => User::ROLE_TECHNICAL_TEAM,
            'unit_id'   => 1 
        ]);
        User::create([
            'name'      => 'siren 1',
            'identity_number'  =>  '1995 0826 2021 1352',
            'identity_type'  =>  'NRK',
            'email'     => 'siren1@gmail.com',
            'password'  => bcrypt('siren1siren1'),
            'role'      => User::ROLE_VerifAccount,
            'unit_id'   => 1 
        ]);
    }
}
