@extends('layouts.app')
@section('content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-header border-0">
                                <h3 class="mb-0">{{ $class->name }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Student / Teacher ID</th>
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
                url: "{{ route('class.name-list-list', $class->id) }}"
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
                    data: "email"
                },
                {
                    data: "type",
                    render: function(data, type, row, meta) {
                        switch (data) {
                            case 1:
                                return "Admin";
                                break;
                            case 2:
                                return "Kitchen";
                                break;
                            case 3:
                                return "Teacher";
                                break;
                            case 4:
                                return "Student";
                                break;

                        }
                    }
                },
                {
                    data: "student_physical_id"
                },
            ]
        });

    </script>

@endpush
