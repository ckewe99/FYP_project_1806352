@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h3>Order History</h3>
                </div>
            </div>
            <form method="get" action="{{ route('editOrder2', $order->id) }}">
                @csrf
                <div class="row mb-2">
                    <div class="col-md-4">
                        <h4>{{ $food_info->name }}</h4>
                    </div>
                    <div class="col-md-4">
                        <select class="custom-select" id="inputGroupSelect01" name="quantity" style="height:40px;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-fill bg-gradient-red text-white">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $('form').submit(function() {
            $('[type="submit"]').attr('disabled', true)
        })

    </script>
@endpush
