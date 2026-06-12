<?php

namespace App\Exports;

use App\Models\Lab;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventarisLabSheet implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    protected $lab;

    public function __construct(Lab $lab)
    {
        $this->lab = $lab;
    }

    /**
     * Mengambil data dari database dengan kolom yang akurat
     */
    public function collection()
    {
        return $this->lab->inventaris()
            ->select([
                'id',
                'nama_barang',
                'baik',
                'rusak',
                'cadangan',
                'total',
                'keterangan'
            ])
            ->get();
    }

    /**
     * Berfungsi untuk mengatur baris data yang akan dicetak ke baris Excel
     */
    public function map($item): array
    {
        return [
            '#INV-' . sprintf('%04d', $item->id),
            $item->nama_barang,
            $item->baik . ' Unit',
            $item->rusak . ' Unit',
            $item->cadangan . ' Unit',
            ($item->total ?? ($item->baik + $item->rusak + $item->cadangan)) . ' Unit',
            $item->keterangan ?? '-',
        ];
    }

    /**
     * Membuat Baris Header/Judul Kolom Paling Atas di Excel
     */
    public function headings(): array
    {
        return [
            'Kode Aset',
            'Nama Barang / Peralatan',
            'Kondisi Baik',
            'Kondisi Rusak',
            'Stok Cadangan',
            'Total Keseluruhan',
            'Keterangan Tambahan'
        ];
    }

    /**
     * Mengatur Nama Sheet sesuai Nama Lab
     */
    public function title(): string
    {
        // Membatasi nama sheet maksimal 31 karakter agar tidak error di Excel
        return substr($this->lab->nama_lab, 0, 31);
    }
}