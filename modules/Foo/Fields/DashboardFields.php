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

        $textarea               =   new \stdClass;
        $textarea->name         =   'textarea';
        $textarea->label        =   __( 'Text Area' );
        $textarea->type         =   'textarea';
        $textarea->placeholder  =   __( 'This is my test areas' );
        $textarea->value        =   $options->get( 'textarea' );

        return [ $text, $textarea ];
    }
}