<?php

namespace App\Http\Controllers;



use App\Services\Dijkstra\Dijkstra;
use Illuminate\Support\Facades\DB;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\FoodClassificationService\KNN;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('view-any', User::class)) {
            return view('users.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = StudentClass::all();
        return view('users.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:255|min:4',
            'email' => 'required|email|unique:users,email',
            'student_physical_id' => 'required|unique:users,student_physical_id',
            'class_id' => 'required',
            'type' => 'required',
            'password' => 'required|min:6|same:password_confirm',
            'password_confirm' => 'required|min:6|same:password',
        ]);

        $data = new User();
        $data = $request->except('password', 'password_confirm');

        $data['email_verified_at'] = Carbon::now();
        $data['password'] = bcrypt($request->get('password'));

        if (User::where('can_order', 1)->first()) {
            $data['can_order'] = true;
        } else {
            $data['can_order'] = false;
        }
        // dd($data);
        User::create($data);
        Session::flash('alert-success', 'Successfully Create User');
        return redirect()->route('users.index');
    }

    /**users
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
        $data = User::findOrFail($id);
        $type = User::all('type');
        $classes = StudentClass::all();
        return view('users.edit', compact('data', 'type', 'classes'));
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
        if (Auth::user()->cannot('update', User::class)) {
            //display error here
        }
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
            'student_physical_id' => 'required|unique:users,student_physical_id,' . $id,
            'type' => 'required',
            'class_id' => 'required',
        ]);

        $data = User::findOrFail($id);
        $data->fill($request->only('name', 'email', 'student_physical_id', 'type', 'class_id'));

        if ($request->get('password')) {
            $validator = Validator::make($request->only(['password', 'password_confirm']), ['password' => 'same:password_confirm']);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $data->password = bcrypt($request->get('password'));
        }

        if (User::where('can_order', 1)->first()) {
            $data['can_order'] = true;
        } else {
            $data['can_order'] = false;
        }

        $data->save();
        Session::flash('alert-success', 'Successfully Update User');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('delete', User::class)) {
            User::findOrFail($id)->delete();
        }
    }

    public function list()
    {
        $users = User::where('type', '!=', 1);
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route("users.edit", $id) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a><a class="btn btn-outline-danger btn-icon m-1 btn-sm destroy" href="#" data-id="{{$id}}"><span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span></a>')
            ->addColumn('class_id', function ($data) {
                if ($data->class_id != '') {
                    $classes = StudentClass::where('id', $data->class_id)->first();
                    return $classes->name;
                } else {
                    return "";
                }
            })
            ->make();
    }

    public function profile()
    {
        $user = Auth::user();
        $class = StudentClass::find($user->class_id);
        //return $user->id;
        return view('users.profile', compact('user', 'class'));
    }

    public function viewChangePwd()
    {
        return view('users.change-pwd');
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|regex:/^(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,}$/|same:confirm_password',
            'confirm_password' => 'required|same:new_password',
        ];

        $custom_message = [
            'new_password.regex' => 'The password must be alphanumeric with at least 6 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $custom_message);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }


        $user = Auth::user();
        $target_acc = User::findOrFail($user->id);

        $matched = Hash::check($request->get('old_password'), $target_acc->password);

        if (!empty($target_acc)) {
            if ($matched) {
                $target_acc->password = Hash::make($request->input('new_password'));
                $target_acc->save();
                Session::flash('alert-success', 'Successfully Update User');
                return redirect()->route('profile');
            } else {
                Session::flash('alert-danger', 'Invalid Old Password!');
                return redirect()->back();
            }
        } else {
            Session::flash('alert-danger', 'Record was Not Found!');
            return redirect()->back();
        }
    }


    public static function fav_top_5()
    {
        $obj = DB::table('orders')
            ->join('food', 'orders.food_id', '=', 'food.id')
            ->select('food.name', DB::raw('COUNT(food.name) as quantity'))
            ->groupBy('food.name')
            ->where('orders.user_id', Auth::id())
            ->orderBy('quantity', 'desc')
            ->take(5)
            ->get();

        return $obj;
    }



    public function dijakstra(Request $request)
    {

        $graph = array(
            'J1C' => array('B' => 9, 'D' => 14, 'F' => 7),
            'B' => array('J1C' => 9, 'C' => 11, 'D' => 2, 'F' => 10),
            'C' => array('B' => 11, 'E' => 6, 'F' => 15),
            'D' => array('J1C' => 14, 'B' => 2, 'E' => 9),
            'E' => array('C' => 6, 'D' => 9),
            'F' => array('J1C' => 7, 'B' => 10, 'C' => 15),
            'G' => array(),
        );

        $algorithm = new Dijkstra($graph);
        return $algorithm->shortestPaths($request->from, $request->to);
        //$path = $algorithm->shortestPaths('A', 'E', array('F'));
    }
}
