<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Page;
use App\Http\Requests\SetupDatabaseRequest;
use App\Http\Requests\SetupAppDetailsRequest;

class SetupController extends Controller
{
    public function __construct() 
    {
    }

    /**
     * Display setup steps
     * @return void
     */
    public function steps( string $step = '' )
    {
        if ( $step == '' ) {
            Page::setTitle( 'FooBar' );
            return view( 'components.frontend.setup.step-home' );
        } else if ( $step == 'database' ) {
            Page::setTitle( __( 'Database Configuration' ) );
            return view( 'components.frontend.setup.step-database' );
        } else if ( $step == 'app-details' ) {
            Page::setTitle( __( 'Database Configuration' ) );
            return view( 'components.frontend.setup.step-app-details' );
        }
    }

    /**
     * Post Database details
     * @since 1.0
     */
    public function post_database( SetupDatabaseRequest $Request )
    {

    }

    /**
     * Post App details
     * @since 1.0
     */
    public function post_appdetails( SetupAppDetailsRequest $Request )
    {

    }
}
