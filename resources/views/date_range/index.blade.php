@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">Date Range List</h3>
                            </div>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('date_range.create') }}" class="mt-4 mr-3 btn btn-sm btn-success">Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
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
                url: "/date-range-list"
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
                    data: "start"
                },
                {
                    data: "end"
                },
                {
                    data: "action",

                },

            ]
        });


        $('body').on('click', '.destroy', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    url: '/date-range-delete/' + id,
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
                    }
                });

            }
        });

    </script>

@endpush
