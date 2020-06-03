<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportSector extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_sector', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->foreignId('sector_id')->constrained() ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_sector');
    }
}
