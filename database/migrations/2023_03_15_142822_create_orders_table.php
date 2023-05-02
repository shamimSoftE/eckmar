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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->integer('customer_id');
            // $table->integer('seller_id');
            $table->tinyInteger('status')->default(0);
            $table->string('currency')->nullable();
            $table->integer('product_qty');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('seller_id')->constrained('users');
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
        Schema::dropIfExists('orders');
    }
};
