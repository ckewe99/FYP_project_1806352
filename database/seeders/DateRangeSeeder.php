<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\DateRange;

class DateRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $date_ranges = [
            [
                'start' => Carbon::create(2021, 0, 18),
                'end' => Carbon::create(2021, 0, 24),
                'active_date_range' => 1,
            ],
        ];

        collect($date_ranges)->each(function ($date_range) {
            DateRange::create($date_range);
        });
    }
}
