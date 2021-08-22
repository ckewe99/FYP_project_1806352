<?php

namespace App\Http\Controllers;

use App\Models\DateRange;
use App\Models\Food;
use App\Models\Stall;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\FoodClassificationService\KNN;
use App\Services\TextSentiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lol = DB::table('orders')
            ->where('user_id', '=', Auth::id())
            ->select('date_range_id')
            ->groupBy('date_range_id')
            ->get();
        $times = $lol->count();
        $knn = new KNN();
        $array = [];
        $array2 = [];
        if ($times <= 0) {
            try {
                //retrieve user fav
                $items = UserController::fav_top_5();
                foreach ($items as $item) {
                    array_push($array, $knn->getResult(json_decode($item->matrix)));
                }

                //retrieve food stall
                $active_date_range = DateRange::where('active_date_range', '=', 1)->get();

                $foods = Food::where('date_range_id', '=', $active_date_range[0]['id'])
                    ->groupBy('name', 'matrix')
                    ->select('name', 'matrix')
                    ->orderBy('stall_id')
                    ->get();

                if ($foods == null) {
                    return 'yes null';
                }
                foreach ($foods as $food) {

                    $result = $knn->getResult(json_decode($food['matrix']));

                    foreach ($array as $i) {
                        if ($i["result"] == $result['result']) {
                            //matched
                            array_push($array2, $food);
                            break;
                        }
                    }
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }


        $strings = Transaction::select('comments')->get();
        $data = TextSentiment::sentiment($strings);
        $stalls = Stall::all();
        $date_range = DateRange::all();
        $stall = Stall::where('user_id', Auth::id())->first();
        return view('dashboard', compact('stalls', 'date_range', 'stall', 'data', 'array2', 'times'));
    }

    public function setting()
    {
        $is_active = 0;
        if (User::where('can_order', 1)->first()) {
            $data = true;
        } else {
            $data = false;
        }

        $date_range = DateRange::all();

        foreach ($date_range as $date_ranges) {
            if ($date_ranges->active_date_range == 1) {
                $is_active = 1;
            }
        }


        return view('setting.index', compact('data', 'date_range', 'is_active'));
    }

    public function canOrder(Request $request)
    {

        DB::beginTransaction();

        try {
            if ($request->has('order')) { //open order
                DB::table('users')->update(array('can_order' => 1, 'ordered' => 0));
                $uids = User::all()->pluck('id');
                $date_range_obj = DateRange::find($request->date_range);
                if ($date_range_obj->opened) { //has been opened
                    foreach ($uids as $uid) {
                        // check ordered
                        if (Order::where('date_range_id', $request->date_range)->where('user_id', $uid)->first()) {
                            $user = User::find($uid);
                            $user->ordered = 1;
                            $user->save();
                        }
                    }
                } else { // never open
                    $date_range_obj->opened = 1;
                    $date_range_obj->save();
                }
            } else { //close order
                DB::table('users')->update(array('can_order' => 0));
            }

            DB::table('date_ranges')->update(array('active_date_range' => 0));

            if (DateRange::find($request->get('date_range'))) {
                $data = DateRange::find($request->get('date_range'));
                $data->active_date_range = 1;
                $data->save();
            }
        } catch (Exception $e) {
            DB::rollBack();
        }

        DB::commit();

        Session::flash('alert-success', 'Successfully Update Status');
        return redirect()->route('setting');
    }
}
