<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdInStalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('stalls', 'user_id')) {
            Schema::table('stalls', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stalls', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
