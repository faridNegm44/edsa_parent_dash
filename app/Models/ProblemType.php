<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemType extends Model
{
    protected $table = 'problem_types';

    protected $fillable = [
        'name', 'rate', 'show_to_parent'
    ];
}
