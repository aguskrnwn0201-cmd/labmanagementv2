<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
   protected $fillable = [
    'lab_id', 'inventaris_id', 'jumlah_rusak', 'nama_pelapor', 'role_pelapor', 'no_hp', 'jenis_kerusakan', 'deskripsi', 'status'
];

public function inventaris()
{
    return $this->belongsTo(Inventaris::class, 'inventaris_id');
}

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

}
