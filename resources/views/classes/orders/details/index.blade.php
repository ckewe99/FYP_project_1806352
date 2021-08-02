<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-3">
            <h6 class="mb-0">{{ $class->name }}</h6>
        </div>
        <div class="col-md-8 col-sm-9">
            <h6 class="mb-0">Date Range
                :{{ $date_range->start . ' until ' . $date_range->end }}</h6>
        </div>
    </div>
    <div class="table table-light">
        <table class="table align-items-center text-center">
            <thead>
                <tr>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Price</th>
                    <th rowspan="2">Signature</th>
                    @foreach ($days as $day)
                        <th colspan="2">{{ $day }}</th>
                    @endforeach
                </tr>
                <tr>
                    @for ($i = 0; $i < 5; $i++)
                        @foreach ($sessions as $session) <th>{{ $session }}</th> @endforeach
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        {{-- user name --}}
                        <td>{{ $user->name }}</td>
                        {{-- price --}}
                        @if (array_key_exists($user->id, $new_prices))
                            @foreach ($new_prices as $p_key => $price)
                                @if ($price->user_id == $user->id)
                                    <td>MYR {{ number_format($price->total_price, 2) }}</td>
                                @endif
                            @endforeach

                            {{-- signature --}}
                            <td></td>

                            {{-- SUN order --}}
                            @php
                                $flag = true;
                            @endphp
                            @foreach ($SUN_orders as $u_key => $foods)
                                @if ($u_key == $user->id)
                                    @foreach ($foods as $item)
                                        @if (array_key_exists('1', $foods) && array_key_exists('2', $foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @elseif(array_key_exists('1', $foods) && !array_key_exists('2',$foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>N/A</td>
                                        @elseif(!array_key_exists('1', $foods) && array_key_exists('2',$foods))
                                            <td>N/A</td>
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @endif

                                    @endforeach
                                    @php
                                        $flag = false;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($flag)
                                <td>N/A</td>
                                <td>N/A</td>
                            @endif

                            {{-- MON order --}}
                            {{-- @if (empty($MON_orders))
                                <td>MON N/A1</td>
                                <td>MON N/A1</td>
                            @endif --}}
                            @php
                                $flag = true;
                            @endphp
                            @foreach ($MON_orders as $u_key => $foods)
                                @if ($u_key == $user->id)
                                    @foreach ($foods as $item)
                                        @if (array_key_exists('1', $foods) && array_key_exists('2', $foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @elseif(array_key_exists('1', $foods) && !array_key_exists('2',$foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>N/A</td>
                                        @elseif(!array_key_exists('1', $foods) && array_key_exists('2',$foods))
                                            <td>N/A</td>
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @endif
                                    @endforeach

                                    @php
                                        $flag = false;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($flag)
                                <td>N/A</td>
                                <td>N/A</td>
                            @endif



                            {{-- TUE order --}}
                            {{-- @if (empty($TUE_orders))
                                <td>TUE N/A1</td>
                                <td>TUE N/A1</td>
                            @endif --}}
                            @php
                                $flag = true;
                            @endphp
                            @foreach ($TUE_orders as $u_key => $foods)
                                @if ($u_key == $user->id)
                                    @foreach ($foods as $item)
                                        @if (array_key_exists('1', $foods) && array_key_exists('2', $foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @elseif(array_key_exists('1', $foods) && !array_key_exists('2',$foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>N/A</td>
                                        @elseif(!array_key_exists('1', $foods) && array_key_exists('2',$foods))
                                            <td>N/A</td>
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @endif
                                    @endforeach
                                    @php
                                        $flag = false;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($flag)
                                <td>N/A</td>
                                <td>N/A</td>
                            @endif

                            {{-- WED order --}}
                            {{-- @if (empty($WED_orders))
                                <td>WED N/A1</td>
                                <td>WED N/A1</td>
                            @endif --}}
                            @php
                                $flag = true;
                            @endphp
                            @foreach ($WED_orders as $u_key => $foods)
                                @if ($u_key == $user->id)
                                    @foreach ($foods as $item)
                                        @if (array_key_exists('1', $foods) && array_key_exists('2', $foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @elseif(array_key_exists('1', $foods) && !array_key_exists('2',$foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>N/A</td>
                                        @elseif(!array_key_exists('1', $foods) && array_key_exists('2',$foods))
                                            <td>N/A</td>
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @endif
                                    @endforeach
                                    @php
                                        $flag = false;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($flag)
                                <td>N/A</td>
                                <td>N/A</td>
                            @endif

                            {{-- THU order --}}
                            {{-- @if (empty($THU_orders))
                                <td>THU N/A1</td>
                                <td>THU N/A1</td>
                            @endif --}}
                            @php
                                $flag = true;
                            @endphp
                            @foreach ($THU_orders as $u_key => $foods)
                                @if ($u_key == $user->id)
                                    @foreach ($foods as $item)
                                        @if (array_key_exists('1', $foods) && array_key_exists('2', $foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @elseif(array_key_exists('1', $foods) && !array_key_exists('2',$foods))
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>N/A</td>
                                        @elseif(!array_key_exists('1', $foods) && array_key_exists('2',$foods))
                                            <td>N/A</td>
                                            <td>
                                                @foreach ($item as $items)
                                                    {{ $items->name }} x {{ $items->quantity }}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @endif
                                    @endforeach
                                    @php
                                        $flag = false;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($flag)
                                <td>N/A</td>
                                <td>N/A</td>
                            @endif

                        @else
                            <td>MYR 0</td>
                            <td></td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach ($tol_price as $stall)
        <div class="row">
            <div class="col-md-2 col-sm-1">
                <h6 class="mb-0">{{ $stall->stall }}</h6>
            </div>
            <div class="col-md-2 col-sm-1">
                <h6 class="mb-0">MYR {{ $stall->total_price }}</h6>
            </div>
        </div>
    @endforeach
</div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>

<script>
    window.print();

</script>
