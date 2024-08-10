<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_id');  
            $table->unsignedBigInteger('user_id');   
            $table->string('shop_name', 255);  
            $table->text('shop_description')->nullable(); 
            $table->timestamps();  

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
