@extends('layout.adminpanel.dashboard')
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
@section('Headtitle')
    {{ __('dashboard.Debts') }}
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
    {{ __('dashboard.Debts') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6 text-left">
                    <h4>{{ __('dashboard.Debts') }}</h4>
                    {{--                                (<a href="{{ url('transactions','debt') }}">Debt</a> OR <a--}}
                    {{--                                    href="{{ url('transactions','payment') }}">Payment</a>)--}}
                </div>
                <div class="col col-md-6 text-right">
                    <a class="btn btn-secondary"
                       href="{{route('debt.create')}}">{{ __('dashboard.adddebt') }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Creditor Phone</th>
                    <th scope="col">Debitor Phone</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Note</th>
                    <th scope="col">Edit/Delete</th>
                </tr>
                </thead>
                <tbody>
                @if(!count($debts)<1)
                    @foreach ($debts as $debt )
                        <tr>
                            <th scope="row"><a href="{{route('debt.show',$debt->id)}}">{{ $debt->id }}</a></th>
                            <td>{{ $debt->creditor_phone }}</td>
                            <td>{{ $debt->debitor_phone }}</td>
                            <td>{{ $debt->amount_debt }}</td>
                            <td>{{ $debt->note }}</td>
                            <td>
                                <a href="{{route('debt.edit',$debt->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>
                                <a href="{{route('debt.destroy',$debt->id)}}"
                                   class="btn btn-danger">{{ __('Delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">{{ __('dashboard.nodebt') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="pl-lg-4">
                {{ $debts->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
