<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\Parents as Authenticatable;
// use Illuminate\Notifications\Notifiable;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'tbl_parents';
    
    public $timestamps = false;

    protected $fillable = [
        'ID', 'TheDate1', 'TheEmail', 'ThePass', 'TheCode', 'TheName0', 'TheName1', 'TheName2', 'TheName3', 'NatID', 'CityID', 'ThePhone1', 'ThePhone2', 'TheNotes', 'TheStatus', 'TheStatusDate'
    ];

    public function user_parent(){
        return $this->belongsTo('App\Models\User', 'TheName0');
    }
    
    public function nationality_name(){
        return $this->belongsTo('App\Models\Nationality', 'NatID');
    }
    
    public function city_name(){
        return $this->belongsTo('App\Models\City', 'CityID');
    }
}
