@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> <font>课程名</font>
            @php
                $courseId = data_get($_GET, 'courseId', -1);
                if($courseId == -1 || $courseId == '') {
                    header("Location: /admin/courses");   
                }
            @endphp
            <input type="hidden" value="@php echo $courseId @endphp" id="courseId" />
        </h1>
        <button class="btn btn-warning" id="courseTreeAllSync"  url=@php echo '/api/courseTree/'.$courseId @endphp><i class="voyager-refresh"></i> <span>覆盖同步</span></button>
        <button class="btn btn-primary" id="courseTreeAddSync" url=@php echo '/api/courseTree/'.$courseId."?isAdd=true" @endphp><i class="voyager-refresh"></i> <span>增量同步</span></button>
        <a href="@php echo '/video/course/'.$courseId @endphp" class="btn btn-success">
            <i class="voyager-eye"></i> <span>查看课程视频</span>
        </a>
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
                        <h3 style="color:#1f2f3d;padding-bottom:10px;"> 编辑课程目录 </h1>
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
        !(function() {
            var courseId = $("#courseId").val()
            $.ajax({
                url: "/api/course/" + courseId,
                success: function(data) {
                    // console.log(data)
                    $(".page-title font").text(data.data.name)
                },
                error: function(data) {
                    console.log("发生了错误!")
                    console.log(data)
                }
            })
        })()
        // 覆盖同步
        document.getElementById("courseTreeAllSync").onclick = function() {
            if(confirm("『覆盖同步』会从世界大学城同步以更新你的 CourseTree，你设置 Tag 和课程目标都将消失，确定同步吗？")){
                var xmlhttp = new XMLHttpRequest();
                var url = document.getElementById("courseTreeAllSync").attributes["url"].value;  
                xmlhttp.open("POST", url, true);
                xmlhttp.send();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var data = JSON.parse(xmlhttp.responseText)
                        if (data.data == null) alert("覆盖同步获取成功,但是你并没有在大学城-空间慕课设置课时!")
                        else {
                            alert("覆盖同步获取成功!")
                            location.reload()
                        }
                        console.log("覆盖同步获取成功")
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
                        var data = JSON.parse(xmlhttp.responseText)
                        if (data.data == null) alert("覆盖同步获取成功,但是你并没有在大学城-空间慕课设置课时!")
                        else {
                            alert("增量同步获取成功!")
                            location.reload()
                        }
                        console.log("增量同步获取成功")
                    } else if(xmlhttp.readyState == 4 && xmlhttp.status != 200) {
                        console.log("增量同步获取失败")
                        alert("增量同步获取失败!")
                    }
                }
            } 
        };
    </script>
@stop
