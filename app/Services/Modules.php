<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use XmlParser;
class Modules 
{
    private $modules    =   [];
    /**
     * Load Modules
     * @return void
     */
    public function load()
    {
        // get all modules folders
        $directories  =   Storage::disk( 'modules' )->directories();

        // get directories
        foreach( $directories as $dir ) {
            
            /**
             * Loading files from module directory
             */
            $files  =   Storage::disk( 'modules' )->files( $dir );

            // check if a config file exists
            if ( in_array( $dir . '/config.xml', $files ) ) {

                $xml        =   XmlParser::load( dirname( __FILE__ ) . '/../../modules/foo/config.xml' );
                $config     =   $xml->parse([
                    'namespace'             => [ 'uses'     => 'namespace' ],
                    // 'language'           =>  [ 'uses'    => 'language' ], 
                    'version'               =>  [ 'uses'    => 'version' ],
                    'author'                =>  [ 'uses'    => 'author' ],
                    'description'           =>  [ 'uses'    => 'description' ],
                    'dependencies'          =>  [ 'uses'    =>  'dependencies' ],
                ]);

                $config[ 'files' ]          =   $files;

                // If a module has at least a namespace
                if ( $config[ 'namespace' ] != null ) {
                    // index path
                    $moduleBasePath     =   config( 'tendoo.modules_path' ) . '\\' . $dir . '\\';
                    $indexPath          =   $moduleBasePath . ucwords( $config[ 'namespace' ] . 'Module.php' );
                    $webRoutesPath      =   $moduleBasePath . 'Routes\web.php';
                    
                    // check index existence
                    $config[ 'index-file' ]                 =   is_file( $indexPath ) ? $indexPath : false;
                    $config[ 'routes-file' ]                =   is_file( $webRoutesPath ) ? $webRoutesPath : false;
                    $config[ 'controllers-path' ]           =   $moduleBasePath . 'Http\Controllers';
                    $config[ 'controllers-relativePath' ]   =   ucwords( $config[ 'namespace' ] ) . '\Http\Controllers';
                    $config[ 'views-path' ]                 =   $moduleBasePath . 'Resources\Views\\';
                    $config[ 'dashboard-path' ]             =   $moduleBasePath . 'Dashboard\\';
                    
                    /**
                     * Defining Entry Class
                     * Entry class must be namespaced like so : 'Modules\[namespace]\[namespace] . 'Module';
                     */
                    $config[ 'entry-class' ]    =  'Modules\\' . $config[ 'namespace' ] . '\\' . $config[ 'namespace' ] . 'Module'; 

                    // an index MUST be provided and MUST have the same Name than the module namespace + 'Module'
                    if ( $config[ 'index-file' ] ) {
                        $this->modules[ $config[ 'namespace' ] ]    =   $config;
                    }
                }
            }
        }
    }

    /**
     * Run Modules
     * @return void
     */
    public function init()
    {
        /**
         * Include Tendoo module Class
         * Required to autoload module components
         */

        include_once( base_path() . '\app\Services\TendooModule.php' );
        
        foreach( $this->modules as $module ) {

            /**
             * We might check whether the module is enabled or not
             */
            
            // include module index file
            include_once( $module[ 'index-file' ] );
            
            // run module entry class
            $loadedModule     =   new $module[ 'entry-class' ];

            // add view namespace
            View::addNamespace( ucwords( $module[ 'namespace' ] ), $module[ 'views-path' ] );
        }
    }

    /**
     * Return the list of module as an array
     * @return array of modules
     */
    public function get( $namespace = null )
    {
        if ( $namespace !== null ) {
            return @$this->modules[ $namespace ];
        }
        return $this->modules;
    }

    /**
     * Return the list of active module as an array
     * @return array of active modules
     */
    public function getActives()
    {
        return $this->modules;
    }

    /**
     * Get by File
     * @param string file path
     * @return array/null
     */
    public function asFile( $indexFile )
    {
        foreach( $this->modules as $module ) {
            if ( $module[ 'index-file' ] == $indexFile ) {
                return $module;
            }
        }
    }
}