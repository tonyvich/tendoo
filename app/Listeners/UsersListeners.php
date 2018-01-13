<?php

namespace App\Listeners;

use App\Event\ShowingErrors;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
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
        $events->listen( 'before.deleting.crud', 'App\Listeners\UsersListeners@defineCrud' );
        $events->listen( 'before.loading.crud', 'App\Listeners\UsersListeners@defineCrud' );
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
                'fields'    =>  function( $user = null ) use ( $fields ) {
                    return $fields->createUserFields( $user );
                },
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
                'beforeDelete'  =>  function( $namespace, $id ) {
                    if ( $namespace == 'system.users' ) {
                        /**
                         * @todo we might check if the user has the right to delete
                         * 
                         */
                        if ( Auth::id() === ( int ) $id ) {
                            return response([
                                'status'    =>  'danger',
                                'message'   =>  __( 'You can\'t delete your own account' )
                            ], 403 );
                        }
                    }
                },
                'route'     =>  'dashboard.users.list',
                'title'         =>  __( 'Users' ),
                'description'   =>  __( 'List all users with their roles' ),
                'namespace'     =>  'system.users',
                'columns'       =>  [
                    'username'  =>  [
                        'text'  =>  __( 'Username' )
                    ],
                    'email'  =>  [
                        'text'  =>  __( 'Email' )
                    ],
                    'role.name'  =>  [
                        'text'  =>  __( 'Role' )
                    ],
                    'created_at'  =>  [
                        'text'  =>  __( 'Member Since' )
                    ],
                    'active'    =>  [
                        'text'  =>  __( 'Active' ),
                        'filter'    =>  function( $value ) {
                            if ( $value ) {
                                return __( 'Active' );
                            }
                            return __( 'Unactive' );
                        }
                    ]
                ],
                'actions'      =>   [
                    'edit'      =>  function( $user ) {
                        if ( Auth::id() == $user->id ) {
                            return [
                                'text'  =>  __( 'My Profile' ),
                                'url'   =>  url()->route( 'dashboard.users.profile' )
                            ];
                        } else {
                            return [
                                'text'  =>  __( 'Edit' ),
                                'url'   =>  url()->route( 'dashboard.users.edit', [ 'id' => $user->id ] )
                            ];
                        }
                    },
                    'delete'    =>  function( $user ) {
                        if ( Auth::id() != $user->id ) {
                            return [
                                'type'  =>  'DELETE',
                                    'url'   =>  url()->route( 'dashboard.crud.delete', [ 
                                    'id'            =>  $user->id,
                                    'namespace'     =>  'system.users'
                                ]),
                                'text'  =>  __( 'Delete' )
                            ];
                        }
                        return false;
                    }
                ],

                'links'        =>   [
                    [
                        'href'  =>  route( 'dashboard.users.create' ),
                        'text'  =>  __( 'Add new user' )
                    ]
                ]
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
