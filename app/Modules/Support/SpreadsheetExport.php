<?php

declare(strict_types=1);

namespace App\Modules\Support;

use Illuminate\Database\Eloquent\Model;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class SpreadsheetExport
{
    public function download(Model $model): BinaryFileResponse
    {
        $path = storage_path('app/exports');
        if (! is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $file = $path.'/'.class_basename($model).'-'.now()->format('YmdHis').'.xlsx';
        $writer = new Writer;
        $writer->openToFile($file);
        $rows = $model->newQuery()->limit(5000)->get();
        $first = $rows->first();
        $headers = $first ? array_keys($first->getAttributes()) : ['id'];
        $writer->addRow(Row::fromValues($headers));
        foreach ($rows as $row) {
            $writer->addRow(Row::fromValues(array_map(
                fn ($value) => is_scalar($value) || $value === null ? $value : json_encode($value),
                array_values($row->getAttributes()),
            )));
        }
        $writer->close();

        return response()->download($file)->deleteFileAfterSend(true);
    }

    /**
     * @param  list<string>  $headers
     * @param  list<list<mixed>>  $rows
     */
    public function downloadRows(string $name, array $headers, array $rows): BinaryFileResponse
    {
        $path = storage_path('app/exports');
        if (! is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $file = $path.'/'.$name.'-'.now()->format('YmdHis').'.xlsx';
        $writer = new Writer;
        $writer->openToFile($file);
        $writer->addRow(Row::fromValues($headers));
        foreach ($rows as $row) {
            $writer->addRow(Row::fromValues($row));
        }
        $writer->close();

        return response()->download($file)->deleteFileAfterSend(true);
    }
}
