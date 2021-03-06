<?php
namespace App\Services\Fields;

trait GeneralSettingsFields
{
    public static function generalSettings()
    {
        $options                    =   app()->make( 'App\Services\Options' );
        $app_name                   =   new \StdClass;
        $app_name->name             =   'app_name';
        $app_name->label            =   __( 'Application Name' );
        $app_name->type             =   'text';
        $app_name->description      =   __( 'This name will be used to identify the application.' );
        $app_name->placeholder      =   $app_name->label;
        $app_name->validation       =   'require|min:5';
        $app_name->value            =   $options->get( $app_name->name );

        $timezone                   =   new \StdClass;
        $timezone->name             =   'app_timezone';
        $timezone->label            =   __( 'TimeZone' );
        $timezone->type             =   'select';
        $timezone->description      =   __( 'This will see the default time used over the application.' );
        $timezone->options          =   generate_timezone_list();
        $timezone->value            =   $options->get( $timezone->name );

        return [ $app_name, $timezone ];
    }

    public static function registration()
    {
        $options    =   app()->make( 'App\Services\Options' );

        $open_registration                  =   new \StdClass;
        $open_registration->name            =   'open_registration';
        $open_registration->label           =   __( 'Open Registration' );
        $open_registration->type            =   'switch';
        $open_registration->value           =   $options->get( $open_registration->name );
        $open_registration->options         =   [
            'true'   =>  __( 'Allow registration' )
        ];
        $open_registration->description  =   __( 'Let anyone sees the registration page and register an account' );

        $validate_users                  =   new \StdClass;
        $validate_users->name            =   'validate_users';
        $validate_users->label           =   __( 'Validate Users' );
        $validate_users->type            =   'switch';
        $validate_users->value           =   $options->get( $validate_users->name );
        $validate_users->options         =   [
            'true'   =>  __( 'Set all users as active after registration' )
        ];
        $validate_users->description  =   __( 'Everytime a user will register, his account will be set as active immediately' );

        $register_as                    =   new \StdClass;
        $register_as->name              =   'register_as';
        $register_as->label             =   __( 'Register As' );
        $register_as->type             =   'select';
        $register_as->options           =   [];
        return [ $open_registration, $validate_users ];
    }
}