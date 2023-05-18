<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministratorLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','type', 'description', 'user'];

    public function performed_on()
    {
        return $this->belongsTo(User::class, 'user_id'); //performed on
    }
}
