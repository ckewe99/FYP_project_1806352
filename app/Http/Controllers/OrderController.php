<?php

namespace App\Http\Controllers;

use App\Models\DateRange;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use App\Models\Stall;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $d_1 = array('SUN', 'MON', 'TUE', 'WED', 'THU');

        $date_range = DateRange::where('active_date_range', 1)->first();

        $days = [];
        $now = Carbon::createFromDate($date_range->start);
        foreach ($d_1 as $d) {
            $days += [$d => $now->isoFormat('dddd D-MM-YYYY')];
            $now = $now->add(1, 'day');
        }

        $s1_main_non_vege = [Food::where('session', 1)->where('stall_id', 1)->where('dessert', 0)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s1_main_vege =  [Food::where('session', 1)->where('stall_id', 2)->where('dessert', 0)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s1_main_bev = [Food::where('session', 1)->where('stall_id', 3)->where('dessert', 0)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s1_side =  [Food::where('session', 1)->where('dessert', 1)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s2_main_non_vege =  [Food::where('session', 2)->where('stall_id', 1)->where('dessert', 0)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s2_main_vege =  [Food::where('session', 2)->where('stall_id', 2)->where('dessert', 0)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s2_main_bev =  [Food::where('session', 2)->where('stall_id', 3)->where('dessert', 0)->where('date_range_id', $date_range->id)->get()->groupBy('days')];

        $s2_side =  [Food::where('session', 2)->where('dessert', 1)->where('date_range_id', $date_range->id)->get()->groupBy('days')];




        return view('orders.index', compact('s2_main_non_vege', 's2_side', 's2_main_vege', 's2_main_bev', 's1_main_non_vege', 's1_side', 's1_main_vege', 's1_main_bev', 'days', 'date_range'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = count($request->get('quantity'));



        try {
            DB::beginTransaction();

            $transaction = new Transaction();
            $transaction->save();

            for ($i = 0; $i < $count; $i++) {
                $data = new Order();
                $data->user_id = Auth::id();
                $data->food_id = $request->food[$i];
                $data->quantity =  $request->quantity[$i];
                $data->date_range_id =  DateRange::where('active_date_range', 1)->pluck('id')->first();
                $data->transaction_id = $transaction->id;
                $data->save();
            }

            $user = User::find(Auth::id());
            $user->ordered = 1;
            $user->save();

            DB::commit();
            Session::flash('alert-success', 'Successfully Ordered');
            return redirect()->route('home');
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $order = Order::find($id);
        $order->quantity = $request->get('quantity');
        $order->save();

        Session::flash('alert-success', 'Successfully Changed');
        return redirect()->route('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkout(Request $request)
    {
        $d_1 = array('SUN', 'MON', 'TUE', 'WED', 'THU');
        $data = $request->except("_token");
        $new_array = [];
        $start_date = [];



        foreach ($data as $data_key => $data_values) {

            if ($data_values != null) {
                $start_date = DB::table('food')
                    ->join('date_ranges', 'food.date_range_id', 'date_ranges.id')
                    ->where('food.id', '=', $data_values)
                    ->select('date_ranges.start')
                    ->get();
                break;
                //dd($start_date[0]->start);
            }
        }
        if ($start_date == []) {
            return redirect()->route('order.index')
                ->withErrors("Please select at least a dish")
                ->withInput();
        }

        $days = [];
        $now = Carbon::createFromDate($start_date[0]->start);
        foreach ($d_1 as $d) {
            $days += [$d => $now->isoFormat('dddd D-MM-YYYY')];
            $now = $now->add(1, 'day');
        }


        foreach ($data as $data_key => $data_value) {

            if ($data_value != null) {
                $day = DB::table('food')->select('days')->where('id', '=', $data_value)->get();
                $session = DB::table('food')->select('session')->where('id', '=', $data_value)->get();
                if (!empty($new_array)) {
                    if (array_key_exists($day[0]->days, $new_array)) {
                        if (array_key_exists($session[0]->session, $new_array[$day[0]->days]))
                            array_push($new_array[$day[0]->days][$session[0]->session], Food::find($data_value));
                        else {
                            $new_array[$day[0]->days] += [$session[0]->session => [Food::find($data_value)]];
                        }
                    } else {
                        $new_array += [$day[0]->days => [$session[0]->session => [Food::find($data_value)]]];
                    }
                } else {
                    $new_array = [$day[0]->days => [$session[0]->session => [Food::find($data_value)]]];
                }
            }
        }

        return view('orders.show', compact('new_array', 'days'));
    }


    public function orderHistorySelectDateRange()
    {
        $is_active = 0;
        $date_range = DateRange::all();
        foreach ($date_range as $date_ranges) {
            if ($date_ranges->active_date_range == 1) {
                $is_active = 1;
            }
        }
        return view('orders.individual.index', compact('date_range', 'is_active'));
    }

    public function history(Request $request)
    {
        $sessions = ['1' => 'Session 1', '2' => 'Session 2'];
        $days = ['SUN' => 'Sunday', 'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday'];
        $item = [];
        $total_price = 0;
        $data = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->where('orders.user_id', '=', Auth::id())
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->select(DB::raw('food.price*orders.quantity as total_price, food.name, food.session,food.days,orders.quantity,orders.id as order_id'))
            ->orderByRaw('food.days,food.session')
            ->get();



        //no problem
        foreach ($data as $food) {
            $total_price += $food->total_price;
            if (array_key_exists($food->days, $item)) {
                if (array_key_exists($food->session, $item[$food->days])) {
                    array_push($item[$food->days][$food->session], $food);
                } else {
                    $item[$food->days] += [$food->session => [$food]];
                }
            } else {
                $item = [$food->days => [$food->session => [$food]]];
            }
        }

        $tol_price = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('stalls', 'stalls.id', 'food.stall_id')
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('orders.user_id', '=', Auth::id())
            ->select(DB::raw('SUM(food.price*orders.quantity) as total_price, stalls.name as stall'))
            ->groupBy('stalls.name')
            ->get();

        $date_range = DateRange::find($request->get('date_range'));

        // return response()->json($date_range);
        return view('orders.individual.show', compact('data', 'total_price', 'date_range', 'days', 'sessions', 'tol_price'));
    }

    public function editOrder(Request $request)
    {
        $order = Order::find($request->order_id);

        $food_info = Food::find($order->food_id);

        return view('orders.individual.edit', compact('order', 'food_info'));
    }

    public function deleteOrder($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::where('user_id', '=', Auth::id())
                ->where('date_range_id', '=', $id)->first();
            Transaction::find($order->transaction_id)->delete();
            // Order::where('user_id', '=', Auth::id())
            //     ->where('date_range_id', '=', $id)
            //     ->delete();

            $user = User::find(Auth::id());
            $user->ordered = 0;
            $user->save();
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();


        Session::flash('alert-success', 'Successfully Deleted');
        return redirect()->route('home');
    }

    public function edits($id, Request $request)
    {

        $order = Order::find($id);
        $order->quantity = $request->get('quantity');
        $order->save();

        Session::flash('alert-success', 'Successfully Changed');
        return redirect()->route('home');
    }

    public function checkAmount(Request $request)
    {
        //return $request;
        $stalls = Stall::all();
        $date_range = DateRange::all();
        $stall = Stall::where('user_id', Auth::id())->first();

        if (Auth::user()->type == 1) {
            $s = Stall::find($request->get('stall_id'));
            $result = DB::table('users')
                ->join('orders', 'orders.user_id', 'users.id')
                ->join('food', 'food.id', 'orders.food_id')
                ->where('orders.date_range_id', $request->get('date_range'))
                ->where('users.student_physical_id', $request->get('id'))
                ->where('food.stall_id', $s->id)
                ->select(DB::raw('SUM(food.price*orders.quantity) as total_price, users.name as name'))
                ->groupByRaw('orders.date_range_id,food.stall_id,users.student_physical_id,users.name')
                ->get();


            $items = DB::table('users')
                ->join('orders', 'orders.user_id', 'users.id')
                ->join('food', 'food.id', 'orders.food_id')
                ->where('orders.date_range_id', $request->get('date_range'))
                ->where('users.student_physical_id', $request->get('id'))
                ->where('food.stall_id', $s->id)
                ->select(DB::raw('food.name, orders.quantity'))
                ->get();
        } else if (Auth::user()->type == 2) {
            $s = Stall::where('user_id', Auth::user()->id)->get();
            $result = DB::table('users')
                ->join('orders', 'orders.user_id', 'users.id')
                ->join('food', 'food.id', 'orders.food_id')
                ->where('orders.date_range_id', $request->get('date_range'))
                ->where('users.student_physical_id', $request->get('id'))
                ->where('food.stall_id', $s[0]->id)
                ->select(DB::raw('SUM(food.price*orders.quantity) as total_price, users.name as name'))
                ->groupByRaw('orders.date_range_id,food.stall_id,users.student_physical_id,users.name')
                ->get();


            $items = DB::table('users')
                ->join('orders', 'orders.user_id', 'users.id')
                ->join('food', 'food.id', 'orders.food_id')
                ->where('orders.date_range_id', $request->get('date_range'))
                ->where('users.student_physical_id', $request->get('id'))
                ->where('food.stall_id', $s[0]->id)
                ->select(DB::raw('food.name, orders.quantity'))
                ->get();
        }



        return view('dashboard', compact('result', 'date_range', 'stalls', 'items', 'stall'));
    }
}
