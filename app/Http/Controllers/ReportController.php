<?php

namespace App\Http\Controllers;

use App\Models\DateRange;
use App\Models\Stall;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // public function index()
    // {
    //     $is_active = 0;
    //     $date_range = DateRange::all();
    //     foreach ($date_range as $date_ranges) {
    //         if ($date_ranges->active_date_range == 1) {
    //             $is_active = 1;
    //         }
    //     }
    //     return view('classes.orders.classDateRange', compact('date_range', 'is_active'));
    // }

    // public function show(Request $request)
    // {
    //     $days = ['SUN' => 'Sunday', 'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday'];
    //     $item = [];

    //     foreach (array_keys($days) as $day) {
    //         $obj = DB::table('orders')
    //             ->join('food', 'orders.food_id',  'food.id')
    //             ->join('stalls', 'stalls.id', 'food.stall_id')
    //             ->select(DB::raw('SUM(orders.quantity) as quantity , food.name as food ,food.session as session, stalls.name as stall'))
    //             ->where('orders.date_range_id', $request->get('date_range'))
    //             ->groupBy('food.days', 'food.name', 'food.session', 'stalls.name')
    //             ->having('food.days', '=', $day)
    //             ->orderBy('food.session')
    //             ->get();

    //         if ($obj != '[]') {
    //             for ($i = 0; $i < sizeof($obj); $i++) {
    //                 $selected = $obj[$i];
    //                 $session_index = 'S' . $selected->session;
    //                 $stall_id = $selected->stall;
    //                 if (!empty($item)) {
    //                     if (array_key_exists($day, $item)) {
    //                         if (array_key_exists($session_index, $item[$day])) {
    //                             if (array_key_exists($stall_id, $item[$day][$session_index]))
    //                                 array_push($item[$day][$session_index][$stall_id], $selected);
    //                             else {
    //                                 $item[$day][$session_index] += [$stall_id => [$selected]];
    //                             }
    //                         } else {
    //                             $item[$day] += [$session_index => [$stall_id => [$selected]]];
    //                         }
    //                     } else {
    //                         $item += [$day => [$session_index => [$stall_id => [$selected]]]];
    //                     }
    //                 } else {
    //                     $item = [$day => [$session_index => [$stall_id => [$selected]]]];
    //                 }
    //             }
    //         }
    //     }


    //     $date_range = DateRange::find($request->get('date_range'));
    //     // return response()->json($item['MON']['French Fries'][0]);
    //     return view('reports.index', compact('item', 'days', 'date_range'));
    // }

    public function hawkerReportIndex($stall_id)
    {
        $is_active = 0;
        $date_range = DateRange::all();
        foreach ($date_range as $date_ranges) {
            if ($date_ranges->active_date_range == 1) {
                $is_active = 1;
            }
        }
        return view('classes.orders.classDateRange', compact('date_range', 'is_active', "stall_id"));
    }

    public function hawkerReport(Request $request, $stall_id)
    {
        $days = ['SUN' => 'Sunday', 'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday'];
        $item = [];
        $item2 = [];
        foreach (array_keys($days) as $day) {
            $obj = DB::table('orders')
                ->join('food', 'orders.food_id',  'food.id')
                ->join('stalls', 'stalls.id', 'food.stall_id')
                ->join('users', 'users.id', 'orders.user_id')
                ->join('student_classes', 'users.class_id', 'student_classes.id')
                ->select(DB::raw('SUM(orders.quantity) as quantity , food.name as food ,food.session as session, student_classes.name as class,food.id,student_classes.id'))
                ->where('orders.date_range_id', $request->get('date_range'))
                ->where('stalls.id', '=', $stall_id)
                ->groupBy('food.days', 'food.name', 'food.session', 'student_classes.name', 'food.id', 'student_classes.id')
                ->having('food.days', '=', $day)
                ->orderBy('food.session')
                ->orderBy('student_classes.id')
                //->orderBy('student_classes.id')
                ->get();

            if ($obj != '[]') {
                for ($i = 0; $i < sizeof($obj); $i++) {
                    $selected = $obj[$i];
                    $session_index = 'S' . $selected->session;
                    $food = $selected->food;
                    if (!empty($item)) {
                        if (array_key_exists($day, $item)) {
                            if (array_key_exists($session_index, $item[$day])) {
                                if (array_key_exists($food, $item[$day][$session_index]))
                                    array_push($item[$day][$session_index][$food], $selected);
                                else {
                                    $item[$day][$session_index] += [$food => [$selected]];
                                }
                            } else {
                                $item[$day] += [$session_index => [$food => [$selected]]];
                            }
                        } else {
                            $item += [$day => [$session_index => [$food => [$selected]]]];
                        }
                    } else {
                        $item = [$day => [$session_index =>  [$food => [$selected]]]];
                    }
                }
            }
        }

        $prices = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('student_classes', 'student_classes.id', 'users.class_id')
            ->join('stalls', 'stalls.id', 'food.stall_id')
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('stalls.id', '=', $stall_id)
            ->select(DB::raw('SUM(food.price*orders.quantity) as total_price, student_classes.name as class,student_classes.id'))
            ->groupBy('student_classes.name', 'student_classes.id')
            ->orderBy('student_classes.id')
            ->get();
        $new_prices = [];
        foreach ($prices as $price) {
            $new_prices += [$price->class => $price];
        }


        $stall = Stall::find($stall_id);
        // dd($new_prices);
        $date_range = DateRange::find($request->get('date_range'));
        $i = 0;
        // return response()->json($item['MON']['French Fries'][0]);
        return view('reports.index', compact('item', 'days', 'date_range', 'stall', 'i', 'new_prices'));
    }

    public static function weeklysale($stall_owner_id)
    {
        $date_ranges = DateRange::orderBy('start', 'desc')->take(4)->get();
        $final_result = [];
        foreach ($date_ranges as $date_range) {
            $query =  DB::table('orders')
                ->join('food', 'food.id', 'orders.food_id')
                ->join('stalls', 'stalls.id', 'food.stall_id')
                ->join('date_ranges', 'date_ranges.id', 'food.date_range_id')
                ->where('stalls.user_id', '=', $stall_owner_id)
                ->where('food.date_range_id', '=', $date_range->id)
                ->select(DB::raw('SUM(food.price*orders.quantity) as total_sales , date_ranges.start, date_ranges.end'))
                ->groupBy('food.stall_id', 'food.date_range_id', 'date_ranges.start', 'date_ranges.end')
                ->get();


            if ($query == '[]') {
                $no_earn = DateRange::where('id', '=', $date_range->id)->get();
                $query = ["total_sales" => 0, "start" => $no_earn[0]->start, "end" => $no_earn[0]->end];
            } else {
                $tmp = $query;
                $query = ["total_sales" => (int)$tmp[0]->total_sales, "start" => $tmp[0]->start, "end" => $tmp[0]->end];
            }
            array_push($final_result, $query);
        }

        return $final_result;
    }
}
