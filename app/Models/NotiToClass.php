<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotiToClass extends Model
{    
    protected $table = 'noti_to_classes';
    
    protected $fillable = [
        'class_id', 'sender','title', 'description', 'status', 'group_id', 'readed'
    ];


    public function sender_name(){
        return $this->belongsTo('App\Models\User', 'sender');
    }
    
    public function class_name(){
        return $this->belongsTo('App\Models\TheYears', 'class_id');
    }
}
