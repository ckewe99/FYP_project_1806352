@extends('layouts.app')
@section('content')
    <form method="post"
        action="{{ route('menu.store', ['days' => $days, 'session' => $session, 'date_range_id' => $date_range_id]) }}">
        @csrf
        <div class="card-body">
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Food Name') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Food Name') }}" value="{{ old('name') }}" autofocus required>
                    @error('name')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Price') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('price') ? 'has-danger' : '' }}">
                    <input type="number" name="price" step=".01" class="form-control @error('price') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Price') }}" value="{{ old('price') }}" autofocus required>
                    @error('price')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Type') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('type') ? 'has-danger' : '' }}">
                    <input type="text" name="type" class="form-control @error('type') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Type') }}" value="{{ old('type') }}" autofocus required>
                    @error('type')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Stall') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('stall') ? 'has-danger' : '' }}">
                    <select class="browser-default custom-select" type='text' name='stall'>
                        @foreach ($stalls as $stall)
                            <option value="{{ $stall->id }}"
                                {{ isset($data) ? ($data->stall == $stall->id ? 'selected' : '') : '' }}>
                                {{ $stall->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('stall')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Start Date') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('start') ? 'has-danger' : '' }}">
                    <input type="text" name="start" readonly class="form-control  @error('start') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Start Date') }}"
                        value="{{ Carbon\Carbon::parse($date_range->start)->format('d-m-Y') }}" autofocus required>
                    @error('start')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('End Date') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('end') ? 'has-danger' : '' }}">
                    <input type="text" name="end" readonly class="form-control   @error('end') is-invalid @enderror"
                        placeholder="{{ __('Please Enter End Date') }}"
                        value="{{ Carbon\Carbon::parse($date_range->end)->format('d-m-Y') }}" autofocus required>
                    @error('end')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Dessert') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('dessert') ? 'has-danger' : '' }}">
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
                    <input type="checkbox" name="dessert" data-toggle="toggle" data-style="ios" data-on="Yes" data-off="No">
                    @error('dessert')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>



        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="{{ route('menu.show', [$days, 'date_range_id' => request()->get('date_range_id')]) }}"
                        class="btn btn-fill btn-danger">Back</a>
                </div>
                <div class="col">
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-fill bg-gradient-red text-white">Submit</button>
                </div>

            </div>
        </div>
    </form>
@endsection
@push('js')
    <script>
        $('form').submit(function() {
            $('[type="submit"]').attr('disabled', true)
        })

    </script>
@endpush
