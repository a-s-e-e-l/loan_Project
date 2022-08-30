@extends('layout.adminpanel.dashboard')

@section('Headtitle')
    {{ __('Transaction') }}
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
    {{ __('dashboard.Transaction') }}
@endsection
@section('content')
    <form>
        <div class="form-group">
            <label>Payer Phone</label>
            <input type="text" class="form-control"
                   placeholder="Payer Phone" name="payer_phone" value="{{$transaction->payer_phone}}" disabled>
        </div>
        <div class="form-group">
            <label>Recipient Phone</label>
            <input type="text" class="form-control"
                   placeholder="Recipient Phone" name="recipient_phone" value="{{$transaction->recipient_phone}}"
                   disabled>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control"
                   placeholder="Amount" name="amount" value="{{$transaction->amount}}" disabled>
        </div>
        <div class="form-group">
            <label>Type</label>
            <input type="text" class="form-control"
                   placeholder="Email" name="type" value="{{$transaction->type}}" disabled>
        </div>
        <div class="form-group">
            <label>Deadline</label>
            <input type="datetime-local" class="form-control"
                   placeholder="Deadline" name="deadline" value="{{$transaction->deadline}}" disabled>
        </div>
        <div class="form-group">
            <label>Note</label>
            <input type="text" class="form-control"
                   placeholder="Note" name="note" value="{{$transaction->note}}" disabled>
        </div>
        <div class="text-center">
            <a href="{{route('transactions')}}" class="btn btn-secondary">{{ __('Back') }}</a>
            <a href="{{route('transaction.edit',$transaction->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>
            <a href="{{route('transaction.destroy',$transaction->id)}}" class="btn btn-danger">{{ __('Delete') }}</a>
        </div>
    </form>
@endsection
@section('js')

@endsection
