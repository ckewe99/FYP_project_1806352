<?php

namespace App\Services;

use App\Services\TSP\Plan;
use App\Services\TSP\Point;
use App\Services\TSP\Place;
use App\Services\TSP\Life;
use App\Services\TSP\Selection;

class TestTSP
{

    public function test()
    {
        $plan = new Plan();

        $plan->addPlace(new Place('sanremo', new Point(43.815967, 7.776057)));
        $plan->addPlace(new Place('milano', new Point(45.465422, 9.185924)));
        $plan->addPlace(new Place('cuneo', new Point(44.384477, 7.542671)));
        $plan->addPlace(new Place('salerno', new Point(40.682441, 14.768096)));
        $plan->addPlace(new Place('napoli', new Point(40.851775, 14.268124)));
        $plan->addPlace(new Place('roma', new Point(41.902783, 12.496366)));
        $plan->addPlace(new Place('torino', new Point(45.070312, 7.686856)));
        $plan->addPlace(new Place('imperia', new Point(43.889686, 8.039517)));
        $plan->addPlace(new Place('ventimiglia', new Point(43.791237, 7.607586)));
        $plan->addPlace(new Place('sassari', new Point(40.725927, 8.555683)));

        $life = new Life(new Selection(4));
        $roadmap = $life->getShortestPath($plan);

        echo "Distance: {$roadmap->distance()}" . PHP_EOL . PHP_EOL;
        foreach ($roadmap->places as $place) {
            echo "Move: {$place->name}" . PHP_EOL;
        }
    }
}
