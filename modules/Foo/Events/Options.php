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
        if ( $request->input( '_route' ) == 'dashboard.settings.general' ) {
            // Helper::PushValidationRule([
            //     'app_name'  =>  'required'
            // ]);
        }
    }
}