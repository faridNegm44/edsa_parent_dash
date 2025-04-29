<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollUsersToTeachersOnly extends Model
{
    protected $table = 'poll_users_to_teachers_only';
    protected $fillable = [
        'user_id', 'teacher_id', 'group_id', 'question_id', 'answer', 'total', 'special'
    ];
}
