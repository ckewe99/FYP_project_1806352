@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <div class="main-content" id="panel">

        <!-- Page content -->
        <div class="container mx-5 my-5">
            <div class="row">
                <div class="col-md-6 text-left">
                    @if (Auth::user()->type == 2)
                        @if ($stall->id == 1)
                            <a href="{{ route('report.hawker.index', 1) }}" class="mt-4 btn btn-sm btn-primary">荤食档口</a>
                        @elseif($stall->id == 2)
                            <a href="{{ route('report.hawker.index', 2) }}" class="mt-4 btn btn-sm btn-primary">素食档口</a>
                        @elseif($stall->id == 3)
                            <a href="{{ route('report.hawker.index', 3) }}" class="mt-4 btn btn-sm btn-primary">饮料档口</a>
                        @endif
                    @elseif(Auth::user()->type == 1)
                        <a href="{{ route('report.hawker.index', 1) }}" class="mt-4 btn btn-sm btn-primary">荤食档口</a>
                        <a href="{{ route('report.hawker.index', 2) }}" class="mt-4 btn btn-sm btn-primary">素食档口</a>
                        <a href="{{ route('report.hawker.index', 3) }}" class="mt-4 btn btn-sm btn-primary">饮料档口</a>
                    @endif
                </div>
            </div>
            @if (Auth::user()->type == 2 || Auth::user()->type == 1)
                <div class="mt-3 row">
                    <form action="{{ route('check-amount') }}" method="POST">
                        @csrf
                        <div class="ml-3 mb-2 input-group mb-1">
                            <input type="text" class="form-control" placeholder="Student ID / Staff ID"
                                aria-describedby="button-addon2" name="id" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2"><span
                                        class="ul-btn__icon"><i class="fas fa-search"></i></span></button>
                            </div>
                        </div>
                        @if (Auth::user()->type == 1)
                            <div class="ml-3 input-group mb-3">
                                <select class="browser-default custom-select" name='stall_id'>
                                    @foreach ($stalls as $s)
                                        <option value="{{ $s->id }}">
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="ml-3 input-group mb-3">
                            <select class="browser-default custom-select" name='date_range'>
                                @foreach ($date_range as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->start . ' until ' . $item->end }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                @if ($result ?? '' != null)
                    <div class="mt-3 row">
                        <h5> Your search result is :</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach ($result ?? '' as $user)
                                    <tr>
                                        <th>Name:</th>
                                        <td><a class="btn btn-sm btn-outline-info" data-toggle="modal"
                                                data-target="#exampleModal">{{ $user->name }}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount: </th>
                                        <td>{{ $user->total_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Modal --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ordered items</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr class="mt-2">
                                                    <td>{{ $item->name }} X {{ $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

@endsection
