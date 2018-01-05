<?php
namespace Modules\Foo\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\DashboardController;
use App\Services\Page;
use Modules\Foo\Fields\DashboardFields;

class FooController extends DashboardController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return View::make( 'Foo::index' );
    }

    public function go()
    {
        return view( 'Foo::go' );
    }

    public function bar()
    {
        return view( 'Foo::bar' );
    }

    public function settings()
    {
        Page::setTitle( __( 'NexoPOS Settings' ) );
        return view( 'Foo::settings' );
    }

    /**
     * general settings
     * @param void
     */
    public function generalSettings()
    {
        Page::setTitle( __( 'NexoPOS Settings' ) );
        return view( 'Foo::settings' );
    }
}
