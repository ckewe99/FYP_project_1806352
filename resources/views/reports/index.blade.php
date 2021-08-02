<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    @media print {
        .print-page-break table thead {
            /*page-break-before: auto;
             page-break-after: avoid; */
            page-break-inside: auto;
        }

        .print-page-break-h {
            page-break-inside: auto;
        }
    }

</style>
{{-- <button type="button" onclick="printJS('printJS-form', 'html')">
    Print Form
 </button> --}}
<div class="container" action="#" id="printJS-form">

    <div class="row">
        <div class="col-md-2 col-sm-3">
            <h6 class="mb-0">{{ $stall->name }}</h6>
        </div>
        <div class="col-md-6 col-sm-9">
            <h6>Date Range : {{ $date_range->start . ' until ' . $date_range->end }}</h6>
        </div>
    </div>

    @foreach ($days as $day_key1 => $day)
        @if (array_key_exists($day_key1, $item))
            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-0">{{ $day }}</h6>
                </div>
            </div>
        @endif
        <div class="row">
            @foreach ((array) $item as $day_key2 => $sessions)
                @if ($day_key1 == $day_key2)
                    @foreach ($sessions as $session => $foods)
                        <h6>{{ $session == 'S1' ? '第一下课' : '第二下课' }}</h6>
                        <br>
                        @foreach ($foods as $food => $classes)
                            <div class="col-md-4 col-sm-4">
                                <div
                                    class="table table-responsive-lg table-reponsive-sm table-responsive-md table-responsive-lg table-responsive print-page-break">
                                    <table class="table table-sm align-items-center">
                                        <thead>
                                            <tr class='text-center'>
                                                <th colspan="2">{{ $food }}</th>
                                            </tr>
                                            <tr class='text-center'>
                                                <th class="col">Class</th>
                                                <th class="col">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach ((array) $classes as $class)
                                                <tr class='text-center'>
                                                    <td class="col">{{ $class->class }}</td>
                                                    <td class="col">{{ $class->quantity }}</td>
                                                </tr>
                                                @php
                                                    $i += $class->quantity;
                                                @endphp
                                            @endforeach
                                            <tr class='text-center'>
                                                <td class="col" style="font-weight: bold;">Total</td>
                                                <td class="col" style="font-weight: bold;">{{ $i }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            @endforeach
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="table">
                <table class="table align-items-center">
                    <tbody class="print-page-break">
                        @foreach ($new_prices as $class => $price)
                            <tr class='text-center'>
                                <td class="col">{{ $class }}</td>
                                <td class="col"> MYR {{ $price->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>

{{-- <script src="/assets/js/print.min.js"></script>
 <link rel="stylesheet" type="text/css" href="/assets/css/print.min.css"> --}}


<script>
    window.print();

</script>
