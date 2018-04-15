<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\People;
use App\Group;
use Input;
use Auth;
use Excel;
use Validator;
use Redirect;
use Config;

class PeopleController extends Controller
{
    //
    public function __construct()
    {
        $this->objPeople = new People();
        $this->objGroup = new Group();
        $this->middleware('auth');
    }

    public function index()
    {
        $groupData = $this->objGroup->getAllGroup();
        return view('Dashboard',compact('groupData'));
    }

    public function uploadCsv()
    {
        return view('AddPeople');
    }

    public function importCsv()
    {

        $path = Input::file('upload_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get();

    	if(Input::get('upload_type') == '1') //People
    	{
            if( !isset($results[0]->person_id) || !isset($results[0]->first_name) || !isset($results[0]->last_name) || !isset($results[0]->email_address) || !isset($results[0]->group_id) || !isset($results[0]->state) ){
                return redirect()->back()->with('error', trans('labels.peoplecolumnnotfound'));
            }
            foreach ($results as $key => $value)
            {
                $data = [];
                $data['person_id'] = $value->person_id;
                $data['first_name'] = $value->first_name;
                $data['last_name'] = $value->last_name;
                $data['email_address'] = $value->email_address;
                $data['group_id'] = $value->group_id;
                $data['status'] = ($value->state == "active") ? "1" : "2";

                /*Check for Unique Mail*/                
                $rules['email_address'] = [
                    'required',
                    Rule::unique('people', 'email_address')
                ];

                $validator = Validator::make($data, $rules);                
                
                if ($validator->fails()) {
                    return redirect()->back()->with('error', $data['email_address'].' '.$validator->messages()->all()[0]);
                }

                /*Insert records to table*/
                $this->objPeople->insertUpdate($data);
            }

            return Redirect::to("uploadcsv")->with('success', trans('labels.peoplecsvuploadedsuccessfully'));
    	}
    	elseif(Input::get('upload_type') == '2') //Group
    	{
            if( !isset($results[0]->group_id) || !isset($results[0]->group_name) ){
                return redirect()->back()->with('error', trans('labels.groupcolumnnotfound'));
            }
			foreach ($results as $key => $value)
			{
                $data = [];
				$data['group_id'] = $value->group_id;
				$data['group_name'] = $value->group_name;
				$this->objGroup->insertUpdate($data);
			}
            return Redirect::to("uploadcsv")->with('success', trans('labels.groupcsvuploadedsuccessfully'));
    	}

    }


    public function getPeopleData() {
        $peoples = $this->objPeople->where('status', '<>', Config::get('constant.DELETED_FLAG'))->count();
        
        $records = array();
        $columns = array(
            0 => 'person_id',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'email_address',
            4 => 'group_id',
            5 => 'group_name',
            6 => 'status',
        );
        
        $order = Input::get('order');
        $search = Input::get('search');
        $records["data"] = array();
        $iTotalRecords = $peoples;
        $iTotalFiltered = $iTotalRecords;
        $iDisplayLength = intval(Input::get('length')) <= 0 ? $iTotalRecords : intval(Input::get('length'));
        $iDisplayStart = intval(Input::get('start'));
        $sEcho = intval(Input::get('draw'));

        $records["data"] = $this->objPeople->where('status', '<>', Config::get('constant.DELETED_FLAG'));

        if( Input::get('group_id') ){
            $records["data"]->Where('group_id',Input::get('group_id'));
        }
        
        if (!empty($search['value'])) {
            $val = $search['value'];
            $records["data"]->where(function($query) use ($val) {
                $query->where('person_id', "Like", "%$val%");
                $query->orWhere('first_name', "Like", "%$val%");
                $query->orWhere('last_name', "Like", "%$val%");
                $query->orWhere('email_address', "Like", "%$val%");
                $query->orWhere('group_id', "Like", "%$val%");
                $query->with(['group' => function ($query) use ($val){
                            $query->where('group_name', "Like", "%$val%");
                        }]);
            });

            // No of record after filtering
            $iTotalFiltered = $records["data"]->where(function($query) use ($val) {
                $query->where('person_id', "Like", "%$val%");
                $query->orWhere('first_name', "Like", "%$val%");
                $query->orWhere('last_name', "Like", "%$val%");
                $query->orWhere('email_address', "Like", "%$val%");
                $query->orWhere('group_id', "Like", "%$val%");
                $query->with(['group' => function ($query) use ($val){
                            $query->where('group_name', "Like", "%$val%");
                        }]);
                })->count();
        }
        
        //order by
        foreach ($order as $o) {
            $records["data"] = $records["data"]->orderBy($columns[$o['column']], $o['dir']);
        }

        //limit
        $records["data"] = $records["data"]->take($iDisplayLength)->offset($iDisplayStart)->get();
        $sid = 0;

        if (!empty($records["data"])) {
            foreach ($records["data"] as $key => $_records) {
                $records["data"][$key]->group_name = $_records->group->group_name;
                $records["data"][$key]->status = ($_records->status == 1) ? "<i class='s_active fa fa-square'></i>" : "<i class='s_inactive fa fa-square'></i>";
            }
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalFiltered;

        return \Response::json($records);
        exit;
    }

}
