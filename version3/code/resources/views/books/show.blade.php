@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-8" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ trans('message.book_detail') }}</h4>
            <p class="card-description">{{ trans('message.info_book_detail') }}</p>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.book_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_name }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.year') }}</b></p>
                @if(app()->getLocale() == 'th')
                    <p class="card-text col-sm-9">{{  date('Y', strtotime($paper->ac_year))+543 }}</p>
                @else
                    <p class="card-text col-sm-9">{{  date('Y', strtotime($paper->ac_year)) }}</p>
                @endif
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>{{ trans('message.source') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_sourcetitle }}</p>
            </div>
            <div class="row">
                <p class="card-text col-sm-3"><b>จำนวนหน้า (Page number)</b></p>
                <p class="card-text col-sm-9">{{ $paper->ac_page }}</p>
            </div>

            <div class="pull-right mt-5">
                <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}"> Back</a>
            </div>
        </div>

    </div>


</div>
@endsection