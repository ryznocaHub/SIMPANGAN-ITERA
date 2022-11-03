<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name'=> 'Barang'
        ]);
        DB::table('categories')->insert([
            'name'=> 'Pekerjaan Konstruksi'
        ]);
        DB::table('categories')->insert([
            'name'=> 'Jasa Konsultasi'
        ]);
        DB::table('categories')->insert([
            'name'=> 'Jasa Lainnya'
        ]);
    }
}
