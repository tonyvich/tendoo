<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Page;
use Illuminate\Support\Facades\Event;

class DashboardController extends Controller
{
    public function __construct()
    {
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
}
