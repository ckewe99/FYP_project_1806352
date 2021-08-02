@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h3>Confirm your order</h3>
                </div>
            </div>
            <form action="{{ route('order.store') }}" method="post">
                @php
                    $total = 0;
                @endphp

                @csrf
                @foreach ($days as $days_key => $days_value)
                    @if (array_key_exists($days_key, $new_array))
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h1 style="color:darkblue">{{ $days_value }}</h1>
                            </div>
                        </div>
                    @endif

                    @foreach ($new_array as $day_key2 => $sessions)
                        @if ($day_key2 == $days_key)
                            @foreach ($sessions as $s_key => $foods)
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <h3 style="color:rgb(255, 136, 0)">
                                            {{ $s_key == 1 ? '第一下课 First Rest' : '第二下课 Second Rest' }}</h3>
                                    </div>
                                </div>
                                @foreach ($foods as $food)
                                    @php
                                        $total += $food->price;
                                    @endphp
                                    {{-- <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            @if ($food->stall_id == 1 && !$food->dessert)
                                                <h3>主食 Main Dish (荤 NON-VEGE)</h3>
                                            @elseif($food->stall_id == 2 && !$food->dessert)
                                                <h3>主食 Main Dish (素 VEGE)</h3>
                                            @elseif($food->stall_id == 3 && !$food->dessert)
                                                <h3>饮料 Beverage</h3>
                                            @elseif($food->dessert)
                                                <h3>副食 Side Dish</h3>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 align-self-center mb-3">
                                            <input value="{{ $food->id }}" name="food[]" hidden>
                                            <h3>{{ $food->name }}</h3>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <select class="custom-select" id="qty{{ $food->id }}" name="quantity[]"
                                                style="height:40px;" onchange="totalAmount({{ $food->id }})">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <div class="text-right ml-5">
                                                <h2>MYR</h2>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <div class="form-group text-right mr-3">
                                                <input type="text" value="{{ $food->price }}" class="form-control"
                                                    id="unit{{ $food->id }}" hidden />
                                                <h2 id='price{{ $food->id }}'>
                                                    {{ number_format($food->price, 2, '.', ',') }}</h2>

                                            </div>
                                        </div>
                                        <div class="col col-md-2 col-sm-2">

                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                @endforeach

                <div class="container my-5">
                    <div class="row">
                        <div class="col col-md-3"></div>
                        <div class="col col-md-3"></div>
                        <div class="col col-md-2 col-sm-2">
                            <div class="text-right ml-3">
                                <h2>Subtotal : MYR</h2>
                            </div>
                        </div>
                        <div class="col col-md-2 col-sm-2">
                            <div class="text-right">
                                <h2 id="total">{{ number_format($total, 2, '.', ',') }}</h2>
                            </div>
                        </div>
                        <div class="col col-md-2 col-sm-2">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-danger" href="javascript:history.back()">Back</a>
                        </div>
                        <div class="col">
                        </div>
                        <div class="col text-right mr-5">
                            <input type="submit" class="btn btn-primary" value="Confirm">
                        </div>
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

        function totalAmount(id) {
            total = parseFloat($('#total').text());
            price = parseFloat($('#price' + id).text());
            total = total - price;
            qty = $('#qty' + id).val();
            unit_price = $('#unit' + id).val();
            price = qty * unit_price;
            total = total + price;
            $('#price' + id).text(price.toFixed(2));
            $('#total').text(total.toFixed(2));
        }

    </script>
@endpush
