@extends('voyager::master')

@section('page_title', "编辑队员")

@section('content')

<h1 class="page-title">
    <i class="voyager-file-text"></i>
    编辑团队成员
</h1>
<div class="page-content edit-add container-fluid">
    <div class="col-md-12">
        <div id="app">
            <worlduc-addteammember></worlduc-addteammember>
        </div>
    </div>
</div>

@stop
