<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    @media print {
        .print-page-break {
            /*page-break-before: auto;
             page-break-after: avoid; */
            page-break-inside: auto;
        }

    }

</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-3">
            <h6 class="mb-0">{{ $class->name }}</h6>
        </div>
        <div class="col-md- col-sm-3">
            <h6 class="mb-0">Date Range
                :{{ $date_range->start . ' until ' . $date_range->end }}</h6>
        </div>
    </div>
    @foreach ($days as $key1 => $day)
        <div class="row mt-3">
            @if (array_key_exists($key1, $data))
                <div class="col-md-3 col-sm-3">
                    <h6>{{ $day }}</h6>
                </div>
            @endif
            @foreach ($data as $key2 => $sessions)
                @if ($key1 == $key2)
                    @foreach ($sessions as $session => $stalls)
                        <h6>{{ $session == '1' ? '第一下课' : '第二下课' }}</h6>
                        <br>
                        @foreach ($stalls as $stall => $foods)
                            <div class="col-md-4 col-sm-4">
                                <div class="table">
                                    <table class="table align-items-center">
                                        <thead class="print-page-break">
                                            <tr class='text-center'>
                                                <th colspan="2">{{ $stall }}</th>
                                            </tr>
                                            <tr class='text-center'>
                                                <th class="col">Food</th>
                                                <th class="col">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody class="print-page-break">
                                            @foreach ((array) $foods as $food)
                                                <tr class='text-center'>
                                                    <td class="col">{{ $food->name }}</td>
                                                    <td class="col">{{ $food->quantity }}</td>
                                                </tr>
                                            @endforeach
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>

<script>
    window.print();

</script>
