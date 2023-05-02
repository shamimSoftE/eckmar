<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $table = "ticket_categorys";
    protected $fillable = ['name', 'description',];
    use HasFactory;
}
