<?php

namespace App\Http\Controllers;

use App\Models\DateRange;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DateRangeController extends Controller
{
    public function date_range()
    {
        return view('date_range.index');
    }

    public function date_range_list()
    {
        $class = DateRange::query();
        return DataTables::of($class)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route("date_range.edit", $id) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a><a class="btn btn-outline-danger btn-icon m-1 btn-sm destroy" href="#" data-id="{{$id}}"><span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span></a>')
            ->make();
    }

    public function date_range_create()
    {
        return view('date_range.create_edit');
    }

    public function date_range_store(Request $request)
    {
        $request->validate(
            [
                'start' => 'required',
                'end' => 'required',
            ],
            [
                'start.required' => 'The Start Date field is required !',
                'end.required' => 'The End Date field is required !'
            ]
        );

        $data = $request->all();
        $holiday_arr = explode(',', $data['holidays']);
        // $keys = array('SUN', 'MON', 'TUE', 'WED', 'THU');
        // $holiday_arr = array_fill_keys($keys, $holiday_arr);
        $data['holidays'] = $holiday_arr;
        $data['start'] = Carbon::createFromFormat('d-m-Y',  $request->get('start'));
        $data['end'] = Carbon::createFromFormat('d-m-Y',  $request->get('end'));
        DateRange::create($data);
        Session::flash('alert-success', 'Successfully Create Date Range');
        return redirect()->route('date_range');
    }

    public function date_range_edit($id)
    {

        $data = DateRange::find($id);

        return view('date_range.create_edit', compact('data'));
    }

    public function date_range_update(Request $request, $id)
    {
        $request->validate(
            [
                'start' => 'required',
                'end' => 'required',
            ],
            [
                'start.required' => 'The Start Date field is required !',
                'end.required' => 'The End Date field is required !'
            ]
        );

        $data = DateRange::find($id);
        $holiday_arr = explode(',', $request->get('holidays'));
        // $keys = array('SUN', 'MON', 'TUE', 'WED', 'THU');
        // $holiday_arr = array_fill_keys($keys, $holiday_arr);
        $data->holidays = $holiday_arr;
        $data->start = Carbon::createFromFormat('d-m-Y',  $request->get('start'));
        $data->end = Carbon::createFromFormat('d-m-Y',  $request->get('end'));
        $data->save();
        Session::flash('alert-success', 'Successfully Update date range');
        return redirect()->route('date_range');
    }

    public function date_range_delete($id)
    {
        DateRange::findOrFail($id)->delete();
    }
}
