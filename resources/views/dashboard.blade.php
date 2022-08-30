@extends('layout.adminpanel.dashboard')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('Headtitle')
    {{ __('dashboard.Home') }}
@endsection
@section('css')
    .left {
    height: 100vh;
    padding-top: 110px;
    padding-right: 10px;
    padding-left: 10px;
    text-align: center;
    }

    .right {
    /*background-color: #E9FBFF;*/
    height: 100vh;
    padding-top: 100px;
    padding-right: 10px;
    padding-left: 10px;
    }
@endsection
@section('title')
    {{ __('dashboard.Home') }}
@endsection
@section('title-side')
    {{ __('dashboard.Dashboard') }}
@endsection
@section('content')
    {{--    <div class="card">--}}
    {{--        <table class="table table-striped">--}}
    {{--            <thead>--}}
    {{--            <tr>--}}
    {{--                <th scope="col">#Id</th>--}}
    {{--                <th scope="col">Phone Number</th>--}}
    {{--                <th scope="col">Name</th>--}}
    {{--            </tr>--}}
    {{--            </thead>--}}
    {{--            <tbody>--}}
    {{--            @foreach($data as $user)--}}
    {{--                <tr>--}}
    {{--                    <th scope="row">{{ $user->id }}</th>--}}
    {{--                    <td>{{ $user->phone_number }}</td>--}}
    {{--                    <td>{{ $user->name }}</td>--}}
    {{--                </tr>--}}
    {{--            @endforeach--}}

    {{--            <tr>--}}
    {{--                <th scope="row">2</th>--}}
    {{--                <td>Jacob</td>--}}
    {{--                <td>Thornton</td>--}}
    {{--                <td>@fat</td>--}}
    {{--            </tr>--}}
    {{--            <tr>--}}
    {{--                <th scope="row">3</th>--}}
    {{--                <td>Larry</td>--}}
    {{--                <td>the Bird</td>--}}
    {{--                <td>@twitter</td>--}}
    {{--            </tr>--}}
    {{--            </tbody>--}}
    {{--        </table>--}}
    <h3>{{ auth()->user()->name }} {{ __('dashboard.login') }}</h3>
    {{--    </div>--}}
    {{--    <h3>{{ auth()->user()->name }} {{ __('dashboard.login') }}</h3>--}}
    {{--    @foreach ($data as $item )--}}
    {{--    <h1>{{$data->name}}</h1>--}}
    {{--    @endforeach--}}
@endsection
@section('js')

@endsection

