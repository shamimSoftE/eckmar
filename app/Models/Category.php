<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name','slug', 'parent_id', 'status','order_count'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->where('status', 1); //only status 1 value available
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->select('id', 'name'); // only id & name available
    }
}
