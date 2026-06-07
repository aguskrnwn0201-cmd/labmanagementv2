<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';

    protected $fillable = [
        'lab_id',
        'nama_barang',
        'jumlah',
        'kondisi',
        'keterangan',
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}