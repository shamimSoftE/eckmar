<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $table = "ticket_messages"; 
    protected $fillable = ['ticket_id', 'message', 'images','reply_id','read'];

    public function user(){
        return $this->belongsTo(User::class,"reply_id");
    }
    use HasFactory;
}
