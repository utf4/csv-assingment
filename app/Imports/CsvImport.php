<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Csv;
use App\Models\CsvData;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\Importable;

class CsvImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithChunkReading, WithEvents
{
    use Importable, RegistersEventListeners;

    private static $csvFileId;

    public function __construct($csvFileId)
    {
        self::$csvFileId = $csvFileId;
    }

    public function model(array $row)
    {
        $mappedData = [];
        $mappedData['unique_key'] = (int)$row['unique_key'];
        $mappedData['product_title'] = Str::ascii($row['product_title']);
        $mappedData['product_description'] = Str::ascii($row['product_description']);
        $mappedData['style_no'] = Str::ascii($row['style']);
        $mappedData['size'] = Str::ascii($row['size']);
        $mappedData['sanmar_mainframe_color'] = Str::ascii($row['sanmar_mainframe_color']);
        $mappedData['color_name'] = Str::ascii($row['color_name']);
        $mappedData['piece_price'] = $row['piece_price'];
        $mappedData['csv_id'] = self::$csvFileId;
           
        return new CsvData($mappedData);
    }
    
    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function uniqueBy()
    {
        return 'unique_key';
    }

    /**
     * Fired after the import is completed.
     *
     * @param AfterImportEvent $event
     */
    public static function afterImport(AfterImport $event)
    {
        // Update the status for the given id
        Csv::where('id', self::$csvFileId)->update(['status' => 'completed']);
    }
}