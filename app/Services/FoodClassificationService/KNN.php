<?php

namespace App\Services\FoodClassificationService;

use Phpml\Classification\KNearestNeighbors;
use Phpml\ModelManager;
use Phpml\Metric\ClassificationReport;

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
        [0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0], //5
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
        [1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0],
        [0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1],
        [0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0],
        [0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0],
        [0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
    ];
    private $labels = [
        "Western", //1
        "Thai", //4
        "Thai",
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
        "Western",
        "Vege",
        "Japanese",
        "Taiwanese",
        "Taiwanese",
        "Beverage",
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

    public function evaluation()
    {
        $test_datas = [
            [0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0],
            [0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0],
            [1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0],
            [0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1],
            [0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1],
            [0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0],
            [0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0],
            [0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1],
            [1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0],
        ];
        $actual = [
            'Beverage',
            'Taiwanese',
            'Malaysian',
            'Western',
            'Vege',
            'Malaysian',
            'Japanese',
            'Thai',
            'Chinese',
            'Western'
        ];
        $predict = [];
        $restoredClassifier = $this->modelManager->restoreFromFile($this->filepath);
        foreach ($test_datas as $data) {
            array_push($predict, $restoredClassifier->predict($data));
        }
        $report = new ClassificationReport($actual, $predict);
        return $predict;
        return $report->getAverage()['precision'];
            //return [
            //     'precision' => $report->getPrecision(),
            //     'recall' => $report->getRecall(),
            //     'f1 score' => $report->getF1score(),
            // ];


            // ['cat' => 1.0, 'ant' => 0.0, 'bird' => 0.67]

        ;
        // ['cat' => 0.67, 'ant' => 0.0, 'bird' => 0.80]

        $report->getSupport();
        // ['cat' => 1, 'ant' => 1, 'bird' => 3]

        $report->getAverage();
        // ['precision' => 0.5, 'recall' => 0.56, 'f1score' => 0.49]
    }
}
