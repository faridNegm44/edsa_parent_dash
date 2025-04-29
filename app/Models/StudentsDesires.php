<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsDesires extends Model
{
    use HasFactory;
    protected $table = 'tbl_students_years_mat';
    
    public $timestamps = false;

    protected $fillable = [
        'StudentID', 'YearID', 'group_id', 'TheTime', 'ThePackage', 'TheNotes'
    ];

    public function student_name(){
        return $this->belongsTo('App\Models\Student', 'StudentID', 'ID');
    }

    public function mats_name(){
        return $this->belongsTo('App\Models\TheYears', 'YearID');
    }
    
    public function parent_id(){
        return $this->hasMany(Student::class, 'ID', 'StudentID')->where('ParentID', '=', 49);
    }
    
}