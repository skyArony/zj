@extends('voyager::master')

@section('content')

@section('page_title', "添加队员")

<h1 class="page-title">
    <i class="voyager-file-text"></i>
    编辑班级成员
</h1>

<!-- <div id="qrcode"></div> -->

<div class="page-content edit-add container-fluid">
    <div class="col-md-12">
        <div id="app">
            <worlduc-addclassmember></worlduc-addclassmember>
        </div>
    </div>
</div>

@stop
