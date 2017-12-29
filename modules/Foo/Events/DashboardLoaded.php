<?php
namespace Modules\Foo\Events;
use App\Services\Menus;

class DashboardLoaded
{
    public function __construct( Menus $menus )
    {
        $this->menus    =   $menus;
    }

    /**
     * Register Menus
     * @return menus
     */
    public function registerMenus()
    {
        $Foo                =   new \StdClass;
        $Foo->namespace     =   'foo';
        $Foo->text          =   __( 'Foo' );
        $Foo->href          =   route( 'dashboard.foo.index');
        $Foo->icon          =   'build';

        $Bar                =   new \StdClass;
        $Bar->namespace     =   'bar';
        $Bar->text          =   __( 'Bar' );
        $Bar->href          =   route( 'dashboard.bar.index');
        $Bar->icon          =   'build';

        $this->menus->addAfter( 'dashboard', $Foo );
        $this->menus->addAfter( 'foo', $Bar );
    }
}