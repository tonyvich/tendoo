<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Page;
use App\Services\Options;
use App\Services\Modules;
use Illuminate\Support\Facades\Event;

class DashboardController extends Controller
{
    public function __construct(
        Options $options,
        Modules $modules
    )
    {
        /**
         * Redirect user if he's not authenticated
         */
        $this->middleware( 'expect.logged' );
        
        $this->options  =   $options;
        $this->modules  =   $modules;
        $this->menus    =   app()->make( 'App\Services\Dashboard\MenusConfig' );
        Event::fire( 'dashboard.loaded' );
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
     * @return void
     */
    public function enableModule( $namespace )
    {
        // @todo check if the user has the right to perform this action.
        Event::fire( 'before.enablingModule', $namespace );
        
        // check if module exists
        if ( $module = $this->modules->get( $namespace ) ) {
            // @todo sandbox to test if the module runs
            $enabledModules     =   ( array ) json_decode( $this->options->get( 'enabled_modules' ), true );

            // make sure to enable only once
            if ( ! in_array( $namespace, $enabledModules ) ) {
                $enabledModules[]   =   $namespace;
                $this->options->set( 'enabled_modules', json_encode( $enabledModules ) );
            }

            // when the module has been enabled
            Event::fire( 'after.enablingModule', $module );

            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  sprintf( __( 'The module %s has been enabled' ), $module[ 'name' ] )
            ]);
        }

        return redirect()->route( 'dashboard.modules.list' )->with([
            'status'    =>  'warning',
            'message'   =>  __( 'Unable to locate the module.' )
        ]);
    }

    /**
     * Disable Module
     * @return void
     */
    public function disableModule( $namespace )
    {
        // @todo check if the user has the right to perform this action.
        Event::fire( 'before.disablingModule', $namespace );

        // check if module exists
        if ( $module = $this->modules->get( $namespace ) ) {
            // @todo sandbox to test if the module runs
            $enabledModules     =   ( array ) json_decode( $this->options->get( 'enabled_modules' ), true );
            $indexToRemove      =   array_search( $namespace, $enabledModules );

            // if module is found
            if ( $indexToRemove !== false ) {
                unset( $enabledModules[ $indexToRemove ] );
            }

            $this->options->set( 'enabled_modules', json_encode( $enabledModules ) );

            // when the module has been enabled
            Event::fire( 'after.disablingModule', $module );

            return redirect()->route( 'dashboard.modules.list' )->with([
                'status'    =>  'success',
                'message'   =>  sprintf( __( 'The module %s has been disabled' ), $module[ 'name' ] )
            ]);
        }

        return redirect()->route( 'dashboard.modules.list' )->with([
            'status'    =>  'warning',
            'message'   =>  __( 'Unable to locate the module.' )
        ]);
    }
}
