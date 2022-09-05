<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create(
            [
                'full_name' => 'Unit Kerja Pengadaan Barang dan Jasa',
                'name' => 'UKPBJ',
                'full_name' => 'Jurusan Sains',
                'name' => 'JS',
            ]
        );
    }
}
