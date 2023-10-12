<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Csv extends Model
{
    use HasFactory;

    protected $table = 'csvs';

    protected $fillable = ['file_name', 'status'];
}
