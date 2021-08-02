@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="container my-5">
            @if (isset($have_class))
                @if ($is_overall == 0)
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h3>Class Order List Per Student</h3>
                        </div>
                    </div>
                    {{-- make changes --}}
                    <form method="get" action="{{ route('class.orderDetails', $class_id) }}">
                    @else
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h3>Class Order List</h3>
                            </div>
                        </div>
                        <form method="get" action="{{ route('class.order', $class_id) }}">
                @endif
            @elseif(isset($stall_id))
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h3>Stall Order List</h3>
                    </div>
                </div>
                <form method="get" action="{{ route('report.hawker', $stall_id) }}">

                @else
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h3>Overall Order List</h3>
                        </div>
                    </div>
                    <form method="get" action="{{ route('report.show') }}">
            @endif

            <div class="row mb-2">
                <label class="col-md-3 col-form-label">{{ __('Date range') }}</label>
                <div class="col-md-8 form-group">
                    <select class="browser-default custom-select" type='text' name='date_range'>
                        @foreach ($date_range as $item)
                            <option value="{{ $item->id }}"
                                {{ $is_active == 1 ? ($item->active_date_range == 1 ? 'selected' : '') : '' }}>
                                {{ $item->start . ' until ' . $item->end }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                @if (Auth::user()->type != 2 ) 
                <div class="col text-left">
                    <a class="btn btn-fill bg-danger text-white" href="{{ route('classes.index') }}">Back</a>
                </div>
                @endif
                <div class="col text-right">
                    <button type="submit" class="btn btn-fill bg-gradient-red text-white">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection
