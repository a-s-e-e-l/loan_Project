<!DOCTYPE html>
{{--@php--}}
{{--    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");--}}
{{--@endphp--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    @section('Headtitle')
        {{ __('Login') }}
    @endsection
    @include('layout.head')
    <style>
        .left {
            height: 100vh;
            background-color: #244AD3;
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

        .l {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .btn {
            background: #244AD3;
            color: #FFFFFF;
            border: none;
        }

        .shadow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: 550px;
            width: 350px;
        }
    </style>
</head>
<body class="antialiased">
<div class="row px-2">
    <div class="left col-sm-12 col-md-7">
        <h1 style="color: #FFFFFF">Loan</h1>
        <img class="l" src="/assets/images/login/logo-icon.png">
    </div>
    <div class="right col-xs-12 col-sm-12 col-md-5 text-center">
        <div>
            <div class="shadow px-lg-3 py-lg-5">
                <form method="post" action="{{ url('login') }}">
                    @csrf
                    <br><img src="/assets/images/login/logo.png" width="50" height="50"><br><br>
                    <div style="color: #244AD3">
                        <h3>Login</h3><br>
                        <p class="d-flex">Please enter your login details:</p>
                    </div>
                    <div class="form-group">
                        {{--                        <label for="email" :value="__('Email')"/>--}}
                        <input type="email" class="form-control"
                               placeholder="Email" name="email" value=""
                               required>
                        @error('email')
                        <span class="error text-danger">{{$errors->first()}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{--                        <label for="password" :value="__('Password')"/>--}}
                        <input id="password" type="password" class="form-control"
                               placeholder="Password" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="error text-danger">{{$errors->first()}}</span>
                        @enderror
                    </div>
{{--                    <div class="form-group">--}}
                    {{--                        <a class="underline d-flex flex-row-reverse small"--}}
                    {{--                           href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>--}}
                    {{--                    </div>--}}
                    <div class="form-group p-3">
                        <button type="submit" value="add" class="btn btn-lg">
                            {{ __('LOGIN') }}
                        </button>
{{--                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account?--}}
{{--                            <a href="{{ url('register') }}" class="link-danger">Register</a>--}}
{{--                        </p>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
