@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<style>
    .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 10px;
        padding: 4px 10px;
        width: 100%;
        font-size: 14px;
    }
</style>
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- <a class="btn btn-primary" href="{{ route('funds.index') }}"> Back </a> -->
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ trans('message.add_funding') }}</h4>
                <p class="card-description">{{ trans('message.fill_in_funding') }}</p>
                <form class="forms-sample" action="{{ route('funds.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="exampleInputfund_type" class="col-sm-2 ">{{ trans('message.funding_type') }}</label>
                        <div class="col-sm-4">
                            <select name="fund_type" class="custom-select my-select" id="fund_type" onchange='toggleDropdown(this);' required>
                                <option value="" disabled selected >---- โปรดระบุประเภททุน ----</option>
                                <option value="ทุนภายใน">ทุนภายใน</option>
                                <option value="ทุนภายนอก">ทุนภายนอก</option>
                            </select>
                        </div>
                    </div>
                    <div id="fund_code">
                        <div class="form-group row">
                            <label for="exampleInputfund_level" class="col-sm-2 ">{{ trans('message.capital_level') }}</label>
                            <div class="col-sm-4">
                                <select name="fund_level" class="custom-select my-select">
                                <option value="" disabled selected >---- โปรดระบุระดับทุน ----</option>
                                    <option value="">ไม่ระบุ</option>
                                    <option value="สูง">สูง</option>
                                    <option value="กลาง">กลาง</option>
                                    <option value="ล่าง">ล่าง</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputfund_name" class="col-sm-2 ">{{ trans('message.capital_name') }}</label>
                        <div class="col-sm-8">
                            <input type="text" name="fund_name" class="form-control" placeholder="name">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="exampleInputsupport_resource" class="col-sm-2 ">{{ trans('message.funding_support') }} / {{ trans('message.ResearchProj') }} </label>
                        <div class="col-sm-8">
                            <input type="text" name="support_resource" class="form-control" placeholder="Support Resource">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a class="btn btn-light" href="{{ route('funds.index')}}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const ac = document.getElementById("fund_code");
    //ac.style.display = "none";

    function toggleDropdown(selObj) {
        ac.style.display = selObj.value === "ทุนภายใน" ? "block" : "none";
    }
</script>
@endsection