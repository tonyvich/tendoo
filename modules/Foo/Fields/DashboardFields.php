<?php
namespace Modules\Foo\Fields;

class DashboardFields
{
    /**
     * General Settings
     * @return array of object<fields>
     */
    public function generalSettings()
    {
        $options            =   app()->make( 'App\Services\Options' );
        $text               =   new \stdClass;
        $text->name         =   'test_field';
        $text->label        =   __( 'Some Text' );
        $text->type         =   'text';
        $text->placeholder  =   __( 'Some Text' );
        $text->value        =   $options->get( 'test_field' );

        return [ $text ];
    }
}