<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'lab_id',
        'nama_guru',
        'no_hp',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'status'
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}