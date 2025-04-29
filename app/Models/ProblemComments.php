<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemComments extends Model
{
    protected $table = 'problem_comments';

    protected $fillable = [
        'problem_id', 'comment', 'file', 'commented_by', 'edited_comment', 'parent_id'
    ];

    public function problem(){
        return $this->belongsTo('App\Models\ParentProblems', 'problem_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'commented_by');
    }
}
