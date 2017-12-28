<?php
namespace App\Services;

use App\Services\Fields\SetupFields;
class Field
{
    use SetupFields;

    /**
     * Build Self for validation
     * Accept Trait method name which must return an array of fields
     * @return array
     */
    static function buildValidation( string $method )
    {
        $fields     =   self::$method();
        $validation     =   [];
        if( $fields ) {
            foreach( self::$method() as $field ) {
                $validation[ $field->name ]     =   $field->validation;
            }
        }

        return $validation;
    }
}