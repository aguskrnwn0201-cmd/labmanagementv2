<?php

namespace App\Exports;

use App\Models\Lab;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InventarisExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $labs = Lab::all();

        foreach ($labs as $lab) {

            $sheets[] = new InventarisLabSheet($lab);

        }

        return $sheets;
    }
}