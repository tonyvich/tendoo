<?php
namespace App\Services;
use App\Models\User;
use App\Models\Role;

class Guard
{
    /**
     * Ask For permission
     * @return view or empty
     */
    public function allow( $permission ) 
    {
        if ( ! User::allowedTo( $permission ) ) {

            
        }
    }
}