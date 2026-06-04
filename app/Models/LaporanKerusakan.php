<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $fillable = [

        'lab_id',
        'nama_pelapor',
        'role_pelapor',
        'jenis_kerusakan',
        'deskripsi',
        'status'

    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
