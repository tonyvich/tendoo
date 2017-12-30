<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Services\Page;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    /**
     * Login Controller
     * @return view
     */
    public function loginIndex()
    {
        Page::setTitle( __( 'Login' ) );
        return view( 'components.frontend.auth.login' );
    }

    /**
     * Register Controller
     * @return view
     */
    public function registerIndex()
    {
        Page::setTitle( __( 'Registration' ) );
        return view( 'components.frontend.auth.register' );
    }

    /**
     * Post Login
     * Authenticate user and redirect
     * @return void
     */
    public function postLogin( LoginRequest $request )
    {
        /**
         * Event: before.login
         * @since 1.0
         */
        Event::fire( 'before.login' );

        if ( Auth::attempt([
            'name'      => $request->input( 'username' ), 
            'password'  => $request->input( 'password' ),
            'active'    =>  true 
        ], $request->input( 'remember_me' ) ? true : false ) ) {
            
            /**
             * We might perform an action before login
             */
            Event::fire( 'after.login' );

            /**
             * Redirect user to the dashboard
             */
            return redirect()->intended( route( config( 'tendoo.redirect.authenticated' ) ) );
        }

        return redirect()->route( 'login.index' )->withErrors([
            'status'    =>  'danger',
            'message'   =>  __( 'Wrong username or password.' )
        ]);
    }

    /**
     * Logout user
     * @return void
     */
    public function logoutIndex()
    {
        Event::fire( 'before.logout' );
        Auth::logout();
        return redirect()->route( config( 'tendoo.redirect.not-authenticated' ) );
    }
}
