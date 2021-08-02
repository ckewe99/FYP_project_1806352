<?php

namespace Database\Seeders;

use App\Models\Stall;
use Illuminate\Database\Seeder;

class StallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_stalls = [
            ['name' => '荤食'],
            ['name' => '素食'],
            ['name' => '饮料'],
        ];
        collect($default_stalls)->each(function ($stall) {
            Stall::create($stall);
        });
    }
}
