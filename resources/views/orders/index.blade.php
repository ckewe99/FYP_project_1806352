@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="container">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row my-5">
                <div class="col-md-12 col-sm-12">
                    <h3 class="mb-0">Order Weekly Meals From {{ $date_range->start }} until
                        {{ $date_range->end }}
                    </h3>
                </div>
            </div>
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                @php
                    $i = 0;
                @endphp
                @foreach ($days as $key => $value)
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            @if ($date_range->holidays[$i] == null)
                                <h1 style="color:darkblue">{{ $value }}</h1>
                            @else
                                <h1 style="color:red">{{ $value }} ({{ $date_range->holidays[$i] }})</h1>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h2 style="color:rgb(255, 136, 0)">第一下课 First Rest</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>主食 Main Dish (荤 NON-VEGE) <h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select" type='text'
                                name='{{ $key }}_s1_main_non_vege' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s1_main_non_vege[0] as $key2 => $session1_mains)
                                        @if ($key == $key2)
                                            @foreach ($session1_mains as $item)
                                                <option value='{{ $item->id }}'>
                                                    {{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>主食 Main Dish (素 VEGE) <h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select" type='text'
                                name='{{ $key }}_s1_main_vege' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s1_main_vege[0] as $key2 => $session1_mains)
                                        @if ($key == $key2)
                                            @foreach ($session1_mains as $item)
                                                <option value='{{ $item->id }}'>
                                                    {{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>饮料 Beverage<h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select" type='text'
                                name='{{ $key }}_s1_main_bev' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s1_main_bev[0] as $key2 => $session1_mains)
                                        @if ($key == $key2)
                                            @foreach ($session1_mains as $item)
                                                <option value='{{ $item->id }}'>
                                                    {{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>副食 Side Dish</h3>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select side-1" type='text'
                                name='{{ $key }}_s1_side' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s1_side[0] as $key2 => $session1_sides)
                                        @if ($key == $key2)
                                            @foreach ($session1_sides as $item)
                                                <option value='{{ $item->id }}'>{{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h2 style="color:rgb(255, 136, 0)">第二下课 Second Rest</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            <h3>主食 Main Dish (荤 NON-VEGE) </h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select main-2" type='text'
                                name='{{ $key }}_s2_main_non_vege' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s2_main_non_vege[0] as $key2 => $session2_mains)
                                        @if ($key == $key2)
                                            @foreach ($session2_mains as $item)
                                                <option value='{{ $item->id }}'>{{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            <h3>主食 Main Dish (素 VEGE) </h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select main-2" type='text'
                                name='{{ $key }}_s2_main_vege' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s2_main_vege[0] as $key2 => $session2_mains)
                                        @if ($key == $key2)
                                            @foreach ($session2_mains as $item)
                                                <option value='{{ $item->id }}'>{{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            <h3>饮料 Beverage</h3>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select main-2" type='text'
                                name='{{ $key }}_s2_main_bev' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s2_main_bev[0] as $key2 => $session2_mains)
                                        @if ($key == $key2)
                                            @foreach ($session2_mains as $item)
                                                <option value='{{ $item->id }}'>{{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h3>副食 Side Dish</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <select class="browser-default custom-select side-2" type='text'
                                name='{{ $key }}_s2_side' style="width:350px">
                                <option value=''>Don't purchase</option>
                                @if ($date_range->holidays[$i] == null)
                                    @foreach ($s2_side[0] as $key2 => $session2_sides)
                                        @if ($key == $key2)
                                            @foreach ($session2_sides as $item)
                                                <option value='{{ $item->id }}'>{{ $item->name }} (MYR
                                                    {{ $item->price }})
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <hr>
                    @php
                        $i++;
                    @endphp
                @endforeach

                <div class="row my-5">
                    <div class="col-md-12 col-sm-12">
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>



@endsection
@push('js')

@endpush
