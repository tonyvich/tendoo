<?php
/**
 * Options request retreive field definition according to routes and 
 * register validation rules
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Event;

class OptionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * Options validation rules can be registered using the 
         * App\Service\Helper::(trait)PushValidationRule method
         */
        Event::Fire( 'before.validatingOptions', $this );

        /**
         * Define default validation rules
         */
        config([ 'tendoo.validations.options' => [
            'app_name'  =>  'sometimes|required'
        ]]);

        return config( 'tendoo.validations.options' );
    }
}
