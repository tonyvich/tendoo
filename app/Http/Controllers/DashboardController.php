<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use App\Services\Page;
use App\Services\Options;
use App\Services\Modules;
use App\Services\Helper;
use App\Models\User;
use App\Http\Requests\OptionsRequest;
use App\Http\Requests\CrudPostRequest;
use App\Http\Requests\CrudPutRequest;

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
        Event::fire( 'before.enabling.module', $namespace );

        $result     =   $this->modules->enable( $namespace );

        if ( $result[ 'code' ] == 'module_enabled' ) {
            // when the module has been enabled
            Event::fire( 'after.enabling.module', $result[ 'module' ] );

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
        Event::fire( 'before.disabling.module', $namespace );

        $result     =   $this->modules->disable( $namespace );

        if ( $result[ 'code' ] == 'module_disabled' ) {
            // when the module has been enabled
            Event::fire( 'after.disabling.module', $result[ 'module' ] );

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
        Event::fire( 'before.uploading.module', $request );

        $result     =   $this->modules->upload( $request->file( 'module' ) );

        /**
         * Treat Response
         */
        switch ( $result[ 'code' ] ) {
            case 'invalid_module' :
                Event::fire( 'after.uploading.module', $result );
                return redirect()->route( 'dashboard.modules.list' )->with([
                    'status'    =>  'danger',
                    'message'   =>  __( 'The zip file is not a valid module.' )
                ]);
            break;
            case 'old_module' : 
                Event::fire( 'after.uploading.module', $result );
                return redirect()->route( 'dashboard.modules.list' )->with([
                    'status'    =>  'info',
                    /**
                     * @todo we might offer solution to overwrite existing module
                     */
                    'message'   =>  __( 'The similar module found is up-to-date. Please remove this module before proceeding' )
                ]);
            break;
            case 'valid_message':
                Event::fire( 'after.uploading.module', $result );
            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  __( 'the module has been installed.' )
            ]);
            break;
            default:
                Event::fire( 'after.uploading.module', $result );
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
        $entries        =   $model::paginate( 20 ); // this should be dynamic
        Page::setTitle( __( 'Users' ) );
        return view( 'components.backend.dashboard.users-list', compact( 'entries' ) );
    }

    /**
     * Create users
     * @param void
     * @return view
     */
    public function createUser()
    {
        $crud       =   [
            'namespace'     =>  'system.users'
        ];

        Page::setTitle( __( 'Create a user' ) );
        return view( 'components.backend.dashboard.create-user', compact( 'crud' ) );
    }

    /**
     * Edit user
     * @param int user id
     * @return view
     */
    public function editUser( User $entry )
    {
        /**
         * If the user who attempt to edit is the currently logged user.
         * We should redirect him to his profile
         * where he can't edit his role
         */
        if ( Auth::id() == $entry->id ) {
            return redirect()->route( 'dashboard.users.profile' );
        }

        Page::setTitle( __( 'Create a user' ) );
        return view( 'components.backend.dashboard.edit-user', [ 'namespace' => 'system.users' ]);
    }

    /**
     * CRUD delete we expect this request to be 
     * provided by an Ajax Request
     * @param void
     * @return view
     */
    public function crudDelete( $namespace, $id )
    {
        /**
         * Catch event before deleting user
         */
        $resource    =   Event::fire( 'before.deleting.crud', $namespace, $id );

        if ( empty( $resource ) ) {
            return response([
                'status'    =>  'danger',
                'message'   =>  __( 'The crud resource is either not handled by the system or by any installed module.' )
            ], 403 );
        }

        /**
         * Run the filter before deleting
         */
        if ( is_callable( $resource[ 'beforeDelete' ] ) ) {

            /**
             * the callback should return an empty value to proceed.
             */
            if( ! empty( $response = $resource[ 'beforeDelete' ]( $namespace, $id ) ) ) {
                return $response;
            }
        }

        /**
         * We'll retreive the model and delete it
         */
        $model          =   $resource[ 'model' ];
        $model::find( $id )->delete();

        $resource    =   Event::fire( 'after.deleting.crud', $namespace, $id );

        return [
            'status'    =>  'success',
            'message'   =>  __( 'The entry has been successfully delete.' )
        ];
    }

    /**
     * Show current logged user profile
     * @param void
     * @return view
     */
    public function showProfile()
    {
        
    }

    /**
     * Dashboard Crud POST
     * receive and treat POST request for CRUD Resource
     * @param void
     * @return void
     */
    public function crudPost( String $namespace, CrudPostRequest $request )
    {
        $response   =   Event::fire( 'before.posting.crud', $namespace );

        /**
         * In case nothing handle this crud
         */
        if ( empty( $response ) ) {
            return redirect()->route( 'errors', [ 'code' => 'unhandled-crud-resource' ]);
        }

        $resource   =   $response[0];
        $entry      =   new $resource[ 'model' ];

        foreach ( $request->all() as $name => $value ) {

            /**
             * If submitted field are part of fillable fields
             */
            if ( in_array( $name, $resource[ 'fillable' ] ) ) {

                /**
                 * We might give the capacity to filter fields 
                 * before storing. This can be used to apply specific formating to the field.
                 */
                if ( is_callable( @$resource[ 'filter' ] ) ) {
                    $filter     =   $resource[ 'filter' ];
                    $entry->$name   =   $filter( $name, $value );
                } else {
                    $entry->$name   =   $value;
                }
            }
        }

        $entry->save();

        /**
         * Once the request is done, 
         * we might redirect the user to the users list page
         */

        /**
         * @todo adding a link to edit the new entry
         */

        return redirect()->route( $resource[ 'route' ] )->with([
            'status'    =>  'success',
            'message'   =>  __( 'An new entry has been successfully created.' )
        ]);
    }

    /**
     * Dashbaord CRUD PUT
     * receive and treat a PUT request for CRUD resource
     * @param string resource namespace
     * @param int primary key
     * @param object request : CrudPutRequest
     * @return void
     */
    public function crudPut( String $namespace, $entry, CrudPutRequest $request ) 
    {
        /**
         * Trigger event before submitting put request for CRUD resource
         */
        $response   =   Event::fire( 'before.editing.crud', $namespace );

        /**
         * In case nothing handle this crud
         */
        if ( empty( $response ) ) {
            return redirect()->route( 'errors', [ 'code' => 'unhandled-crud-resource' ]);
        }

        $resource   =   $response[0];
        $entry      =   $resource[ 'model' ]::find( $entry );

        foreach ( $request->all() as $name => $value ) {

            /**
             * If submitted field are part of fillable fields
             */
            if ( in_array( $name, $resource[ 'fillable' ] ) ) {

                /**
                 * We might give the capacity to filter fields 
                 * before storing. This can be used to apply specific formating to the field.
                 */
                if ( is_callable( @$resource[ 'filter' ] ) ) {
                    $filter     =   $resource[ 'filter' ];
                    $entry->$name   =   $filter( $name, $value );
                } else {
                    $entry->$name   =   $value;
                }
            }
        }

        $entry->save();

        /**
         * Once the request is done, 
         * we might redirect the user to the users list page
         */

        /**
         * @todo adding a link to edit the new entry
         */

        return redirect()->route( $resource[ 'route' ] )->with([
            'status'    =>  'success',
            'message'   =>  __( 'An new entry has been successfully created.' )
        ]);
    }
}
