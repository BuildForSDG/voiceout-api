<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');          
            $table->string('email');
            $table->text('description');
            $table->text('address');
            $table->string('logo')->nullable();  
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('web')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voices');
    }
}
