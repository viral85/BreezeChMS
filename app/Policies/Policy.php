<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function emailtemplates(User $user)
    {
        return ($user->role->slug == 'superadmin');
    }
}
