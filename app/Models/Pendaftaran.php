<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran';
    protected $fillable = ['nomor_rekam_medis', 'nama', 'umur', 'jenis_kelamin', 'alamat', 'no_hp'];
}
