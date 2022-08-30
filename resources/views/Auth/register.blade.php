@extends('layout.adminpanel.dashboard')

@section('Headtitle')
    {{ __('Edit user') }}
@endsection
@section('css')
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
                    <h3>{{__('Register')}}</h3>
                </div>
                <div class="col col-md-6 text-right">
                    <img src="/assets/images/login/logo.png" width="35" height="35">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ url('register') }}">
                @csrf
                @error('error')
                <span class="error text-danger">{{$errors->first()}}</span>
                @enderror
                <!-- Name -->
                <div class="form-group">
                    <label for="name">{{ __('Name') }} </label>
                    <input id="name" type="text" class="form-control" value=""
                           placeholder="Name" name="name" required autofocus>
                </div>
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">{{ __('Email') }} </label>
                    <input id="email" type="email" class="form-control"
                           placeholder="Email" name="email" value=""
                           required>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label for="password">{{ __('Password') }} </label>
                    <input id="password" type="password" class="form-control"
                           placeholder="Password" name="password" required autocomplete="password">
                </div>
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }} </label>
                    <input id="password_confirmation" type="password" class="form-control"
                           placeholder="Confirm Password" name="password_confirmation" required>
                </div>
                <div class="form-group p-3">
                    <button type="submit" value="add" class="btn btn-lg">
                        {{ __('REGISTER') }}
                    </button>
                    {{--                    <p class="small fw-bold mt-2 pt-1 mb-0">{{ __('Already registered?') }}--}}
                    {{--                        <a href="{{ url('login') }}" class="link-danger">lOGIN</a>--}}
                    {{--                    </p>--}}
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')

@endsection

{{--<!DOCTYPE html>--}}
{{--@php--}}
{{--    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");--}}
{{--@endphp--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    --}}{{--    <title>Register</title>--}}
{{--    @section('Headtitle')--}}
{{--        Register--}}
{{--    @endsection--}}
{{--    @include('layout.head')--}}
{{--    <style>--}}
{{--        .left {--}}
{{--            height: 100vh;--}}
{{--            background-color: #244AD3;--}}
{{--            padding-top: 110px;--}}
{{--            padding-right: 10px;--}}
{{--            padding-left: 10px;--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        .right {--}}
{{--            /*background-color: #E9FBFF;*/--}}
{{--            height: 100vh;--}}
{{--            padding-top: 100px;--}}
{{--            padding-right: 10px;--}}
{{--            padding-left: 10px;--}}
{{--        }--}}

{{--        .l {--}}
{{--            position: absolute;--}}
{{--            top: 50%;--}}
{{--            left: 50%;--}}
{{--            transform: translate(-50%, -50%);--}}
{{--        }--}}

{{--        .btn {--}}
{{--            background: #244AD3;--}}
{{--            color: #FFFFFF;--}}
{{--            border: none;--}}
{{--        }--}}

{{--        .shadow {--}}
{{--            position: absolute;--}}
{{--            top: 50%;--}}
{{--            left: 50%;--}}
{{--            transform: translate(-50%, -50%);--}}
{{--            height: 550px;--}}
{{--            width: 350px;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body class="antialiased">--}}
{{--<div class="row px-2">--}}
{{--    <div class="left col-sm-12 col-md-7">--}}
{{--        <h1 style="color: #FFFFFF">Loan</h1>--}}
{{--        <img class="l" src="/assets/images/login/logo-icon.png">--}}
{{--    </div>--}}
{{--    <div class="right col-xs-12 col-sm-12 col-md-5 text-center">--}}
{{--        <div>--}}
{{--            <div class="shadow px-lg-3 py-lg-4">--}}
{{--                <form method="post" action="{{ url('register') }}">--}}
{{--                    @csrf--}}
{{--                    <br><img src="/assets/images/login/logo.png" width="50" height="50"><br><br>--}}
{{--                    <div style="color: #244AD3">--}}
{{--                        <h3>Register</h3><br>--}}
{{--                        <p class="d-flex">Please enter your Register details:</p>--}}
{{--                                                @error('error')--}}
{{--                                                <span class="error text-danger">{{$errors->first()}}</span>--}}
{{--                                                @enderror--}}
{{--                    </div>--}}
{{--                    <!-- Name -->--}}
{{--                    <div class="form-group">--}}
{{--                                                <label for="name">{{ __('Name') }} </label>--}}
{{--                        <input id="name" type="text" class="form-control" value=""--}}
{{--                               placeholder="Name" name="name" required autofocus>--}}
{{--                    </div>--}}
{{--                    <!-- Email Address -->--}}
{{--                    <div class="form-group">--}}
{{--                                                <label for="email">{{ __('Email') }} </label>--}}
{{--                        <input id="email" type="email" class="form-control"--}}
{{--                               placeholder="Email" name="email" value=""--}}
{{--                               required>--}}
{{--                    </div>--}}
{{--                    <!-- Password -->--}}
{{--                    <div class="form-group">--}}
{{--                                                <label for="password">{{ __('Password') }} </label>--}}
{{--                        <input id="password" type="password" class="form-control"--}}
{{--                               placeholder="Password" name="password" required autocomplete="password">--}}
{{--                    </div>--}}
{{--                    <!-- Confirm Password -->--}}
{{--                    <div class="form-group">--}}
{{--                                                <label for="password_confirmation">{{ __('Confirm Password') }} </label>--}}
{{--                        <input id="password_confirmation" type="password" class="form-control"--}}
{{--                               placeholder="Confirm Password" name="password_confirmation" required>--}}
{{--                    </div>--}}
{{--                    <div class="form-group p-3">--}}
{{--                        <button type="submit" value="add" class="btn btn-lg">--}}
{{--                            {{ __('REGISTER') }}--}}
{{--                        </button>--}}
{{--                                                <p class="small fw-bold mt-2 pt-1 mb-0">{{ __('Already registered?') }}--}}
{{--                                                    <a href="{{ url('login') }}" class="link-danger">lOGIN</a>--}}
{{--                                                </p>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

{{--<x-guest-layout>--}}
{{--    <x-auth-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <a href="/">--}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
{{--            </a>--}}
{{--        </x-slot>--}}

{{--        <!-- Validation Errors -->--}}
{{--        <x-auth-validation-errors class="mb-4" :errors="$errors" />--}}

{{--        <form method="POST" action="{{ route('register') }}">--}}
{{--            @csrf--}}

{{--            <!-- Name -->--}}
{{--            <div>--}}
{{--                <x-label for="name" :value="__('Name')" />--}}

{{--                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />--}}
{{--            </div>--}}

{{--            <!-- Email Address -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="email" :value="__('Email')" />--}}

{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password" :value="__('Password')" />--}}

{{--                <x-input id="password" class="block mt-1 w-full"--}}
{{--                                type="password"--}}
{{--                                name="password"--}}
{{--                                required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <!-- Confirm Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--                <x-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                                type="password"--}}
{{--                                name="password_confirmation" required />--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">--}}
{{--                    {{ __('Already registered?') }}--}}
{{--                </a>--}}

{{--                <x-button class="ml-4">--}}
{{--                    {{ __('Register') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-auth-card>--}}
{{--</x-guest-layout>--}}
