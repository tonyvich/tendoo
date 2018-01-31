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
        $settings->label        =   10;
        $settings->namespace    =   'settings';
        $settings->icon         =   'settings';

        $users                  =   new \stdClass;
        $users->text            =   __( 'Users' );
        $users->href            =   route( 'dashboard.users.list' );
        $users->label           =   10;
        $users->namespace       =   'users';
        $users->icon            =   'people';

        $this->menus            =   $menus;
        $this->menus->add( $dashboard );
        $this->menus->add( $modules );
        $this->menus->add( $settings );
        $this->menus->add( $users );

        $subSecurity                  =   new \stdClass;
        $subSecurity->text            =   __( 'Sub Security' );
        $subSecurity->href            =   'something';
        $subSecurity->label           =   10;
        $subSecurity->namespace       =   'sub';

        $this->menus->addTo( 'security', $subSecurity );

        $generalSettings               =   new \stdClass;
        $generalSettings->text         =   __( 'General' );
        $generalSettings->href         =   route( 'dashboard.settings', [
            'tab'   =>  'general'
        ]);
        $generalSettings->label        =   10;
        $generalSettings->namespace    =   'settings.general';

        $registration                   =   new \stdClass;
        $registration->text             =   __( 'Registration' );
        $registration->href             =   route( 'dashboard.settings', [
            'tab'   =>  'registration'
        ]);

        $registration->label            =   0;
        $registration->namespace        =   'settings.registration';

        $this->menus->addTo( 'settings', [ $generalSettings, $registration ]);
    }
}