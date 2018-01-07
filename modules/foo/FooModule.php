<?php
namespace Modules\Foo;

use Illuminate\Support\Facades\Event;
use App\Services\TendooModule;

class FooModule extends TendooModule
{
    public function __construct()
    {
        parent::__construct( __FILE__ );

        Event::listen( 'dashboard.loaded', 'Modules\Foo\Events\DashboardLoaded@registerMenus' );
        Event::listen( 'before.validatingOptions', 'Modules\Foo\Events\Options@validationRule' );
        Event::listen( 'before.loadingApi', function( $resource ) {
            if ( $resource == 'users' ) {
                $stdClass           =   new \stdClass;
                $stdClass->model    =   'App\Models\User';
                return $stdClass;
            }
        });
    }
}