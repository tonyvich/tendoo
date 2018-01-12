<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Event;

class CrudPutRequest extends FormRequest
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
        Event::fire( 'before.validating.crud', $this );
                
        /**
         * Check if there is a reply to that Event
         */
        return config( 'tendoo.validations.crud', []);        
    }
}
