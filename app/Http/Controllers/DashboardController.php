<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Page;
use App\Services\Options;
use App\Services\Modules;
use Illuminate\Support\Facades\Event;
use App\Services\Helper;
use App\Http\Requests\OptionsRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        /**
         * Redirect user if he's not authenticated
         */
        $this->middleware( 'expect.logged' );
        
        if ( Helper::AppIsInstalled() ) {
            $this->options  =   app()->make( 'App\Services\Options' );
            $this->modules  =   app()->make( 'App\Services\Modules' );
            $this->menus    =   app()->make( 'App\Services\Dashboard\MenusConfig' );
    
            Event::fire( 'dashboard.loaded' );
        }
    }

    /** 
     * Dashboard index
     * @since 1.0
     */
    public function index()
    {
        Page::setTitle( __( 'Dashboard Index' ) );
        return view( 'components.backend.dashboard.index' );
    }

    /**
     * Module List
     * @return view
     */
    public function modulesList()
    {
        Page::setTitle( __( 'Modules' ) );
        return view( 'components.backend.dashboard.modules' );
    }

    /**
     * Enable module
     * @param string module namespace
     * @return void
     */
    public function enableModule( $namespace )
    {
        // @todo check if the user has the right to perform this action.
        Event::fire( 'before.enablingModule', $namespace );

        $result     =   $this->modules->enable( $namespace );

        if ( $result[ 'code' ] == 'module_enabled' ) {
            // when the module has been enabled
            Event::fire( 'after.enablingModule', $result[ 'module' ] );

            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  sprintf( __( 'The module <strong>%s</strong> has been enabled' ), $result[ 'module' ][ 'name' ] )
            ]);
        }

        return redirect()->route( 'dashboard.modules.list' )->with([
            'status'    =>  'warning',
            'message'   =>  __( 'Unable to locate the module.' )
        ]);
    }

    /**
     * Disable Module
     * @param string module namespace
     * @return void
     */
    public function disableModule( $namespace )
    {
        // @todo check if the user has the right to perform this action.
        Event::fire( 'before.disablingModule', $namespace );

        $result     =   $this->modules->disable( $namespace );

        if ( $result[ 'code' ] == 'module_disabled' ) {
            // when the module has been enabled
            Event::fire( 'after.disablingModule', $result[ 'module' ] );

            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  sprintf( __( 'The module <strong>%s</strong> has been disabled' ), $result[ 'module' ][ 'name' ] )
            ]);
        }

        return redirect()->route( 'dashboard.modules.list' )->with([
            'status'    =>  'warning',
            'message'   =>  __( 'Unable to locate the module.' )
        ]);
    }

    /**
     * Extract module
     * @param string module namespace
     * @return void
     */
    public function extractModule( $module )
    {
        $moduleDetails     =   $this->modules->extract( $module );
        
        return response()->download( 
            $moduleDetails[ 'path' ], 
            strtolower( $moduleDetails[ 'module' ][ 'namespace' ] ) . '-' . $moduleDetails[ 'module' ][ 'version' ] . '.zip' 
        )->deleteFileAfterSend( true );
    }

    /**
     * Upload Module
     * @param void
     * @return string view
     */
    public function uploadModule()
    {
        Page::setTitle( __( 'Upload Module' ) );
        return view( 'components.backend.dashboard.upload-module' );
    }

    /**
     * Method to post a module
     * @param Request
     * @return void
     */
    public function postModule( Request $request )
    {
        Event::fire( 'before.uploadModule', $request );

        $result     =   $this->modules->upload( $request->file( 'module' ) );

        /**
         * Treat Response
         */
        switch ( $result[ 'code' ] ) {
            case 'invalid_module' :
                return redirect()->route( 'dashboard.modules.list' )->with([
                    'status'    =>  'danger',
                    'message'   =>  __( 'The zip file is not a valid module.' )
                ]);
            break;
            case 'old_module' : 
                return redirect()->route( 'dashboard.modules.list' )->with([
                    'status'    =>  'info',
                    /**
                     * @todo we might offer solution to overwrite existing module
                     */
                    'message'   =>  __( 'The similar module found is up-to-date. Please remove this module before proceeding' )
                ]);
            break;
            case 'valid_message':
            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  __( 'the module has been installed.' )
            ]);
            break;
            default:
                return redirect()->route( 'dashboard.modules.list' )->with([
                    'status'    =>  'info',
                    'message'   =>  __( 'An unexpected error occured.' )
                ]);
            break;
        }
    }

    /**
     * Delete Module
     */
    public function deleteModule( $namespace )
    {
        /**
         * @todo check if the user can delete a module
         */
        Event::fire( 'before.deletingModule', $namespace );

        $result     =   $this->modules->delete( $namespace );

        if ( $result[ 'code' ] == 'module_deleted' ) {
            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  sprintf( __( 'The module <strong>%s</strong> has been deleted.' ), $result[ 'module' ][ 'name' ] )
            ]);
        }

        return redirect()->route( 'dashboard.modules.list' )->with([
            'status'    =>  'danger',
            'message'   =>  __( 'unable to locate the module.' )
        ]);
    }

    /**
     * Dashboard Settings
     * @return view
     */
    public function generalSettings()
    {
        Page::setTitle( __( 'General Settings' ) );
        return view( 'components.backend.dashboard.general-settings' );
    }

    /**
     * Post Options
     * receive and treat options send
     * @param void
     * @return void
     */
    public function postOptions( OptionsRequest $request )
    {
        $inputs     =   $request->except([ '_token', '_route', '_radio', '_checkbox' ]);
        /**
         * If the field is defined as a radio or  checkbox field, then
         * it's deleted from the db to define new options. 
         * This is performed specially in case where the user 
         * disable a switch field or checkbox
         */

        // deleting _checkbox field
        foreach( ( array )  $request->input( '_checkbox' ) as $key ) {
            if ( in_array( $key, ( array ) $request->input( '_radio' ) ) || in_array( $key, ( array ) $request->input( '_checkbox' ) ) ) {
                $this->options->delete( $key );
            }
        }

        // deleting _radio field
        foreach( ( array ) $request->input( '_radio' ) as $key ) {
            if ( in_array( $key, ( array ) $request->input( '_radio' ) ) ) {
                $this->options->delete( $key );
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
                $this->options->set( $key, $value );
            } else {
                $this->options->set( $key, $value, true ); // set as array
            }
        }

        /**
         * Redirect to previous route
         */
        return redirect()->route( $request->input( '_route' ) )->with([
            'status'    =>  'success',
            'message'   =>  __( 'The options has been saved.' )
        ]);
    }

    /**
     * Refresh Installation
     * Pull content from github
     * @return view
     */
    public function update()
    {
        Page::setTitle( __( 'Update Tendoo CMS' ) );
        return view( 'components.backend.dashboard.update' );
    }

    /**
     * User List
     * display available users
     * @return view of users
     */
    public function usersList()
    {
        $model          =   'App\Models\User';
        $entries        =   $model::all();

        $resource       =   'users';
        $columns        =   [
            [ 'name'    =>  'username',     'text'  =>  __( 'User Name' ) ],
            [ 'name'    =>  'email',        'text'  =>  __( 'Email' ) ],
            [ 'name'    =>  'role',         'text'  =>  __( 'Role' ) ],
            [ 'name'    =>  'created_at',   'text'  =>  __( 'Created At' ) ],
            [ 'name'    =>  'active',       'text'  =>  __( 'Active' ) ]
        ];

        $actions        =   [
            'edit'      =>  function( $user ) {
                return [
                    'text'  =>  __( 'Edit' ),
                    'url'   =>  url()->route( 'dashboard.users.edit', [ 'id' => $user->id ] )
                ];
            },
            'delete'    =>  function( $user ) {
                return [
                    'type'  =>  'DELETE',
                    'url'   =>  url()->route( 'dashboard.users.delete', [ 'id' => $user->id ]),
                    'text'  =>  __( 'Delete' )
                ];
            }
        ];

        Page::setTitle( __( 'Users' ) );
        return view( 'components.backend.dashboard.users-list', compact( 'columns', 'actions', 'resource' ) );
    }
}
