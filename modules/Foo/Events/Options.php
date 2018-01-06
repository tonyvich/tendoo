<?php
namespace Modules\Foo\Events;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\Helper;

class Options 
{
    /**
     * Before Option Validation
     */
    public function validationRule( $request ) 
    {
        $inputs     =   $request->except([ '_token' ]);
        if ( Helper::RefererRouteIs( 'dashboard.settings.nexopos.general' ) ) {
            Helper::PushValidationRule([
                'test_field'  =>  'required|min:20',
                'textarea'  =>  'required|email'
            ]);
        }
    }
}