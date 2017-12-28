<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Page;
use App\Services\Dashboard\MenusConfig;

class DashboardController extends Controller
{
    public function __construct( MenusConfig $menus )
    {
        
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
}
