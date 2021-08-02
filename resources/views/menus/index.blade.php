@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">Menu List</h3>
                            </div>
                        </div>
                        <div class="col mr-5 text-right">
                            <div class="card-header border-0">
                                <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal">Import
                                    Menu</a>
                                {{-- modal --}}
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Please import documents</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data"
                                                    action="{{ route('import-food') }}">
                                                    @csrf
                                                    <input type="hidden" name="date_range_id"
                                                        value="{{ $date_range->id }}">
                                                    <label for="import_food">Select a file</label>
                                                    <input type="file" id="import_food" name="import_food" required>
                                                    <input type="submit">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush yajra-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th scope="col">Days</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($days as $keys => $day)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            @if ($date_range->holidays[$i] == null)
                                                <td>
                                                    {{ $day }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-info btn-icon m-1 btn-sm"
                                                        href="{{ route('menu.show', [$keys, 'date_range_id' => $date_range->id]) }}"><span
                                                            class="ul-btn__icon"><i
                                                                class="fas fa-pencil-alt"></i></span></a>
                                                </td>
                                            @else
                                                <td>
                                                    {{ $day }} ({{ $date_range->holidays[$i] }})
                                                </td>
                                                <td>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach

                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')


@endpush
