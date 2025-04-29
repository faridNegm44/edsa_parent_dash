<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheYears extends Model
{
    use HasFactory;

    protected $table = 'tbl_years_mat';
    
    public $timestamps = false;

    protected $fillable = [
        'TheFullName', 'TheYear', 'TheMat', 'EngL', 'EngH', 'LangType'
    ];
}
