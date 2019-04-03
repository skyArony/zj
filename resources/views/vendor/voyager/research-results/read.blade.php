@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->display_name_singular) }} &nbsp;
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')

<div class="page-content edit-add container-fluid">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="pannel-body">
                <div id="app">
                    <worlduc-request></worlduc-request>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

