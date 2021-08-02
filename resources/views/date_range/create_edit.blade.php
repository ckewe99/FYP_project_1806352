@extends('layouts.app')
@section('content')
    <form method="post" action="{{ isset($data) ? route('date_range.update', $data->id) : route('date_range.store') }}">
        @csrf
        @if (isset($data))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Start Date') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('start') ? 'has-danger' : '' }}">
                    <input type="text" name="start" id="flatpickr-input-start"
                        class="form-control @error('start') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Start Date') }}"
                        value="{{ old('start', isset($data) ? Carbon\Carbon::parse($data->start)->format('d-m-Y') : '') }}"
                        autofocus required>
                    @error('start')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('End Date') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('end') ? 'has-danger' : '' }}">
                    <input type="text" name="end" id="flatpickr-input-end"
                        class="form-control  @error('end') is-invalid @enderror"
                        placeholder="{{ __('Please Enter End Date') }}"
                        value="{{ old('end', isset($data) ? Carbon\Carbon::parse($data->end)->format('d-m-Y') : '') }}"
                        autofocus required>
                    @error('end')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Holidays') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('holidays') ? 'has-danger' : '' }}">
                    <textarea name="holidays" id="flatpickr-input-end"
                        class="form-control  @error('holidays') is-invalid @enderror"
                        placeholder="Please Enter Holidays eg. School Holiday,School Holiday,School Holiday,Chinese New Year,">,,,,</textarea>
                    @error('holidays')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="{{ route('date_range') }}" class="btn btn-fill btn-danger">Back</a>
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
        flatpickr("#flatpickr-input-end", {
            dateFormat: "d-m-Y",
        })
        flatpickr("#flatpickr-input-start", {
            dateFormat: "d-m-Y",
        })
        $('form').submit(function() {
            $('[type="submit"]').attr('disabled', true)
        })

        $('form').submit(function() {
            $('[type="submit"]').attr('disabled', true)
        })
    </script>
@endpush
