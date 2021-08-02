<script src="/assets/js/bootstrap-notify.js"></script>
@if(Session::has('alert-success'))
    <script>
        $.notify({
            icon: "alert",
            message: "{{Session::get('alert-success')}}"

        }, {
            type: 'success',
            timer: 3000,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
    </script>
@endif

@if(Session::has('alert-danger'))
    <script>
        $.notify({
            icon: "report_problem",
            message: "{{Session::get('alert-danger')}}"

        }, {
            type: 'danger',
            timer: 3000,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
    </script>
@endif