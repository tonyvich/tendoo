<?php
namespace App\Services;

use App\Services\Fields\SetupFields;
use App\Services\Fields\AuthFields;
use App\Services\Fields\GeneralSettingsFields;
class Field
{
    use SetupFields,
        AuthFields,
        GeneralSettingsFields;

    /**
     * Build Self for validation
     * Accept Trait method name which must return an array of fields
     * @return array
     */
    static function buildValidation( string $method )
    {
        $fields     =   self::$method();
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