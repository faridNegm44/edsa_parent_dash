<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentProblems extends Model
{
    protected $table = 'parent_problems';

    protected $fillable = [
        'parent_id', 'isParentWriten', 'problem', 'problem_status', 'problem_rating', 'staff_id', 'staff_rating', 'problem_type', 'date_reference', 'deadline', 'ended_at', 'readed', 'created_at'
    ];


    public function parent(){
        return $this->belongsTo('App\Models\User', 'parent_id');
    }

    public function staff(){
        return $this->belongsTo('App\Models\User', 'staff_id');
    }

    public function problem_type_relation(){
        return $this->belongsTo('App\Models\ProblemType', 'problem_type');
    }
}
