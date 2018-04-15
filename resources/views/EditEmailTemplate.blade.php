@extends('Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('labels.emailtemplates')}}
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">

        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo (isset($data) && !empty($data)) ? ' Edit ' : 'Add' ?> {{trans('labels.emailtemplate')}}</h3>
                </div><!-- /.box-header -->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('labels.whoops')}}</strong> {{trans('labels.someproblems')}}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="addtemplate" class="form-horizontal" method="post" action="{{ url('/savetemplate') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($data) && !empty($data)) ? $data->id : '0' ?>">
                    <div class="box-body">

                        <div class="form-group">
                            <?php
                            if (old('name'))
                                $name = old('name');
                            elseif ($data)
                                $name = $data->name;
                            else
                                $name = '';
                            ?>
                            <label for="inputEmail3" class="col-sm-2 control-label">{{trans('labels.formlblName')}}<span class="star_red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{trans('labels.formlblName')}}" value="{{$name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            if (old('pseudoname'))
                                $pseudoname = old('pseudoname');
                            elseif ($data)
                                $pseudoname = $data->pseudoname;
                            else
                                $pseudoname = '';
                            ?>
                            <label for="inputEmail3" class="col-sm-2 control-label">{{trans('labels.formlblpseudoname')}}</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="true" class="form-control" id="pseudoname" name="pseudoname" placeholder="{{trans('labels.formlblpseudoname')}}" value="{{$pseudoname}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            if (old('subject'))
                                $subject = old('subject');
                            elseif ($data)
                                $subject = $data->subject;
                            else
                                $subject = '';
                            ?>
                            <label for="inputEmail3" class="col-sm-2 control-label">{{trans('labels.formlblsubject')}}<span class="star_red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="{{trans('labels.formlblsubject')}}" value="{{$subject}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            if (old('body'))
                                $body = old('body');
                            elseif ($data)
                                $body = $data->body;
                            else
                                $body = '';
                            ?>
                            <label for="inputEmail3" class="col-sm-2 control-label">{{trans('labels.formlblbody')}}<span class="star_red">*</span></label>
                            <div class="col-sm-10">
                                <!--<textarea name="body" id="body">{{$body}}</textarea>-->
                                <textarea id="body" name="body" class="form-control" cols="5"  rows="5" placeholder="">{{$body}}</textarea>
                            </div>
                        </div>
                        <?php
                        if (old('status'))
                            $deleted = old('status');
                        elseif ($data)
                            $deleted = $data->status;
                        else
                            $deleted = '';
                        ?>
                        <div class="form-group">
                            <label for="category_type" class="col-sm-2 control-label">{{trans('labels.formlblstatus')}}</label>
                            <div class="col-sm-6">
                                <?php $staus = Helpers::status();
                                ?>
                                <select class="form-control" id="status" name="status">
                                    <?php foreach ($staus as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if($deleted == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-danger save-btn">{{trans('labels.savebtn')}}</button>
                            <a class="btn btn-default" href="{{ url('templates') }}">{{trans('labels.cancelbtn')}}</a>
                        </div>
                    </div><!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
</section><!-- /.content -->
@stop
@section('script')
<script src="{{asset('plugins/ckeditor/ckeditor.js')}}"></script>
<?php if (empty($data)){ ?>
<script>
$('#name').keyup(function () {
    var str = $(this).val();
    str = str.replace(/[^a-zA-Z0-9\s]/g, "");
    str = str.toLowerCase();
    str = str.replace(/\s/g, '-');
    $('#pseudoname').val(str);
});
</script>
<?php } ?>
<script>
CKEDITOR.replace('body');
$(document).ready(function () {

    $.validator.addMethod("emptyetbody", function(value, element) {
        var body_data = CKEDITOR.instances['body'].getData();
        return body_data != '';
    }, "<?php echo trans('validation.bodyrequired')?>");

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "<?php echo trans('validation.lettersonly')?>");

    var signupRules = {
        name: {
            required: true,
            lettersonly : true
        },
        subject: {
            required: true,
            lettersonly : true
        },
        body: {
            emptyetbody: true
        }
    };

    $("#addtemplate").validate({
        ignore: "",
        rules: signupRules,
        messages: {
            name: {
                required: "<?php echo trans('labels.templatenamerequired')?>"
            },
            subject: {
                required: "<?php echo trans('labels.subjectrequired')?>"
            },
            body: {
                emptyetbody: "<?php echo trans('labels.bodyrequired')?>"
            }
        },
        submitHandler: function(form) {
          // do other things for a valid form
            $('.save-btn').prop('disabled', true);
            form.submit();
        }
            
    });
});
</script>
@stop