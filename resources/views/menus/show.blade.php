@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">第一下课</h3>
                            </div>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('menus_index', $date_range_id) }}"
                                class="mt-4 mr-3 btn btn-sm btn-danger">Back</a>
                            <a href="{{ route('menu.create', ['days' => $days, 'session' => 1, 'date_range_id' => $date_range_id]) }}"
                                class="mt-4 mr-3 btn btn-sm btn-success">Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stall</th>
                                    {{-- <th scope="col">Dessert</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">第二下课</h3>
                            </div>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('menu.create', ['days' => $days, 'session' => 2, 'date_range_id' => $date_range_id]) }}"
                                class="mt-4 mr-3 btn btn-sm btn-success">Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatableTwo">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stall</th>
                                    {{-- <th scope="col">Dessert</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var oTable = $('.yajra-datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('sessionOneList', [$days, $date_range_id]) }}"
            },
            order: [
                [0, 'asc']
            ],
            columns: [{
                    data: "id",
                    "width": "10%",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                {
                    data: "name"
                },
                {
                    data: "price"
                },
                {
                    data: "stall",
                },
                // {
                //     data: "dessert",
                //     name: "dessert"
                // },
                {
                    data: "action",

                },

            ]
        });



        var bTable = $('.yajra-datatableTwo').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('sessionTwoList', [$days, $date_range_id]) }}"
            },
            order: [
                [0, 'asc']
            ],
            columns: [{
                    data: "id",
                    "width": "10%",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false
                },
                {
                    data: "name"
                },
                {
                    data: "price"
                },
                {
                    data: "stall",
                },
                // {
                //     data: "dessert",
                //     name: "dessert"
                // },
                {
                    data: "action",

                },

            ]
        });


        $('body').on('click', '.destroy', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            console.log(id)
            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    url: '/menu/' + id,
                    method: 'POST',
                    data: {
                        _method: 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire(
                            'Deleted!',
                            'You Have Successful!',
                            'success'
                        )
                        $('.yajra-datatable').dataTable().fnDraw(false);
                        $('.yajra-datatableTwo').dataTable().fnDraw(false);
                    }
                });
            }
        });

    </script>

@endpush
