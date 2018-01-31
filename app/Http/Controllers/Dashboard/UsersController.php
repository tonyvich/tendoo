<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\TendooController;
use App\Http\Requests\UserProfileRequest;

class UsersController extends TendooController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware( function( $request, $next ) {
            return $next( $request );
        });
    }

    /**
     * User List
     * display available users
     * @return view of users
     */
    public function usersList()
    {
        $this->checkPermission( 'read.users' );
        $this->setTitle( __( 'Users' ) );
        return view( 'components.backend.dashboard.users-list' );
    }

    /**
     * Create users
     * @param void
     * @return view
     */
    public function createUser()
    {
        $this->checkPermission( 'create.users' );
        $this->setTitle( __( 'Create a user' ) );
        return view( 'components.backend.dashboard.create-user' );
    }

    /**
     * Edit user
     * @param int user id
     * @return view
     */
    public function editUser( User $entry )
    {
        $this->checkPermission( 'edit.users' );

        /**
         * If the user who attempt to edit is the currently logged user.
         * We should redirect him to his profile
         * where he can't edit his role
         */
        if ( Auth::id() == $entry->id ) {
            return redirect()->route( 'dashboard.users.profile' );
        }

        $this->setTitle( __( 'Create a user' ) );
        return view( 'components.backend.dashboard.edit-user' );
    }
    
    
    /**
     * Show current logged user profile
     * @param void
     * @return view
     */
    public function showProfile( $tab = 'general' )
    {
        $this->checkPermission( 'read.profile' );
        $this->setTitle( __( 'My Profile' ) );
        return view( 'components.backend.dashboard.user', compact( 'tab' ) );
    }

    /**
     * Post user profile
     * @return void
     */
    public function postUserProfile( UserProfileRequest $request ) 
    {
        /**
         * Check permission for editing profile
         */
        $this->checkPermission( 'update.profile' );

        /**
         * excluse unused fields
         */
        $inputs     =   $request->except([ '_token', '_route', '_radio', '_checkbox', '_previous' ]);
        /**
         * If the field is defined as a radio or  checkbox field, then
         * it's deleted from the db to define new options. 
         * This is performed specially in case where the user 
         * disable a switch field or checkbox
         */

        // deleting _checkbox field
        foreach( ( array )  $request->input( '_checkbox' ) as $key ) {
            if ( in_array( $key, ( array ) $request->input( '_radio' ) ) || in_array( $key, ( array ) $request->input( '_checkbox' ) ) ) {
                $this->userOptions->delete( $key );
            }
        }

        // deleting _radio field
        foreach( ( array ) $request->input( '_radio' ) as $key ) {
            if ( in_array( $key, ( array ) $request->input( '_radio' ) ) ) {
                $this->userOptions->delete( $key );
            }
        }

        /**
         * Loop options and saved it
         * to the option table
         */
        foreach ( $inputs as $key => $value ) {
            /**
             * Saving/updating new value to the database
             */
            if ( ! is_array( $value ) ) {
                $this->userOptions->set( $key, $value );
            } else {
                $this->userOptions->set( $key, $value, true ); // set as array
            }
        }

        $response   =   [
            'status'    =>  'success',
            'message'   =>  __( 'The options has been saved.' )
        ];
        
        /**
         * Redirect to previous route
         */
        if ( $request->ajax() ) {
            return $response;
        } else {
            return redirect( $request->input( '_previous' ) )
                ->with( $response );
        }
    }
}
