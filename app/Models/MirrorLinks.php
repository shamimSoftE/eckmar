<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MirrorLinks extends Model
{
    use HasFactory;

    protected $table = 'mirror_links';

    protected $fillable = ['link', 'logo','title'];
}
