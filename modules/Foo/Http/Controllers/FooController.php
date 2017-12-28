<?php
namespace Modules\Foo\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ModulesController;

class FooController extends ModulesController
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
}
