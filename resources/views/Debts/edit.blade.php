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
    <form method="post" action="{{route('debt.update',$debt->id)}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Creditor Phone</label>
            <input type="text" class="form-control"
                   placeholder="Creditor Phone" name="creditor_phone" value="{{$debt->creditor_phone}}" required>
        </div>
        <div class="form-group">
            <label>Debitor Phone</label>
            <input type="text" class="form-control"
                   placeholder="Debitor Phone" name="debitor_phone" value="{{$debt->debitor_phone}}" required>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control"
                   placeholder="Amount" name="amount_debt" value="{{$debt->amount_debt}}" required>
        </div>
        <div class="form-group">
            <label>Note</label>
            <input type="text" class="form-control"
                   placeholder="Note" name="note" value="{{ $debt->note }}" required>
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
