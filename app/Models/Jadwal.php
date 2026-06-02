<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'mata_pelajaran',
        'guru',
        'kelas',
        'semester',
        'tahun_ajaran'
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}