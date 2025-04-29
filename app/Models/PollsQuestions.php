<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollsQuestions extends Model
{
    protected $table = 'polls_questions';
    protected $fillable = [
        'group', 'question', 'status', 'type', 'percentage'
    ];

    public function PollsQuestionsRelPollsGroups(){
        return $this->belongsTo(PollsGroups::class, 'group');
    }

    public function answers(){
        return $this->hasMany(AnswersToPollsQuestions::class, 'question');
    }
}
