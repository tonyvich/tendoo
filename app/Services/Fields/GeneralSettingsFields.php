<?php
namespace App\Services\Fields;

trait GeneralSettingsFields
{
    public static function generalSettings()
    {
        $appName                  =   new \StdClass;
        $appName->name            =   'app_name';
        $appName->label           =   __( 'Application Name' );
        $appName->type            =   'text';
        $appName->description     =   __( 'This name will be used to identify the application.' );
        $appName->placeholder     =   $appName->label;
        $appName->validation      =   'require|min:5';

        $timeZone                  =   new \StdClass;
        $timeZone->name            =   'app_timezone';
        $timeZone->label            =   __( 'TimeZone' );
        $timeZone->type            =   'select';
        $timeZone->description     =   __( 'This will see the default time used over the application.' );
        $timeZone->options         =   [
            'foo'   =>  'bar',
            'bar'   =>  'Foo'
        ];

        return [ $appName, $timeZone ];
    }
}