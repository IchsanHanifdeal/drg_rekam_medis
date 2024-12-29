<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;
    protected $table = 'tindakan';
    protected $fillable = ['pendaftaran', 'tanggal', 'tensi_darah', 'berat_badan', 'biaya', 'opsi_tindakan'];

    public function pendaftarans()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran', 'id');
    }

    public function opsi()
    {
        return $this->belongsTo(OpsiTindakan::class, 'opsi_tindakan', 'id');
    }
}
