<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->timestamps();
            $table->string('title');
            $table->text('description');
            $table->text('institution_name');
            $table->string('state');
            $table->text('address');
            $table->boolean('anonymous')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('voice_id')->nullable();
            $table->foreign('voice_id')->references('id')->on('voices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');

    }
}
