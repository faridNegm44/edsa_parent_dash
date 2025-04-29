<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollsGroups extends Model
{
    protected $table = 'polls_groups';
    protected $fillable = [
        'title', 'from', 'to', 'special', 'status'
    ];
}
