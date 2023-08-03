<?php
namespace App\Traits;

use Maatwebsite\Excel\Facades\Excel;
trait ExportTrait
{
    public function generateExport(string $label, string $fileExtension, $export): string
    {
        $now = now();
        $now = str_replace([':', '-', ' '], '', $now);
        $filename = $label . '_' . $now . '.' . $fileExtension;

        Excel::store($export, $filename, 'public');

        $route = route('exportFile', ['file_name' => $filename]);

        return $route;
    }

}
