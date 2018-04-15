@extends('Master')

@section('content')
<!-- content push wrapper -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('labels.emailtemplates')}}
        <a href="{{ url('addtemplate') }}" class="btn btn-block btn-danger add-btn-primary pull-right">{{trans('labels.addbtn')}}</a>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">
                    <table class="table table-hover">
                        <tr>
                            <th>{{trans('labels.headername')}}</th>
                            <th>{{trans('labels.headerpseudoname')}}</th>
                            <th>{{trans('labels.headersubject')}}</th>
                            <th>{{trans('labels.headerstatus')}}</th>
                            <th>{{trans('labels.headeraction')}}</th>
                        </tr>
                        @forelse($EmailTemplatesList as $key=>$value)
                        <tr>
                            <td>
                                {{$value->name}}
                            </td>
                            <td>
                                {{$value->pseudoname}}
                            </td>
                            <td>
                                {{$value->subject}}
                            </td>
                            <td>
                                @if ($value->status == 1)
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/edittemplate') }}/{{$value->id}}" title="Edit"><i class="fa fa-edit"></i> &nbsp;&nbsp;</a>
                                <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ url('/deletetemplate') }}/{{$value->id}}"><i class="i_delete fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5"><center>{{trans('labels.norecordfound')}}</center></td>
                        </tr>
                        @endforelse
                    </table>
                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
            @if (isset($EmailTemplatesList) && !empty($EmailTemplatesList))
                <div class="pull-right">
                    <?php echo $EmailTemplatesList->render(); ?>
                </div>
            @endif
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
@stop