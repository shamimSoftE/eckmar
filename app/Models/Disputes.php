<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disputes extends Model
{
    use HasFactory;

    protected $fillable = ['message','order_id','support_id','customer_id'];
}
