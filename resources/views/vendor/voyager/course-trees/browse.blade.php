@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> 算法设计与分析-邹娟
            @php
                $courseId = data_get($_GET, 'courseId', -1);
                if($courseId == -1 || $courseId == '') {
                    $host = env('APP_URL');
                    header("Location: $host/api/course");   
                }
            @endphp
            <input type="hidden" value="@php echo $courseId @endphp" id="courseId" />
        </h1>
        <a class="btn btn-warning" id="courseTreeAllSync"  url=@php echo env('APP_URL').'/api/courseTree?courseId='.$courseId @endphp><i class="voyager-refresh"></i> <span>覆盖同步</span></a>
        <a class="btn btn-primary" id="courseTreeAddSync" url=@php echo env('APP_URL').'/api/courseTree?isAdd=true&courseId='.$courseId @endphp><i class="voyager-refresh"></i> <span>增量同步</span></a>
    </div>
@stop

@section('content')
<div id="app">
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding-top:20px;">
                        <h3 style="color:#1f2f3d;padding-bottom:10px;"> 添加 Tag </h1>
                        <worlduc-coursetag></worlduc-coursetag>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding-top:20px;">
                        <h3 style="color:#1f2f3d;padding-bottom:10px;"> 编辑 CourseTree </h1>
                        <worlduc-coursetree></worlduc-coursetree>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
<link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => [],
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [['searchable' =>  false, 'targets' => -1 ]],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
    <script>
        // 覆盖同步
        document.getElementById("courseTreeAllSync").onclick = function() {
            if(confirm("『覆盖同步』会从世界大学城同步以更新你的 CourseTree，你设置 Tag 和课程目标都将消失，确定同步吗？")){
                var xmlhttp = new XMLHttpRequest();
                var url = document.getElementById("courseTreeAllSync").attributes["url"].value;  
                xmlhttp.open("POST", url, true);
                xmlhttp.send();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("覆盖同步获取成功")
                        alert("覆盖同步获取成功!")
                        location.reload()
                    } else if(xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                        console.log("覆盖同步获取失败")
                        alert("覆盖同步获取失败!")
                    }
                }
            } 
        };

        document.getElementById("courseTreeAddSync").onclick = function() {
            if(confirm("『增量同步』会从世界大学城同步以更新你的 CourseTree，并保留你设置 Tag 和课程目标，确定同步吗？")){  
                var xmlhttp = new XMLHttpRequest();
                var url = document.getElementById("courseTreeAddSync").attributes["url"].value;  
                xmlhttp.open("POST", url, true);
                xmlhttp.send();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        console.log("增量同步获取成功")
                        alert("增量同步获取成功!")
                        location.reload()
                    } else if(xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                        console.log("增量同步获取失败")
                        alert("增量同步获取失败!")
                    }
                }
            } 
        };
    </script>
@stop
