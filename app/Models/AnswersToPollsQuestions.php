<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswersToPollsQuestions extends Model
{
    protected $table = 'answers_to_polls_questions';
    protected $fillable = [
        'question', 'answer', 'value', 'percentage', 'status'
    ];

    public function AnswersToPollsQuestionsRelPollsQuestions(){
        return $this->belongsTo(PollsQuestions::class, 'question');
    }

}
