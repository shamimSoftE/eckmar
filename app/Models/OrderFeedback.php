<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFeedback extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['review_positive','review_neutral','review_negative','quality_review', 'shipping_review','feedback_message', 'product_id','customer_id','order_id','seller_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
