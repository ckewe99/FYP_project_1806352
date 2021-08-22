<?php

namespace App\Services\TSP;

class Point
{
    public $latitude;
    public $longitude;

    public function __construct($lat, $lon)
    {
        $this->latitude = $lat;
        $this->longitude = $lon;
    }
}
