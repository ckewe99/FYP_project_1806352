@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h3>Order History</h3>
                </div>
            </div>
            <form method="post" action="{{ route('viewOrder') }}">
                @csrf
                <div class="row mb-2">
                    <label class="col-md-3 col-form-label">{{ __('Date range') }}</label>
                    <div class="col-md-8 form-group">
                        <select class="browser-default custom-select" type='text' name='date_range'>
                            @foreach ($date_range as $item)
                                <option value="{{ $item->id }}"
                                    {{ $is_active == 1 ? ($item->active_date_range == 1 ? 'selected' : '') : '' }}>
                                    {{ $item->start . ' until ' . $item->end }}
                                </option>
                            @endforeach
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

