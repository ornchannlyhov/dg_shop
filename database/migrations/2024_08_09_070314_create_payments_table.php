<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');  
            $table->unsignedBigInteger('order_id'); 
            $table->unsignedBigInteger('user_id');  
            $table->decimal('amount', 10, 2);  
            $table->enum('payment_method', ['card', 'cash', 'online_wallet']);  
            $table->enum('payment_status', ['pending', 'completed', 'failed']);  
            $table->timestamps();  

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
