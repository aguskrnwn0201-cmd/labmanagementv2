<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
   protected $fillable = [
    'nama_lab',
    'lokasi',
    'kapasitas',
    'komputer_ready', // <-- Tambahkan baris ini
    'keterangan',
    'status'
];

     public function jadwals()
{
    return $this->hasMany(Jadwal::class);
}

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function inventaris()
{
    return $this->hasMany(Inventaris::class);
}

}
