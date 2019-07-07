<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Table;

class TablePolicy
{
    use HandlesAuthorization;



    /**
     * check if the user is able to create or update or delete a table
     */
    public function crud(User $user, Table $table = null)
    {
        return true;
    }
}
