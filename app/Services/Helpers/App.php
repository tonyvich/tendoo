<?php
namespace App\Services\Helpers;

use Jackiedo\DotenvEditor\Facades\DotenvEditor;

trait App {
    /**
     * Is installed
     * @return boolean
     */
    static function AppIsInstalled()
    {
        return DotenvEditor::keyExists( 'TENDOO_VERSION' );
    }

    /**
     * Push Validation Rules to options key on config tendoo.validations.options
     * @param array of validation rule
     * @return void
     */
    static function PushValidationRule( $rules, $namespace = 'options' )
    {
        $validation     =   config( 'tendoo.validations.' . $namespace );
        $newValidation  =   array_merge( $validation, $rules );
        config([ 'tendoo.validations.' . $namespace => $newValidation ]);
    }
}