<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class StallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stalls.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stalls.create_edit');
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
            'name' => 'required',
        ]);

        $data = new Stall();
        $data = $request->all();

        Stall::create($data);
        Session::flash('alert-success', 'Successfully Create Stall');
        return redirect()->route('stalls.index');

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
        $data = Stall::findOrFail($id);
        return view('stalls.create_edit', compact('data'));
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
            'name' => 'required',
        ]);

        $data = Stall::find($id);
        $data->name = $request->get('name');

        $data->save();
        Session::flash('alert-success', 'Successfully Update Stall');
        return redirect()->route('stalls.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Stall::findOrFail($id)->delete();
    }

    public function list()
    {
        $stalls = Stall::query();
        return DataTables::of($stalls)
            ->addIndexColumn()
            ->addColumn('action', '<a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route("stalls.edit", $id) }}"><span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span></a><a class="btn btn-outline-danger btn-icon m-1 btn-sm destroy" href="#" data-id="{{$id}}"><span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span></a>')
            ->make();
    }
}
