@extends('layout.adminpanel.dashboard')

@section('Headtitle')
    {{ __('Edit user') }}
@endsection
@section('css')
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
@endsection
@section('title')
    {{ __('dashboard.Home') }}
@endsection
@section('title-side')
    {{ __('dashboard.Users') }}
@endsection
@section('content')
    <form method="post" action="{{route('user.update',$user->id)}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <br><img alt="image" src="http://127.0.0.1:8000/{{$user->image}}" width="90"
                     height="90"><br><br>
            {{--            <h6>Upload a different photo...</h6>--}}
            <input type="file" class="form-control " name="image">
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" class="form-control"
                   placeholder="Phone" name="phone_number" value="{{$user->phone_number}}" required>
        </div>
        <div class="form-row form-group">
            <div class="col">
                <label>First Name</label>
                <input type="text" class="form-control"
                       placeholder="First Name" name="first_name" value="{{ $user->first_name }}" required>
            </div>
            <div class="col">
                <label>Last Name</label>
                <input type="text" class="form-control"
                       placeholder="Last Name" name="last_name" value="{{ $user->last_name }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control"
                   placeholder="Email" name="email" value="{{$user->email}}" required>
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="datetime-local" class="form-control"
                   placeholder="Date of Birth" name="date_of_birth" value="{{$user->date_of_birth}}" required>
        </div>
        <div class="form-row form-group">
            <div class="col">
                <label>Address Line 1</label>
                <input type="text" class="form-control"
                       placeholder="Address Line 1" name="address_line1" value="{{ $user->address_line1 }}" required>
            </div>
            <div class="col">
                <label>Address Line 2</label>
                <input type="text" class="form-control"
                       placeholder="Address Line 2" name="address_line2" value="{{ $user->address_line2 }}" required>
            </div>
            <div class="col">
                <label>Address</label>
                <input type="text" class="form-control"
                       placeholder="Address" name="address" value="{{ $user->address }}" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" value="add" class="btn btn-primary">
                {{ __('Edit') }}
            </button>
        </div>
    </form>
@endsection
@section('js')

@endsection
