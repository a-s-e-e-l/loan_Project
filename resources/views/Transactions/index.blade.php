@extends('layout.adminpanel.dashboard')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('Headtitle')
    {{ __('dashboard.Transactions') }}
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
    {{ __('dashboard.Transactions') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6 text-left">
                    <h4>{{ __('dashboard.Transactions') }}</h4>
                    {{--                                (<a href="{{ url('transactions','debt') }}">Debt</a> OR <a--}}
                    {{--                                    href="{{ url('transactions','payment') }}">Payment</a>)--}}
                </div>
                <div class="col col-md-6 text-right">
                    <a class="btn btn-secondary"
                       href="{{route('transaction.create')}}">{{ __('dashboard.addtransaction') }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Payer Phone</th>
                    <th scope="col">Recipient Phone</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Type</th>
                    <th scope="col">Note</th>
                    <th scope="col">Edit/Delete</th>
                </tr>
                </thead>
                <tbody>
                @if(!count($transactions)<1)
                    @foreach($transactions as $transaction)
                        <tr>
                            <th scope="row"><a
                                    href="{{route('transaction.show',$transaction->id)}}">{{$transaction->id}}</a>
                            </th>
                            <td>{{$transaction->payer_phone}}</td>
                            <td>{{$transaction->recipient_phone}}</td>
                            <td>{{$transaction->amount}}</td>
                            <td>{{$transaction->type}}</td>
                            <td>{{$transaction->note}}</td>
                            <td>
                                <a href="{{route('transaction.edit',$transaction->id)}}"
                                   class="btn btn-primary">{{ __('Edit') }}</a>
                                <a href="{{route('transaction.destroy',$transaction->id)}}"
                                   class="btn btn-danger">{{ __('Delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">{{ __('dashboard.notransaction') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="pl-lg-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
