@extends('layouts.app')
@section('content')
    <form method="post" action="{{ isset($data) ? route('stalls.update', $data->id) : route('stalls.store') }}">
        @csrf
        @if (isset($data))
            @method('PUT')
        @endif
        <div class="card-body">
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Name') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <input type="text" name="name" 
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Name') }}" value="{{ old('name' , isset($data) ? $data->name : '') }}" autofocus required>
                    @error('name')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="{{ route('stalls.index') }}" class="btn btn-fill btn-danger">Back</a>
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
    
    </script>
@endpush
