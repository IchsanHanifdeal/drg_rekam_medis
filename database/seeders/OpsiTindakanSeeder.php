<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OpsiTindakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('opsi_tindakan')->insert([
            ['nama' => 'Pencabutan Gigi Palsu', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Pencabutan Gigi Permanen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Penambalan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Scalling', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'PSA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Behel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Kontrol Behel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Gigi Palsu', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Bleaching', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'GTC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
