<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Models\Csv;
use App\Models\CsvData;
use ErrorException;
use Illuminate\Support\Facades\Storage;
use App\Imports\CsvImport;

class ProcessCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1; // Set the maximum number of tries

    /**
     * The CSV path.
     *
     * @var string
     */
    protected $csvPath;

    /**
     * The CSV file ID.
     *
     * @var int
     */
    protected $csvFileId;

    /**
     * Create a new job instance.
     */
    public function __construct($csvPath, $csvFileId)
    {
        $this->csvPath = $csvPath;
        $this->csvFileId = $csvFileId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Update the status for the given id
        Csv::where('id', $this->csvFileId)->update(['status' => 'processing']);
        try {
            Excel::import(new CsvImport($this->csvFileId), $this->csvPath);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Update the status for the given id
            Csv::where('id', $this->csvFileId)->update(['status' => 'failed']);
        } catch (Exception $err) {
            // Update the status for the given id
            Csv::where('id', $this->csvFileId)->update(['status' => 'failed']);
        } catch (Exception $err) {
            // Update the status for the given id
            Csv::where('id', $this->csvFileId)->update(['status' => 'failed']);
        } catch (ErrorException $err) {
            // Update the status for the given id
            Csv::where('id', $this->csvFileId)->update(['status' => 'failed']);
        }
    }
}
