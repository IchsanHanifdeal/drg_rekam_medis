<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'nama_klinik' => 'Mutia Dental Clinic',
                'nama_dokter' => 'drg. Mutia Sari Dewi',
                'logo'        => 'default/logo.png',
                'favicon'     => 'default/favicon.ico',
                'alamat'      => 'Jalan Raya Batusangkar-Bukittinggi, Km. 4, Sungai Tarab',
                'no_telp'     => '08123456789',
                'email'       => 'admin@klinikpratama.id',
                'theme_colors' => [
                    'primary'   => '#6ca729',
                    'secondary' => '#246018',
                    'accent'    => '#91c21c',
                    'neutral'   => '#24462e',
                    'success'   => '#36d399',
                    'error'     => '#f87272',
                ],
            ]
        );
    }
}
