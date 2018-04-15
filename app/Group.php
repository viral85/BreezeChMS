<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Auth;

class Group extends Model
{
    protected $table = 'group';

    protected $fillable = ['group_id', 'group_name', 'status'];
    
    /**
     * Insert and Update Group
     */
    public function insertUpdate($data)
    {
        if (isset($data['id']) && $data['id'] != '' && $data['id'] > 0) {
            return Group::where('id', $data['id'])->update($data);
        } else {
            return Group::create($data);
        }
    }

    /**
     * get all Group
     */
    public function getAllGroup() {  
        $tags = Group::where('status', Config::get('constant.ACTIVE_FLAG'))->get();
        return $tags;
    }

}
