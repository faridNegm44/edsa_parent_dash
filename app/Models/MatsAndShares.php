<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatsAndShares extends Model
{
    protected $table = 'mats_and_shares';
    
    public $timestamps = false;

    protected $fillable = [
        'mat', 'year', 'count'
    ];
}
