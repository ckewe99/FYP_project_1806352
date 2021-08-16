<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Sentiment\Analyzer;
use Exception;

class TextSentiment extends Controller
{

    public function __construct()
    {
    }

    public static function sentiment($strings)
    {
        $final_result = ['good' => 0, 'bad' => 0, 'neu' => 0];
        $good = 0;
        $bad = 0;
        $neutral = 0;
        $result_arr = [];
        try {
            foreach ($strings as $string) {
                if ($string["comments"] == null) {
                    continue;
                }
                $analyzer = new Analyzer();
                // $output_text = $analyzer->getSentiment("bad taste ever,sucks!!!");
                // dd($output_text["compound"]);
                $output_text = $analyzer->getSentiment($string["comments"]);

                if ($output_text["compound"] > 0.25) {
                    $good++;
                } else if ($output_text["compound"] < -0.25) {
                    $bad++;
                } else {
                    $neutral++;
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        $final_result['good'] = $good;
        $final_result['bad'] = $bad;
        $final_result['neu'] = $neutral;
        return $final_result; // good:num,bad:num,neu:0
    }
}
