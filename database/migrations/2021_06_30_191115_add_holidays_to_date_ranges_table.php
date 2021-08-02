<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHolidaysToDateRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('date_ranges', 'holidays')) {
            Schema::table('date_ranges', function (Blueprint $table) {
                $table->json('holidays')->nullable();
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
        Schema::table('date_ranges', function (Blueprint $table) {
            $table->dropColumn('holidays');
        });
    }
}
