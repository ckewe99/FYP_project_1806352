<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('session')->nullable();
            $table->string('days');
            // $table->boolean('dessert')->default(0);
            $table->unsignedBigInteger('date_range_id')->index();
            $table->unsignedBigInteger('stall_id')->nullable();
            $table->timestamps();

            $table->foreign('stall_id')
                ->references('id')
                ->on('stalls')->onDelete('cascade');

            $table->foreign('date_range_id')
                ->references('id')
                ->on('date_ranges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
