<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiTindakan extends Model
{
    use HasFactory;
    protected $table = 'opsi_tindakan';
    protected $fillable = ['nama'];
}
