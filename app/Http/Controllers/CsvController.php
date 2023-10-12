<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvStoreRequest;
use App\Models\Csv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Jobs\ProcessCsvFile; 
use App\Imports\CsvImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use \Maatwebsite\Excel\Reader;
use Carbon\Carbon;

class CsvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $csvs = Csv::all();
        
        // Format created_at using Carbon
        $csvs = $csvs->map(function ($csv) {
            $minutesAgo = Carbon::now()->diffInMinutes($csv->created_at);
            $formattedTimeAgo = $minutesAgo > 0 ? "{$minutesAgo} minute" . ($minutesAgo > 1 ? 's' : '') . " ago" : 'Just now';

            return [
                'id' => $csv->id,
                'file_name' => $csv->file_name,
                'status' => $csv->status,
                'created_at' => $csv->created_at->format('d-m-y h:ia') . " ({$formattedTimeAgo})"
            ];
        });

        return Inertia::render('Csv/Index', compact('csvs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // Store the CSV file in the storage disk (e.g., public disk)
        $csvPath = $request->file('csv_file')->store('csvs', 'public');

        $csvPath = Storage::disk('public')->path($csvPath);

        $csvFile = new Csv;
        $csvFile->file_name = $request->file('csv_file')->getClientOriginalName();;
        $csvFile->status = 'pending';

        $csvFile->save();

        $csvFileId = $csvFile->id;

        // Dispatch the job to process the CSV file
        ProcessCsvFile::dispatch($csvPath, $csvFileId);
        
        return redirect()->back()->with('success', 'CSV will be processed shortly.');
    }
}
