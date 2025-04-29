<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'tbl_students';
    
    public $timestamps = false;

    protected $fillable = [
        'TheDate1', 'TheName', 'ParentID', 'NatID', 'CityID', 'ThePhone', 'TheEmail', 'TheEduType', 'TheTestType', 'TheExplain', 'TheNotes', 'TheStatus', 'TheStatusDate'
    ];

    public function parent_name(){
        return $this->belongsTo('App\Models\User', 'ParentID');
    }
    
    public function nationality_name(){
        return $this->belongsTo('App\Models\Nationality', 'NatID');
    }
    
    public function city_name(){
        return $this->belongsTo('App\Models\City', 'CityID');
    }
}
