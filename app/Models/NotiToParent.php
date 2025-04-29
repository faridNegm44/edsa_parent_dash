<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotiToParent extends Model
{
    protected $table = 'noti_to_parents';
    
    protected $fillable = [
        'parent_id', 'sender','title', 'description', 'status', 'group_id', 'readed'
    ];
    

    public function sender_name(){
        return $this->belongsTo('App\Models\User', 'sender');
    }
    
    public function parent_name(){
        return $this->belongsTo('App\Models\Parents', 'parent_id');
    }

}
