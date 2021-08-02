@extends('layouts.app')
@section('content')
    <style>
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }

    </style>

    <!-- Main content -->
    <div class="main-content" id="panel">

        <!-- Page content -->
        <div class="container-fluid  my-5">
        <form method="post" action="{{route('canOrder')}}">
            @csrf
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ __('Open for Order') }}</label>
                    <div class="col-md-8 form-group">

                        <input type="checkbox" name="order" data-toggle="toggle" data-style="ios" data-on="Yes"
                            data-off="No" {{ $data == 1 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ __('Date range to order') }}</label>
                    <div class="col-md-8 form-group">
                        <select class="browser-default custom-select" type='text' name='date_range'>
                        @foreach ($date_range as $item)
                        <option value="{{ $item->id }}"{{ $is_active == 1 ? ($item->active_date_range == 1 ? 'selected' : '') : '' }}>
                            {{ $item->start .' until ' . $item->end }}
                        </option>
                        @endforeach
                        </select>
                        
                    </div>
                </div>
                <br>
                <br>

                <div class="container">
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col">
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-fill bg-gradient-red text-white">Submit</button>
                        </div>

                    </div>
                </div>
            </form>
           
        </div>
    @endsection
