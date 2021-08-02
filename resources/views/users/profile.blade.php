@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">Profile</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Type</th>
                                    <td>{{ $user->type === 1 ? 'Admin' : 'User' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Student / Teacher ID</th>
                                    <td>{{ $user->student_physical_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Class</th>
                                    <td>{{ $class->name }}</td>
                                </tr>
                                <tr>
                                    <div class="text-right">
                                        <a href="{{ route('change-pwd-view') }}"
                                            class="btn btn-primary btn-sm mt-3 mr-4 mb-2"><span>Change
                                                Password</span></a>
                                    </div>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
