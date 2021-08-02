<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_ranges', function (Blueprint $table) {
            $table->id();
            $table->date('start')->nullable()->default(null);
            $table->date('end')->nullable()->default(null);
            $table->integer('active_date_range')->default(0);   

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
        Schema::dropIfExists('date_ranges');
    }
}
