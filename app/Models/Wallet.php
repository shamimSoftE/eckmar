<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address','currency_code', 'currency_type','balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}