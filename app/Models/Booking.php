<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'lab_id',
        'tipe_pemohon',
        'nama_pemohon',
        'kelas',
        'no_hp',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'jumlah_peserta',
        'keperluan',
        'status',
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}