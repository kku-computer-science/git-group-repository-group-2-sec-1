@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ trans('message.paper_detail') }}</h4>
            <p class="card-description">{{ trans('message.info_paper_detail') }}
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>{{ trans('message.paper_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_name }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.abstract') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->abstract }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>Keyword</b></p>
                <p class="card-text col-sm-9">
                    {{ $paper->keyword }}
                </p>


                <!-- <p class="card-text col-sm-9">{{ $paper->keyword }}</p> -->
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.document_type') }} (Type)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_type }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.document_type') }} (Subtype)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_subtype }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.publications2') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->publication }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.author') }}</b></p>
                <p class="card-text col-sm-9">

                    @foreach($paper->author as $teacher)
                    @if($teacher->pivot->author_type == 1)
                    <b>First Author:</b> {{ $teacher->author_fname}} {{ $teacher->author_lname}} <br>
                    @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                    @if($teacher->pivot->author_type == 1)
                    <b>First Author:</b> {{ $teacher->fname_en}} {{ $teacher->lname_en}} <br>
                    @endif 
                    @endforeach

                    @foreach($paper->author as $teacher)
                    @if($teacher->pivot->author_type == 2)
                    <b>Co Author:</b> {{ $teacher->author_fname}} {{ $teacher->author_lname}} <br>
                    @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                    @if($teacher->pivot->author_type == 2)
                    <b>Co Author:</b> {{ $teacher->fname_en}} {{ $teacher->lname_en}} <br>
                    @endif 
                    @endforeach

                    @foreach($paper->author as $teacher)
                    @if($teacher->pivot->author_type == 3)
                    <b>Corresponding Author:</b> {{ $teacher->author_fname}} {{ $teacher->author_lname}} <br>
                    @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                    @if($teacher->pivot->author_type == 3)
                    <b>Corresponding Author:</b> {{ $teacher->fname_en}} {{ $teacher->lname_en}} <br>
                    @endif 
                    @endforeach
                    



                </p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.journal_name') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_sourcetitle }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ trans('message.publication_year') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_yearpub }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>วารสารพิมพ์เป็นปีที่ (volume)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_volume }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ฉบับที่ (Issue number)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_issue}}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>หน้า (page)</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_page }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>DOI</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_doi }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>URL</b></p>
                <a href="{{ $paper->paper_url }}" target="_blank" class="card-text col-sm-9">{{ $paper->paper_url }}</a>
            </div>

            <a class="btn btn-primary mt-5" href="{{ route('papers.index') }}"> Back</a>
        </div>
    </div>

</div>
@endsection