@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <h3>{{ $date_range->start }} until {{ $date_range->end }}</h3>
                </div>
                @if ($date_range->active_date_range == 1 && Auth::user()->can_order == 1 && Auth::user()->ordered)

                    <div class="col-md col-sm text-right">
                        <a class="btn btn-outline-success btn-sm" data-toggle="modal"
                            data-target="#exampleModal">Comment</a>
                    </div>
                    {{-- modal --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Feedback Form</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('comment') }}">
                                        @csrf
                                        <input type="hidden" name="date_range_id" value="{{ $date_range->id }}">
                                        <textarea name="comment" class="form-control mb-3"
                                            placeholder="Please kindly leave your comment"></textarea>
                                        <input type="submit">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md col-sm text-right">
                        <a class="btn btn-outline-danger btn-icon m-1 btn-sm destroy"
                            href="{{ route('deleteOrder', $date_range->id) }}"
                            onClick="return confirm('Are you sure?')"><span class="ul-btn__icon"><i
                                    class="far fa-trash-alt"></i></span></a>
                    </div>
                @endif
            </div>
            @foreach ($days as $key => $day)
                <div class="row">
                    <div class="col-md">
                        <h5>{{ $day }}</h5>
                    </div>
                </div>
                @foreach ($sessions as $s_key => $session)
                    <div>
                        <h6>{{ $session }}</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="col-md-6">Food</th>
                                    <th class="col-md-2">Quantity</th>
                                    <th class="col-md">Price</th>
                                    @if ($date_range->active_date_range == 1 && Auth::user()->can_order == 1 && Auth::user()->ordered)
                                        <th class="col-md">Action</th>
                                    @endif
                                </tr>
                            </thead>

                            @foreach ($data as $food)
                                @if ($food->days == $key)
                                    @if ($food->session == $s_key)
                                        <tbody>
                                            <tr>
                                                <td>{{ $food->name }}</td>
                                                <td>{{ $food->quantity }}</td>
                                                <td>{{ $food->total_price }}</td>
                                                @if ($date_range->active_date_range == 1 && Auth::user()->can_order == 1 && Auth::user()->ordered)
                                                    <td>
                                                        <form action="{{ route('editOrder') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name='order_id'
                                                                value={{ $food->order_id }}>
                                                            <button type="submit"
                                                                class="btn btn-outline-info btn-icon m-1 btn-sm"><span
                                                                    class="ul-btn__icon"><i
                                                                        class="fas fa-pencil-alt"></i></span></button>
                                                        </form>
                                                        {{-- <a class="btn btn-outline-info btn-icon m-1 btn-sm"
                                                            href="{{ route('editOrder', $food->order_id) }}"><span
                                                                class="ul-btn__icon"><i
                                                                    class="fas fa-pencil-alt"></i></span>
                                                        </a> --}}
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    @endif
                                @endif
                            @endforeach
                        </table>
                    </div>
                @endforeach
            @endforeach
            {{-- haven't adjusted UI --}}
            @for ($i = 0; $i < count($tol_price); $i++)
                @if ($i == 0) <div class="mt-3 row">
            @else
                <div class="row"> @endif
                <div class="col-md-2 col-sm-1">
                    <h4 class="mb-0">{{ $tol_price[$i]->stall }}</h4>
                </div>
                <div class="col-md-2 col-sm-1">
                    <h4 class="mb-0">MYR {{ $tol_price[$i]->total_price }}</h4>
                </div>
                @if ($i + 1 == count($tol_price))
                    <div class="col text-right">
                        <h4>MYR {{ number_format($total_price, 2, '.', ',') }}</h4>
                    </div>
                @endif
        </div>
        @endfor
    </div>
    </div>

@endsection
