<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Event;
use App\Services\Field;

class UserProfileRequest extends FormRequest
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
        Event::Fire( 'before.validating.user-profile', $this );

        /**
         * implemented to support multiple field on differents tabs
         */
        return Field::buildValidation([ 'userSecurityFields', 'userGeneralFields' ]);
    }
}
