<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Config;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id', 'slug', 'name', 'created_by', 'updated_by', 'status'];

    public function insertUpdate($role)
    {
        if (isset($role['id']) && $role['id'] != '' && $role['id'] > 0) {
            $role['updated_by'] = Auth::user()->id;
            return EmailTemplates::where('id', $role['id'])->update($role);
        } else {
            $role['created_by'] = Auth::user()->id;
            return EmailTemplates::create($role);
        }
    }

    public function getAllRoles()
    {
        $roles = Role::where('status', '<>', Config::get('constant.DELETED_FLAG'))
                                ->orderBy('id', 'DESC')
                                ->paginate(Config::get('constant.ADMIN_RECORD_PER_PAGE'));

        return $roles;
    }
}
