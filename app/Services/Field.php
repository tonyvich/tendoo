<?php
namespace App\Services;

use App\Services\Fields\SetupFields;
use App\Services\Fields\AuthFields;
use App\Services\Fields\GeneralSettingsFields;
use App\Services\Fields\UsersFields;
use App\Services\Fields\ProfileFields;

class Field
{
    use SetupFields,
        AuthFields,
        GeneralSettingsFields,
        UsersFields,
        ProfileFields;

    /**
     * Build Self for validation
     * Accept Trait method name which must return an array of fields
     * @return array
     */
    static function buildValidation( $method )
    {
        /**
         * check if we're submitting various field methods
         */
        if ( is_array( $method ) ) {
            $final      =   [];

            /**
             * Lopping all methods to build the validation array
             */
            foreach ( $method as $_method ) {
                if ( $validation =  self::buildValidation( $_method ) ) {
                    $final    =   array_merge( $final, $validation );
                }
            }

            return $final;
        } else {

            /**
             * We're here dealing with string only
             */
            $fields         =   self::$method();
            $validation     =   [];
            if ( $fields ) {
                foreach( self::$method() as $field ) {
                    // if field provide validation
                    if ( @$field->validation ) {
                        $validation[ $field->name ]     =   $field->validation;
                    }
                }
            }
    
            return $validation;
        }
    }

    /**
     * Get Fields
     * @param string Class Name
     * @return void
     */
    static function get( string $className, $method )
    {
        return app()->make( $className )->$method();
    }
}