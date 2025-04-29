<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentsPayment extends Model
{
    protected $table = 'tbl_parents_payments';

    public $timestamps = false;
    
    protected $fillable = [
        'ID', 'TheDate', 'ParentID', 'TheAmount', 'TheNotes', 'ThePayType', 'currency', 'amount_by_currency', 'image', 'invoice_number', 'sender_name', 'expense_price', 'transfer_expense', 'admin_notes', 'status'
    ];

    public function parent_name(){
        return $this->belongsTo(User::class, 'ParentID');
    }
}
