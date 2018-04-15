@extends('Master')

@section('content')
<!-- content push wrapper -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('labels.peoples')}}
        <a href="{{ url('uploadcsv') }}" class="btn btn-block btn-danger add-btn-primary pull-right">{{trans('labels.addbtn')}}</a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header pull-right ">
                <i class="s_active fa fa-square"></i> {{trans('labels.activelbl')}} <i class="s_inactive fa fa-square"></i>{{trans('labels.archivedlbl')}}
            </div>
        </div>
        <div class="box-header">
            <div class="col-md-5">
                <label for="group_id" class="col-sm-4 control-label">{{trans('labels.selectgroupname')}}</label>
                <div class="col-md-8">
                    <select id="group_id" name="group_id"  class="form-control">
                        <option value="" disabled selected>{{trans('labels.selectgroupname')}}</option>
                        @forelse($groupData as $key => $value)
                            <option value="{{$value->group_id}}">{{$value->group_name}}</option>
                        @empty
                            <option disabled>No Data Found</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <table id="listPeopleData" class="table table-striped display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{trans('labels.person_id')}}</th>
                                <th>{{trans('labels.first_name')}}</th>
                                <th>{{trans('labels.last_name')}}</th>
                                <th>{{trans('labels.email_address')}}</th>
                                <th>{{trans('labels.group_name')}}</th>
                                <th>{{trans('labels.status')}}</th>
                            </tr>
                        </thead>
                     </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var ajaxParams = {};
        getPeopleList(ajaxParams);
    });


    $("#group_id").on('change',function(){      
        getPeopleList();
    });

    var getPeopleList = function(ajaxParams){
        $('#listPeopleData').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax":{
                "url": "{{ url('getPeopleData') }}",
                "dataType": "json",
                "type": "POST",
                headers: { 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                "data" : function(data) {
                    var ajaxParams = {};
                    ajaxParams.group_id = $("#group_id").val();
                    if (ajaxParams) {
                        $.each(ajaxParams, function(key, value) {
                            data[key] = value;
                        });
                    }
                }
            },
            "columns": [
                { "data" : "person_id" },
                { "data" : "first_name" },
                { "data" : "last_name" },
                { "data" : "email_address" },
                { "data" : "group_name" },
                { "data" : "status" },
            ]
        });
    };
</script>
@stop