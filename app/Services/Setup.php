<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use RoleManager;
use App\Models\User;
use App\Services\Options;

class Setup
{
    /**
     * Attempt database and save db informations
     * @return void
     */
    public function saveDatabaseSettings( Request $request )
    {
        config([ 'database.connections.mysql' => [
            'driver'         =>      'mysql',
            'host'           =>      $request->input( 'hostname' ),
            'port'           =>      env('DB_PORT', '3306'),
            'database'       =>      $request->input( 'db_name' ),
            'username'       =>      $request->input( 'username' ),
            'password'       =>      $request->input( 'password' ),
            'unix_socket'    =>      env('DB_SOCKET', ''),
            'charset'        =>      'utf8',
            'collation'      =>      'utf8_unicode_ci',
            'prefix'         =>      $request->input( 'dbprefix' ),
            'strict'         =>      true,
            'engine'         =>      null,
        ]]);

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {

            switch( $e->getCode() ) {
                case 2002   :   
                    $message =  [
                        'name'              =>   'hostname',
                        'error'             =>  'unableToReachHost',
                        'message'           =>  __( 'Unable to reach the host' ),
                        'status'            =>  'failed'
                    ]; 
                break;
                case 1045   :   
                    $message =  [
                        'name'              =>   'username',
                        'error'             =>   'wrongUserCredentials',
                        'message'           =>  __( 'Wrong user credentials.' ),
                        'status'            =>  'failed'
                    ];
                break;
                case 1049   :   
                    $message =  [
                         'name'        => 'db_name',
                         'error'         =>  'unableToSelectDb',
                         'message'      =>  __( 'Unable to select the database.' ),
                         'status'       =>  'failed'
                    ];
                break;
                case 1044   :   
                $message =  [
                        'name'        => 'username',
                        'error'         =>  'accessDenied',
                        'message'      =>  __( 'Access denied for this user.' ),
                        'status'       =>  'failed'
                    ];
                break;
                default     :   
                    $message =  [
                         'name'        => 'hostname',
                         'error'         => 'unexpectedError',
                         'message'      =>  sprintf( __( 'Unexpected error occured. :%s' ), $e->getCode() ),
                         'status'       =>  'failed'
                    ]; 
                break;
            }

            return $message;
        }

        DotEnvEditor::setKey( 'DB_HOST', $request->input( 'hostname' ) );
        DotEnvEditor::setKey( 'DB_DATABASE', $request->input( 'db_name' ) );
        DotEnvEditor::setKey( 'DB_USERNAME', $request->input( 'username' ) );
        DotEnvEditor::setKey( 'DB_PASSWORD', $request->input( 'password' ) );
        DotEnvEditor::setKey( 'DB_PREFIX', $request->input( 'table_prefix' ) );
        DotEnvEditor::setKey( 'DB_PORT', 3306 );
        DotEnvEditor::setKey( 'DB_CONNECTION', 'mysql' );
        DotenvEditor::save();

        return true;
        
    }

    /**
     * Run migration
     * @param Http Request
     * @return void
     */
    public function runMigration( Request $request )
    {
        /**
         * We assume so far the application is installed
         * then we can launch option service
         */
        
        $this->options  =   app()->make( 'App\Services\Options' );

        Artisan::call( 'migrate:fresh' );
        
        RoleManager::allow( 'master' )->to( 'manage.modules' );
        RoleManager::allow( 'master' )->to( 'manage.users' );
        RoleManager::allow( 'master' )->to( 'manage.settings' );
        
        RoleManager::allow( 'admin' )->to( 'manage.settings' );
        RoleManager::allow( 'admin' )->to( 'manage.users' );

        $user               =   new User;
        $user->name         =   $request->input( 'username' );
        $user->password     =   bcrypt( $request->input( 'password' ) );
        $user->email        =   $request->input( 'email' );
        $user->active       =   true; // first user active by default;
        $user->save();

        RoleManager::assign( 'master' )->to( $user );

        $this->options->set( 'app_name', $request->input( 'app_name' ) );

        DotenvEditor::setKey( 'TENDOO_VERSION', config( 'tendoo.version' ) );
        DotenvEditor::save();
    }
}