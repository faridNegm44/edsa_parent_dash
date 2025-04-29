<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollUsersHrTeachers extends Model
{
    protected $table = 'poll_users_hr_teachers';
    protected $fillable = [
        'user_id', 'group_id', 'question', 'answer', 'total', 'special'
    ];
}
