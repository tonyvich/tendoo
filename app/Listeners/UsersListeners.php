<?php

namespace App\Listeners;

use App\Event\ShowingErrors;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Field;
use App\Services\Helper;
use App\Models\User;

class UsersListeners
{
    /**
     * Subscribe to posting crud event to register a new user
     * @return array of crud objet
     */
    public function subscribe( $events )
    {
        $events->listen( 'before.validating.crud', 'App\Listeners\UsersListeners@postValidationRule' );
        $events->listen( 'before.posting.crud', 'App\Listeners\UsersListeners@defineCrud' );
        $events->listen( 'before.editing.crud', 'App\Listeners\UsersListeners@defineCrud' );
    }

    /**
     * Define CRUD
     * @return void
     */
    public function defineCrud( $namespace )
    {
        $fields     =   app()->make( 'App\Services\Field' );
        /**
         * If we're validating users
         */
        if ( $namespace == 'system.users' ) {
            return  [
                'fields'    =>  $fields->createUserFields(),
                'model'     =>  'App\Models\User',
                'fillable'  =>  [ 'username', 'email', 'password', 'role_id', 'active' ],
                'filter'    =>  function( $name, $value ) {
                    /**
                     * bcrypt the password
                     */
                    if ( $name == 'password' ) {
                        return bcrypt( $value );
                    }
                    return $value;
                },
                'route'     =>  'dashboard.users.list'
            ];
        }
    }

    /**
     * Register Validation Rule according to
     * available fields validation property.
     * @return void
     */
    public function postValidationRule( $request )
    {
        /**
         * If the current request process system.users namespace
         */

        $fields     =   app()->make( 'App\Services\Field' );

        /**
         * Retreive the user if here provided
         */
        $user       =   $request->route( 'id' ) ? User::find( $request->route( 'id' ) ) : false;

        if ( $request->route( 'namespace' ) == 'system.users' ) {

            /**
             * Use UserFieldsValidation and add assign it to "crud" validation array
             * the user object is send to perform validation and ignoring the current edited
             * user
             */
            Helper::UseFieldsValidation( $fields->createUserFields( $user ), 'crud' );
        }
    }
}
