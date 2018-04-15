<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Auth;

class People extends Model
{
    protected $table = 'people';

    protected $fillable = ['person_id', 'first_name', 'last_name', 'email_address', 'group_id', 'status'];
    
    /**
     * Insert and Update People
     */
    public function insertUpdate($data)
    {
        if (isset($data['id']) && $data['id'] != '' && $data['id'] > 0) {
            return People::where('id', $data['id'])->update($data);
        } else {
            return People::create($data);
        }
    }

    /**
     * get all Active People
     */
    public function getAllActivePeople() {  
        $tags = People::where('status', '<>', Config::get('constant.DELETED_FLAG'))->get();
        return $tags;
    }
    
    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }

}
