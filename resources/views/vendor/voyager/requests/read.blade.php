@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->display_name_singular) }} &nbsp;
        <!-- <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->display_name_singular) }} &nbsp; -->

        <!-- @can('edit', $dataTypeContent)
        <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
            <span class="glyphicon glyphicon-pencil"></span>&nbsp;
            {{ __('voyager::generic.edit') }}
        </a>
        @endcan
        @can('delete', $dataTypeContent)
            <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
            </a>
        @endcan

        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a> -->
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

