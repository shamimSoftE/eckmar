<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Ticket extends Model
{
    protected $table = "tickets";
    protected $fillable = ['cat_id', 'user_id','status','review_message','review_star'];
    use HasFactory;

    public function category(){
        return $this->belongsTo(TicketCategory::class,'cat_id');
    }

    public function message(){
        return $this->hasMany(TicketMessage::class);
    }

    public function unread(){
        return $this->message()->where('read',0)->where('reply_id',0);
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
}
