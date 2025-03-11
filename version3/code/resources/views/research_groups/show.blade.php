@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card col-md-10" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ trans('message.project_group_detail') }}</h4>
            <p class="card-description">{{ trans('message.info_project_group_detail') }}</p>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>ชื่อกลุ่มวิจัย (ภาษาไทย)</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_th }}</p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3"><b>Project Group's Name (English)</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_name_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>คำอธิบายกลุ่มวิจัย (ภาษาไทย)</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_th }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>Project Group's Description (English)</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_desc_en }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>รายละเอียดกลุ่มวิจัย (ภาษาไทย)</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_detail_th }}</p>
            </div>
            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>Project Group's Detail (English)</b></p>
                <p class="card-text col-sm-9">{{ $researchGroup->group_detail_en }}</p>
            </div>
            <div class="row mt-3">
                <p class="card-text col-sm-3"><b>{{ trans('message.project_leader') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($researchGroup->user as $user)
                    @if ( $user->pivot->role == 1)
                    {{$user->position_th}}{{ $user->fname_th}} {{ $user->lname_th}}
                    @endif
                    @endforeach</p>
            </div>
            <div class="row mt-1">
                <p class="card-text col-sm-3"><b>{{ trans('message.members') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($researchGroup->user as $user)
                    @if ( $user->pivot->role == 2)
                    {{$user->position_th}}{{ $user->fname_th}} {{ $user->lname_th}},
                    @endif
                    @endforeach</p>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('researchGroups.index') }}"> Back</a>
        </div>
    </div>
    
@stop
@section('javascript')
<script>
$(document).ready(function() {

    /* When click New customer button */
    $('#new-customer').click(function() {
        $('#btn-save').val("create-customer");
        $('#customer').trigger("reset");
        $('#customerCrudModal').html("Add New Customer EiEi");
        $('#crud-modal').modal('show');
    });
    /* When click New customer button */
    $('#new-customer2').click(function() {
        $('#btn-save').val("create-customer");
        $('#customer').trigger("reset");
        $('#customerCrudModal').html("Add New Customer EiEi");
        $('#crud-modal').modal('show');
    });
});
</script>

@stop