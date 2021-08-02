<?php

namespace App\Http\Controllers;

use App\Imports\FoodsImport;
use App\Models\DateRange;
use App\Models\Food;
use App\Models\Stall;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MenuController extends Controller
{

    public function chooseDateRange()
    {
        return view('menus.dateRange');
    }
    public function chooseDateRangeList()
    {
        $class = DateRange::query();
        return DataTables::of($class)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route("menus_index", $id) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a>')
            ->make();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function menusIndex($date_range_id)
    {

        //changing

        $date_range = DateRange::findOrFail($date_range_id);
        $days = ['SUN' => 'Sunday', 'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday'];
        return view('menus.index', compact('days', 'date_range'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $date_range_id = $request->get('date_range_id');
        $days = $request->get('days');
        $session = $request->get('session');
        $date_range = DateRange::findOrFail($date_range_id);
        $stalls = Stall::all();
        return view('menus.create', compact('days', 'session', 'date_range_id', 'date_range', 'stalls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'stall' => 'required',
                //'dessert' => 'required',
                // 'start' => 'required',
                // 'end' => 'required',

            ],
            // [
            //     'start.required' => 'The Start Date field is required !',
            //     'end.required' => 'The End Date field is required !'
            // ]
        );

        $data = $request->all();

        $data['dessert'] = $request->has('dessert') ? 1 : 0;

        // $data['start'] = Carbon::createFromFormat('d-m-Y',  $request->get('start'));
        // $data['end'] = Carbon::createFromFormat('d-m-Y',  $request->get('end'));
        $data['date_range_id'] = $request->get('date_range_id');
        $data['stall_id'] = $request->get('stall');


        Food::create($data);
        Session::flash('alert-success', 'Successfully Create List');
        return redirect()->route('menu.show', [$request->get('days'), 'date_range_id' => $request->get('date_range_id')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $days)
    {
        $date_range_id = $request->get('date_range_id');
        DateRange::findOrFail($date_range_id);
        return view('menus.show', compact('days', 'date_range_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $date_range_id = $request->get('date_range_id');
        $date_range = DateRange::findOrFail($date_range_id);
        $data = Food::findOrFail($id);
        $stalls = Stall::all();
        return view('menus.edit',  compact('data', 'date_range_id', 'date_range', 'stalls'));
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
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'stall' => 'required',
                // 'type' => 'required',
                // 'start' => 'required',
                // 'end' => 'required',

            ],
            //     [
            //         'start.required' => 'The Start Date field is required !',
            //         'end.required' => 'The End Date field is required !'
            //     ]
        );
        $data = $request->all();
        // $data['dessert'] = $request->has('dessert');
        // $data['start'] = Carbon::createFromFormat('d-m-Y',  $request->get('start'));
        // $data['end'] = Carbon::createFromFormat('d-m-Y',  $request->get('end'));
        $data['date_range_id'] = $request->get('date_range_id');
        $data['stall_id'] = $request->get('stall');

        Food::find($id)->update($data);
        Session::flash('alert-success', 'Successfully Update List');
        return redirect()->route('menu.show', [$request->get('days'), 'date_range_id' => $request->get('date_range_id')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Food::findOrFail($id)->delete();
    }

    public function sessionOneList($days, $date_range_id)
    {
        $ans = DB::table("food")
            ->join("stalls", 'stalls.id', 'food.stall_id')
            ->where([['days', $days], ['session', 1], ['date_range_id', $date_range_id]])
            ->select('food.*', DB::raw('stalls.name as stall'),)
            ->get();

        return DataTables::of($ans)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route("menu.edit", [ $id ,  "date_range_id" => $date_range_id]) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a><a class="btn btn-outline-danger btn-icon m-1 btn-sm destroy" href="#" data-id="{{$id}}"><span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span></a>')
            // ->editColumn('dessert', function ($data) {
            //     if ($data->dessert) {
            //         return 'Yes';
            //     } else {
            //         return 'No';
            //     }
            // })
            ->make();
    }

    public function sessionTwoList($days, $date_range_id)
    {
        $ans = DB::table("food")
            ->join("stalls", 'stalls.id', 'food.stall_id')
            ->where([['days', $days], ['session', 2], ['date_range_id', $date_range_id]])
            ->select('food.*', DB::raw('stalls.name as stall'),)
            ->get();
        return DataTables::of($ans)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route("menu.edit",  [ $id ,  "date_range_id" => $date_range_id]) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a><a class="btn btn-outline-danger btn-icon m-1 btn-sm destroy" href="#" data-id="{{$id}}"><span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span></a>')
            // ->editColumn('dessert', function ($data) {
            //     if ($data->dessert) {
            //         return 'Yes';
            //     } else {
            //         return 'No';
            //     }
            // })
            ->make();
    }

    public function testImport(Request $request)
    {
        Excel::import(new FoodsImport($request->get('date_range_id')), $request->file('import_food'));
        Session::flash('alert-success', 'Imported Successfully');
        return redirect()->route('menus_index', $request->get('date_range_id'));
    }
}
