<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Application::select('id', 'firstname', 'lastname', 'phone', 'email', 'address', 'resume',
            'messageupdate','position_id', 'status')->get();
    }

    public function headings(): array
    {
        return ['id', 'firstname', 'lastname', 'phone', 'email', 'address', 'resume',
            'messageupdate','position_id', 'status'];
    }
}
