<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PidFormatExport implements FromCollection, WithHeadings
{
    /**
     * Return an empty collection (no data).
     */
    public function collection()
    {
        return new Collection([]);
    }

    /**
     * Define the column headings.
     */
    public function headings(): array
    {
        return ['SL', 'Payment ID', 'Student ID'];
    }
}
