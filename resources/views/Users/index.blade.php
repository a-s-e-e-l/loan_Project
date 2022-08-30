@extends('layout.adminpanel.dashboard')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('Headtitle')
    {{ __('dashboard.Users') }}
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
    {{ __('dashboard.Users') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6 text-left">
                    <h4>{{ __('dashboard.Users') }}</h4>
                </div>
                <div class="col col-md-6 text-right">
                    <a class="btn btn-secondary" href="{{route('user.create')}}">{{ __('dashboard.adduser') }}</a>
                </div>

            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Edit/Delete</th>
                </tr>
                </thead>
                <tbody>
                @if(!count($users)<1)
                    @foreach ($users as $user )
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                <a href="{{route('user.show',$user->id)}}">{{ $user->first_name }} {{ $user->last_name }}</a>
                            </td>
                            <td>
                                <a href="{{route('user.edit',$user->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>
                                <a href="{{route('user.destroy',$user->id)}}"
                                   class="btn btn-danger">{{ __('Delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="9" class="text-center">{{ __('dashboard.nouser') }}</th>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        {{--        <div class="row">--}}
        {{--            <div class="pl-lg-4">--}}
        {{--                {{ $users->links() }}--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
@endsection
@section('js')

@endsection
