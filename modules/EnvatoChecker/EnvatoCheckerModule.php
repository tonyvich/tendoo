<?php
namespace Modules\EnvatoChecker;

use Illuminate\Support\Facades\Event;
use App\Services\TendooModule;

class EnvatoCheckerModule extends TendooModule
{
    public function __construct()
    {
        parent::__construct( __FILE__ );

        /**
         * Register Menus
        **/
        // Event::listen( 'dashboard.loaded', 'Modules\EnvatoChecker\Events\EnvatoCheckerEvents@menus' );
    }
}