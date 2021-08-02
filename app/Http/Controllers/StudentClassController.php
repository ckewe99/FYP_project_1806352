<?php

namespace App\Http\Controllers;

use App\Models\DateRange;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classes.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:student_classes,name',
        ]);

        $data = $request->all();

        StudentClass::create($data);

        Session::flash('alert-success', 'Successfully Create a Class');
        return redirect()->route('classes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = StudentClass::find($id);
        return view('classes.create_edit', compact('data'));
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
        $this->validate($request, [
            'name' => 'required|unique:student_classes,name,' . $id,
        ]);

        $data = StudentClass::find($id);

        $data->update($request->all());
        Session::flash('alert-success', 'Successfully Update a Class');
        return redirect()->route('classes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = StudentClass::find($id);
        $data->delete();
    }

    public function list()
    {
        $class = StudentClass::query();
        return DataTables::of($class)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" title="Edit class" href="{{ route("classes.edit", $id) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a>
            <a class="btn btn-outline-danger btn-icon m-1 btn-sm "destroy" href="#" title="Delete class" data-id="{{$id}}"><span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span></a>
            <a class="btn btn-outline-primary btn-icon m-1 btn-sm" title="Class Student List" href="{{ route("class.name-list", $id) }}"><span class="ul-btn__icon"><i class="fal fa-list-alt"></i></span></a>
            <a class="btn btn-outline-warning btn-icon m-1 btn-sm" title="Student Overall Order" href="{{ route("orderDateRange", $id) }}"><span class="ul-btn__icon"><i class="far fa-sticky-note"></i></span></a>
            <a class="btn btn-outline-success btn-icon m-1 btn-sm" title="Student Order" href="{{ route("orderDateRange",[$id , "is_overall" => 0]) }}"><span class="ul-btn__icon"><i class="fal fa-book-spells"></i></span></a>')
            ->make();
    }

    public function class($class_id)
    {
        $class = StudentClass::find($class_id);

        return view("classes.list.index", compact('class'));
    }

    public function nameList($id)
    {
        $data = User::where('class_id', $id)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }
    public function orderDateRange(Request $request, $class_id)
    {
        $is_active = 0;
        if ($request->has('is_overall')) {
            $is_overall = 0;
        } else {
            $is_overall = 1;
        }
        $have_class = 1;
        $date_range = DateRange::all();
        foreach ($date_range as $date_ranges) {
            if ($date_ranges->active_date_range == 1) {
                $is_active = 1;
            }
        }

        return view("classes.orders.classDateRange", compact('date_range', 'is_active', 'have_class', 'class_id', 'is_overall'));
    }

    public function order(Request $request, $class_id)
    {
        $data = [];
        $days = ['SUN' => 'Sunday', 'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday'];
        $sessions = ['1' => '第一下课', '2' => '第二下课'];

        foreach (array_keys($days) as $day) {
            $obj = DB::table('orders')
                ->join('food', 'food.id', '=', 'orders.food_id')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('stalls', 'stalls.id', 'food.stall_id')
                ->where('users.class_id', '=', $class_id)
                ->where('food.days', '=', $day)
                ->where('orders.date_range_id', $request->get('date_range'))
                ->groupBy('food.session', 'food.name', 'food.id', 'stalls.name')
                ->select('food.name', DB::raw("SUM(orders.quantity) as quantity, stalls.name as stall"), 'food.session')
                ->orderBy('food.session')
                ->get();

            if ($obj != '[]') {
                for ($i = 0; $i < sizeof($obj); $i++) {
                    $selected = $obj[$i];
                    $session_index = $selected->session;
                    $stall_id = $selected->stall;
                    if (!empty($data)) {
                        if (array_key_exists($day, $data)) {
                            if (array_key_exists($session_index, $data[$day])) {
                                if (array_key_exists($stall_id, $data[$day][$session_index]))
                                    array_push($data[$day][$session_index][$stall_id], $selected);
                                else {
                                    $data[$day][$session_index] += [$stall_id => [$selected]];
                                }
                            } else {
                                $data[$day] += [$session_index => [$stall_id => [$selected]]];
                            }
                        } else {
                            $data += [$day => [$session_index => [$stall_id => [$selected]]]];
                        }
                    } else {
                        $data = [$day => [$session_index => [$stall_id => [$selected]]]];
                    }
                }
            }
        }

        $class = StudentClass::find($class_id);
        $date_range = DateRange::find($request->get('date_range'));

        return view("classes.orders.index", compact('class', 'data', 'days', 'date_range', 'sessions'));
    }

    public function orderDetails(Request $request, $class_id)
    {
        $days = ['SUN' => 'Sunday', 'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday'];
        $sessions = ['1' => '第一下课', '2' => '第二下课'];
        $date_range = DateRange::find($request->get('date_range'));
        $class = StudentClass::find($class_id);
        $users = User::where('class_id', '=', $class_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $SUN_orders = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('food.days', '=', 'SUN')
            ->select('orders.quantity', 'food.name', 'orders.user_id', 'food.session')
            ->orderBy('orders.user_id')
            ->orderBy('food.session')
            ->get();

        $MON_orders = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('food.days', '=', 'MON')
            ->select('orders.quantity', 'food.name', 'orders.user_id', 'food.session')
            ->orderBy('orders.user_id')
            ->orderBy('food.session')
            ->get();

        $TUE_orders = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('food.days', '=', 'TUE')
            ->select('orders.quantity', 'food.name', 'orders.user_id', 'food.session')
            ->orderBy('orders.user_id')
            ->orderBy('food.session')
            ->get();

        $WED_orders = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('food.days', '=', 'WED')
            ->select('orders.quantity', 'food.name', 'orders.user_id', 'food.session')
            ->orderBy('orders.user_id')
            ->orderBy('food.session')
            ->get();

        $THU_orders = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->where('food.days', '=', 'THU')
            ->select('orders.quantity', 'food.name', 'orders.user_id', 'food.session')
            ->orderBy('orders.user_id')
            ->orderBy('food.session')
            ->get();

        $SUN_orders = $this->orderDetailsGroupBy($SUN_orders);
        $MON_orders = $this->orderDetailsGroupBy($MON_orders);
        $TUE_orders = $this->orderDetailsGroupBy($TUE_orders);
        $WED_orders = $this->orderDetailsGroupBy($WED_orders);
        $THU_orders = $this->orderDetailsGroupBy($THU_orders);

        $prices = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->select(DB::raw('SUM(food.price*orders.quantity) as total_price, orders.user_id as user_id'))
            ->groupBy('orders.user_id')
            ->orderByRaw('user_id')
            ->get();
        $new_prices = [];
        foreach ($prices as $price) {
            $new_prices += [$price->user_id => $price];
        }
        // return $MON_orders;

        $tol_price = DB::table('food')
            ->join('orders', 'orders.food_id', 'food.id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('stalls', 'stalls.id', 'food.stall_id')
            ->where('users.class_id', '=', $class_id)
            ->where('orders.date_range_id', '=', $request->get('date_range'))
            ->select(DB::raw('SUM(food.price*orders.quantity) as total_price,stalls.name as stall'))
            ->groupBy('stalls.name')
            ->get();

        return view('classes.orders.details.index', compact('tol_price', 'users', 'new_prices', 'SUN_orders', 'MON_orders', 'TUE_orders', 'WED_orders', 'THU_orders', 'class', 'date_range', 'days', 'sessions'));
    }

    public function orderDetailsGroupBy($orders)
    {
        $final_arr = [];

        foreach ($orders as $order) {
            $target = $order;

            if (!empty($final_arr)) {
                if (array_key_exists($target->user_id, $final_arr)) {
                    if (array_key_exists($target->session, $final_arr[$target->user_id])) {
                        array_push($final_arr[$order->user_id][$order->session], $order);
                    } else {
                        $final_arr[$target->user_id] += [$target->session => [$order]];
                    }
                } else {
                    $final_arr += [$target->user_id => [$target->session => [$order]]];
                }
            } else {
                $final_arr = [$target->user_id => [$target->session => [$order]]];
            }
        }


        return $final_arr;
    }
}
