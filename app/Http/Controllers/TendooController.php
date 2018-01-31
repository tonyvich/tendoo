<?php
namespace App\Http\Controllers;

use App\Services\Guard;
use App\Services\Helper;
use App\Services\Modules;
use App\Models\User;
use App\Services\Page;
use App\Services\Options;
use App\Services\UserOptions;
use App\Exceptions\AccessDeniedException;

use Illuminate\Support\Facades\Event;

class TendooController extends Controller
{
    protected $options;
    protected $userOptions;
    protected $modules;
    protected $menus;

    public function __construct()
    {
        /**
         * Redirect user if he's not authenticated
         */
        $this->middleware( 'expect.logged' );
        
        if ( Helper::AppIsInstalled() ) {
            $this->middleware( function( $request, $next ){

                /**
                 * Registering stuff from middleware
                 */
                $this->options      =   app()->make( 'App\Services\Options' );
                $this->userOptions  =   app()->make( 'App\Services\UserOptions' );
                $this->modules      =   app()->make( Modules::class );
                $this->menus        =   app()->make( 'App\Services\Dashboard\MenusConfig' );
                $this->guard        =   app()->make( Guard::class );
        
                Event::fire( 'dashboard.loaded' );

                return $next($request);
            });
        }
    }

    /**
     * Check permission
     */
    public function checkPermission( $permission )
    {
        if ( ! User::allowedTo( $permission ) ) {
            throw new AccessDeniedException( $permission );
        }
    }

    /**
     * set title
     * @param string page title
     */
    public function setTitle( $title )
    {
        Page::setTitle( $title );
    }
}