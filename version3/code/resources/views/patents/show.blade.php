@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ trans('message.other_work_detail') }}</h4>
            <p class="card-description">{{ trans('message.info_other_work_detail') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.name') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.type') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_type }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.registration_date') }}</b></p>
                <p class="card-text col-sm-9">{{ $patent->ac_year }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.registration_number') }}</b></p>
                <p class="card-text col-sm-9">{{ trans('message.number_data') }} : {{ $patent->ac_refnumber }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.author') }}</b></p>
                <p class="card-text col-sm-9">@foreach($patent->user as $a)
                    {{ $a->fname_th }} {{ $a->lname_th }}
                @if (!$loop->last),@endif
                @endforeach
                </p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.co-author') }}</b></p>
                <p class="card-text col-sm-9">
                @foreach($patent->author as $a)
                    {{ $a->author_fname }} {{ $a->author_lname }}
                @if (!$loop->last),@endif
                @endforeach</p>
            </div>
            
            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('patents.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection