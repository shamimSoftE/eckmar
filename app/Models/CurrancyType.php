<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrancyType extends Model
{
    use HasFactory;

    protected $fillable = ['currancy_type', 'rate'];
    protected $table = 'currency_rate';
}
