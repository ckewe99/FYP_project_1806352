<?php

namespace App\Services\FoodClassificationService;

use Phpml\Classification\KNearestNeighbors;
use Phpml\ModelManager;

class KNN
{
    // label 1 Western
    // label 2 Chinese
    // label 3 Malaysian
    // label 4 Thai
    // label 5 Japanese
    // label 6 Taiwanese
    // label 7 Beverage
    // label 8 Kuih
    // label 9 Rice
    // label 10 Noodle/Mee
    // label 11 vege

    private $modelManager;
    private $classifier;
    private $samples = [
        [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], //1
        [0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0], //4
        [0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0], //6
        [0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0], //8
        [0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0], //9
        [0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0], //11
        [1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0], //13
        [0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0], //14
        [0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0], //16
        [0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0], //19
        [0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0], //20
        [0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0], //22
        [0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0], //24
        [0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1], //25
        [0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1], //27
        [0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1], //28
        [0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0], //29
        [0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0], //30
        [0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1], //31
        [0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 1], //32
    ];
    private $labels = [
        "Western", //1
        "Thai", //4
        "Chinese", //6
        "Malaysian", //8
        "Malaysian", //9
        "Kuih", //11
        "Kuih", //13
        "Malaysian", //14
        "Beverage", //16
        "Beverage", //19
        "Beverage", //20
        "Beverage", //22
        "Malaysian", //24
        "Vege", //25
        "Vege", //27
        "Kuih", //28
        "Japanese", //29
        "Taiwanese", //30
        "Beverage", //31
        "Taiwanese", //32
    ];

    private $filepath = '..\app\Services\model.txt';

    public function __construct()
    {
        $this->classifier = new KNearestNeighbors();
        $this->modelManager = new ModelManager();
    }

    /**
     * Process the next (i.e. closest) entry in the queue.
     *
     * @param string[] $exclude A list of nodes to exclude - for calculating next-shortest paths.
     *
     * @return void
     */

    public function initial()
    {
        $this->classifier->train($this->samples, $this->labels);
        $this->modelManager->saveToFile($this->classifier, $this->filepath);
    }

    public function getResult($predict)
    {

        $restoredClassifier = $this->modelManager->restoreFromFile($this->filepath);

        return [
            'result' => $restoredClassifier->predict($predict)
        ];
    }

    public function update($sample, $labels)
    {
        $restoredClassifier = $this->modelManager->restoreFromFile($this->filepath);
        $restoredClassifier->train($sample, $labels);
        $this->modelManager->saveToFile($restoredClassifier, $this->filepath);
    }
}
