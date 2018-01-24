<?php
namespace Modules\EnvatoChecker\Events;

// use App\Services\Menus;
// use App\Services\Helper;

/**
 * Register Events
**/
class EnvatoCheckerEvent
{
    public function __construct( Menus $menus )
    {
        $this->menus    =   $menus;
    }
}