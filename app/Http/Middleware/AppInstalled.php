<?php

namespace App\Http\Middleware;

use Closure;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class AppInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! DotenvEditor::keyExists( 'TENDOO_VERSION' ) ) {
            return redirect()->route( 'setup.step' );
        }
        return $next($request);
    }
}
