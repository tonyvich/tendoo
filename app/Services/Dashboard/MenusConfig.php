<?php
namespace App\Services\Dashboard;
use App\Services\Menus;

class MenusConfig 
{
    public function __construct( Menus $menus )
    {        
        $dashboard              =   new \stdClass;
        $dashboard->text        =   __( 'Dashboard' );
        $dashboard->href        =   url( '/dashboard' );
        $dashboard->label       =   10;
        $dashboard->namespace   =   'dashboard';
        $dashboard->icon        =   'dashboard';

        $modules                =   new \stdClass;
        $modules->text          =   __( 'Modules' );
        $modules->href          =   route( 'dashboard.modules.list' );
        $modules->label         =   10;
        $modules->namespace     =   'modules';
        $modules->icon          =   'input';

        $settings               =   new \stdClass;
        $settings->text         =   __( 'Settings' );
        $settings->href         =   route( 'dashboard.settings' );
        $settings->label        =   10;
        $settings->namespace    =   'settings';
        $settings->icon         =   'settings';

        $users                  =   new \stdClass;
        $users->text            =   __( 'Users' );
        $users->href            =   route( 'dashboard.users.list' );
        $users->label           =   10;
        $users->namespace       =   'users';
        $users->icon            =   'people';
        
        $security                  =   new \stdClass;
        $security->text            =   __( 'Security' );
        $security->href            =   route( 'dashboard.security' );
        $security->label           =   10;
        $security->namespace       =   'security';
        $security->icon            =   'security';

        $this->menus            =   $menus;
        $this->menus->add( $dashboard );
        $this->menus->add( $modules );
        $this->menus->add( $settings );
        $this->menus->add( $users );
    }
}