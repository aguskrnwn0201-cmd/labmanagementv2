<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris'; 

    // Daftarkan field-field baru di bawah ini agar diizinkan masuk ke DB
    protected $fillable = [
        'lab_id',
        'nama_barang',
        'baik',
        'rusak',
        'cadangan',
        'total',
        'keterangan',
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }
}