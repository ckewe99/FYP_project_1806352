<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    protected $defaultClass = [
        ['id' => '1', 'name' => 'Super Admin'],
        ['id' => '2', 'name' => 'Teacher/Staff'],
        ['id' => '3', 'name' => 'J1C'],
        ['id' => '4', 'name' => 'J1W'],
        ['id' => '5', 'name' => 'J1S'],
        ['id' => '6', 'name' => 'J2C'],
        ['id' => '7', 'name' => 'J2W'],
        ['id' => '8', 'name' => 'J3C'],
        ['id' => '9', 'name' => 'J3W'],
        ['id' => '10', 'name' => 'S1Sc'],
        ['id' => '11', 'name' => 'S1C'],
        ['id' => '12', 'name' => 'S1W'],
        ['id' => '13', 'name' => 'S2Sc'],
        ['id' => '14', 'name' => 'S2C'],
        ['id' => '15', 'name' => 'S2W'],
        ['id' => '16', 'name' => 'S2S'],
        ['id' => '17', 'name' => 'S3Sc'],
        ['id' => '18', 'name' => 'S3C'],
        ['id' => '19', 'name' => 'S3W'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->defaultClass)->each(function ($class) {
            \App\Models\StudentClass::create($class);
        });
    }
}
