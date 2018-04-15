@extends('Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('labels.uploadcsv')}}
        </div>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                </div><!-- /.box-header -->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('validation.whoops')}}</strong>{{trans('validation.someproblems')}}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="addProfessionBulk" class="form-horizontal" method="post" files="true" action="{{ url('/savecsv') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body">


                    <div class="form-group">
                        <label for="upload_type" class="col-sm-3 control-label">{{trans('labels.csvtype')}}</label>
                        <div class="col-sm-6">
                            <select id="upload_type" name="upload_type" class="form-control">
                                <option selected disabled>{{trans('labels.selectcsvtype')}}</option>
                                <option value="1">{{trans('labels.people')}}</option>
                                <option value="2">{{trans('labels.group')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="upload_file" class="col-sm-3 control-label">{{trans('labels.selectcsvfile')}}</label>
                        <div class="col-sm-6">
                            <input type="file" id="upload_file" name="upload_file" class="form-control" accept=".csv"/>
                        </div>
                    </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary btn-flat" >{{trans('labels.savebtn')}}</button>
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/professions') }}">{{trans('labels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')
<script type="text/javascript">
    jQuery(document).ready(function() {

            var validationRules = {
                upload_type : {
                    required : true
                },
                upload_file : {
                    required : true
                }
            }


        $("#addProfessionBulk").validate({
            rules : validationRules,
            messages : {
                upload_type : {
                    required : "<?php echo trans('validation.requiredfield'); ?>"
                },
                upload_file : {
                    required : "<?php echo trans('validation.requiredfield'); ?>"
                }
            }
        })
    });

</script>
@stop

