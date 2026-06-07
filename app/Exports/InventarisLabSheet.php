<?php

namespace App\Exports;

use App\Models\Lab;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class InventarisLabSheet implements FromCollection, WithTitle
{
    protected $lab;

    public function __construct(Lab $lab)
    {
        $this->lab = $lab;
    }

    public function collection()
    {
        return $this->lab->inventaris()
            ->select(
                'nama_barang',
                'jumlah',
                'kondisi',
                'keterangan'
            )
            ->get();
    }

    public function title(): string
    {
        return $this->lab->nama_lab;
    }
}