@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">Change Password</h3>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <form action="{{ route('change-pwd') }}" method="post">
                            @csrf
                            <div class="form-group {{ $errors->has('old_password') ? 'has-danger' : '' }}">
                                <label>Old Password</label>
                                <input name="old_password" type="password"
                                    class="form-control @error('old_password') is-invalid @enderror"
                                    placeholder="Please Enter Your Old Password">
                                @error('old_password')
                                    <div class="invalid-div text-danger ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group {{ $errors->has('new_password') ? 'has-danger' : '' }}">
                                <label>New Password</label>
                                <input name="new_password" id="myInput" type="password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    placeholder="Please Enter Your New Password">
                                <input type="checkbox" onclick="myFunction()"> Show Password

                                @error('new_password')
                                    <div class="invalid-div text-danger ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                                <label>Confirm Password</label>
                                <input name="confirm_password" type="password"
                                    class="form-control @error('confirm_password') is-invalid @enderror"
                                    placeholder="Please Re-enter Your New Password">
                                @error('confirm_password')
                                    <div class="invalid-div text-danger ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 text-left">
                                    <a class="btn btn-primary" href="{{ route('profile') }}">Back</a>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        $('form').submit(function() {
            $('[type="submit"]').attr('disabled', true)
        })

    </script>
@endpush
