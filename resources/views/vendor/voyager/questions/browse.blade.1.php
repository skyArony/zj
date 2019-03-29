@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div id="app">
            <worlduc-questionadd></worlduc-questionadd>
        </div>

        <!-- <div class="row">
            <div class="col-md-3" style="height:200px;background-color:red;max-width:300px"> -->
                
                <!-- <div class="panel panel-bordered">
                    <div class="pannel-body">
                        <div id="app">
                            <worlduc-questionadd></worlduc-questionadd>
                        </div>
                    </div>
                </div> -->
            <!-- </div>
            <div class="col-md-9"  style="height:200px;background-color:blue;"></div>
        </div> -->
    </div>
@stop