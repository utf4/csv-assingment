<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvData extends Model
{
    use HasFactory;

    protected $table = 'csv_data';

    protected $fillable = [
        'unique_key',
        'product_title',
        'product_description',
        'style_no',
        'sanmar_mainframe_color',
        'size',
        'color_name',
        'piece_price',
        'csv_id'
    ];

    public function csv()
    {
        return $this->belongsTo(Csv::class, 'csv_id');
    }
}
