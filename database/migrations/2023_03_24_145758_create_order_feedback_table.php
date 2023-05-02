<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_feedback', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('review_button')->default(1);
            $table->tinyInteger('quality_review')->default(5);
            $table->tinyInteger('shipping_review')->default(5);
            $table->text('feedback_message')->nullable();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('order_id')->constrained('orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_feedback');
    }
};
