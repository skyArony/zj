@extends('voyager::master')

@section('page_title', "我的数据")

@section('css')

    @include('voyager::compass.includes.styles')

    <style>
    .tab-content .tab-pane {
        display: none;
    }
    </style>

@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-pie-chart"></i>
        <p> 数据图表 </p>
        <span class="page-description">可视化的数据图表</span>
    </h1>
@stop

@section('content')

    <div id="gradient_bg"></div>

    <div class="container-fluid">
        @include('voyager::alerts')
    </div>

    <div class="page-content compass container-fluid">

        <ul class="nav nav-tabs">
          <li class="active" id="survey-nav-tab"><a data-toggle="tab" href="#survey"><i class="voyager-documentation"></i> 问卷统计 </a></li>
          <li id="record-nav-tab"><a data-toggle="tab" href="#record"><i class="voyager-documentation"></i> 问卷记录 </a></li>
          <li id="tag-nav-tab"><a data-toggle="tab" href="#tag"><i class="voyager-tag"></i> 知识点 </a></li>
        </ul>

        <div class="tab-content" id="app">
            <worlduc-chart></worlduc-chart>
        </div>
        
    </div>
    <script src="https://cdn.bootcss.com/Chart.js/2.7.3/Chart.bundle.min.js"></script>

@stop
@section('javascript')
    <script>
        // $('document').ready(function(){
        //     $('#survey-nav-tab').click(function(){
        //         $('#survey').addClass('active')
        //         $('#tag').removeClass('active')
        //         $('#tag').removeClass('show')
        //     })
        //     $('#tag-nav-tab').click(function(){
        //         $('#tag').addClass('active')
        //         $('#survey').removeClass('active')
        //         $('#survey').removeClass('show')
        //     })
        // });
    </script>
@stop
