@extends('layout.adminpanel.dashboard')
@section('Headtitle')
    {{ __('Create Transaction') }}
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
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6 text-left">
                    <h3>Create Transaction</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('transaction.store')}}">
                @csrf
                <div class="form-group">
                    <label>Payer Phone</label>
                    <input type="text" class="form-control"
                           placeholder="Payer Phone" name="payer_phone" value="" required>
                </div>
                <div class="form-group">
                    <label>Recipient Phone</label>
                    <input type="text" class="form-control"
                           placeholder="Recipient Phone" name="recipient_phone" value=""
                           required>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" class="form-control"
                           placeholder="Amount" name="amount" value="" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" class="form-control"
                           placeholder="Email" name="type" value="" required>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="datetime-local" class="form-control"
                           placeholder="Deadline" name="deadline" value="" required>
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <input type="text" class="form-control"
                           placeholder="Note" name="note" value="" required>
                </div>
                <div class="text-center">
                    <a href="{{route('transactions')}}" class="btn btn-secondary">{{ __('Back') }}</a>
                    <button type="submit" value="add" class="btn btn-primary">
                        {{ __('Add') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')

@endsection
