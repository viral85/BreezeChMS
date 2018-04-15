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

class PeopleController extends Controller
{
    //
    public function __construct()
    {
        $this->objPeople = new People();
        $this->objGroup = new Group();
        $this->middleware('auth');
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
            foreach ($results as $key => $value)
            {
                $data = [];
                $data['person_id'] = $value->person_id;
                $data['first_name'] = $value->first_name;
                $data['last_name'] = $value->last_name;
                $data['email_address'] = $value->email_address;
                $data['group_id'] = $value->group_id;
                $data['status'] = $value->status;

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
}
