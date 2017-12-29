<?php
namespace Modules\Foo\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\DashboardController;

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
}
