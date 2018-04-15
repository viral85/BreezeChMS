@extends('Master')

@section('content')
<!-- content   -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('labels.invitations')}}
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"> 
                         
                    </h3>
                </div><!-- /.box-header -->
                <div id="err_dis" class="col-md-12">
                    <div class="box-body">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
                            <strong>{{trans('validation.whoops')}}</strong>{{trans('validation.someproblems')}}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                <form id="sendinvitations" class="form-horizontal" method="post" action="{{ url('/sendinvitations') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="at_name" class="col-sm-2 control-label">{{trans('labels.emailid')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="emailid" id="emailid" class="form-control" tabindex="1"/>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-warning pull-right" tabindex="2">{{trans('labels.sendinvitations')}}</button>
                        <a class="btn btn-danger pull-left" href="{{ url('/dashboard') }}" tabindex="3">{{trans('labels.cancelbtn')}}</a>
                    </div><!-- /.box-footer --> 
                </form>
            </div>
        </div>
    </div>
</section>
@stop
