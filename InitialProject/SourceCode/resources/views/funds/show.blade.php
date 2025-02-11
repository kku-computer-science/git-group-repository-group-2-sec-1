@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ trans('message.fund_detail') }}</h4>
            <p class="card-description">{{ trans('message.info_fund_detail') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.capital_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.year') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_year }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.fund_detail') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_details }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.funding_type') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_type }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.capital_level') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_level }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.funding_support') }}</b></p>
                <p class="card-text col-sm-9">{{ $fund->fund_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.add_detail_by') }}</b></p>
                @if(app()->getLocale() == 'th')
                    <p class="card-text col-sm-9">{{ $fund->user->fname_th }} {{ $fund->user->lname_th}}</p>
                @else
                <p class="card-text col-sm-9">{{ $fund->user->fname_en }} {{ $fund->user->lname_en}}</p>
                @endif
            </div>
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('funds.index') }}"> Back</a>
            </div>
        </div>

    </div>


</div>
@endsection