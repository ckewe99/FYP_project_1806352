@extends('layouts.app')
@section('content')
    <form method="post" action="{{ route('users.update', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Email') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('email') ? 'has-danger' : '' }}">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{ __('Please Enter email') }}" value="{{ old('email') ?? $data->email }}" autofocus
                        required>
                    @error('email')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Name') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('name') ? 'has-danger' : '' }}">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Name') }}" value="{{ old('name') ?? $data->name }}" autofocus
                        required>
                    @error('name')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Type') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('type') ? 'has-danger' : '' }}">
                    <select class="browser-default custom-select" type='text' name='type'>
                        <option {{ $data->type === 1 ? 'selected' : '' }} value="1">Admin</option>
                        <option {{ $data->type === 3 ? 'selected' : '' }} value="3">Teacher</option>
                        <option {{ $data->type === 4 ? 'selected' : '' }} value="4">Student</option>
                        <option {{ $data->type === 2 ? 'selected' : '' }} value="2">Kitchen</option>
                    </select>
                    @error('type')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Class') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('class_id') ? 'has-danger' : '' }}">
                    <select class="browser-default custom-select" type='text' name='class_id'>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ isset($data) ? ($data->class_id == $class->id? 'selected' : '') : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Student ID') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('student_physical_id') ? 'has-danger' : '' }}">
                    <input type="text" name="student_physical_id"
                        class="form-control @error('student_physical_id') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Student ID') }}"
                        value="{{ old('student_physical_id') ?? $data->student_physical_id }}" autofocus>
                    @error('student_physical_id')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Password') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('password') ? 'has-danger' : '' }}">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Password') }}" value="{{ old('password') }}" autofocus>
                    @error('password')
                        <div class="invalid-div text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <label class="col-md-3 col-form-label">{{ __('Confirm Password') }}</label>
                <div class="col-md-8 form-group {{ $errors->has('password_confirm') ? 'has-danger' : '' }}">
                    <input type="password" name="password_confirm"
                        class="form-control @error('password_confirm') is-invalid @enderror"
                        placeholder="{{ __('Please Enter Confirm Password') }}" value="{{ old('password_confirm') }}"
                        autofocus>
                    @error('password_confirm')
                        <div class="invalid-div text-danger ">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="{{ route('users.index') }}" class="btn btn-fill btn-danger">Back</a>
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
