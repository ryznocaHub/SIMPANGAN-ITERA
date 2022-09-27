<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            'name'=> 'Ranggkot'
        ]);
        Supplier::create([
            'name' => 'Bumi Persada'
        ]);
        Supplier::create([
            'name' => 'Panggilan Alam'
        ]);
    }
}
