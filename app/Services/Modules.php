<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Services\Helper;
use XmlParser;
class Modules 
{
    private $modules    =   [];

    public function __construct()
    {
        if ( Helper::AppIsInstalled() ) {
            /**
             * We can only enable a module if the databse is installed.
             */
            $this->options          =   app()->make( 'App\Services\Options' );
        }
    }

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
                    'name'                  =>  [ 'uses'    =>  'name' ]
                ]);

                $config[ 'files' ]          =   $files;

                // If a module has at least a namespace
                if ( $config[ 'namespace' ] != null ) {
                    // index path
                    $moduleBasePath     =   config( 'tendoo.modules_path' ) . $dir . '\\';
                    $indexPath          =   $moduleBasePath . ucwords( $config[ 'namespace' ] . 'Module.php' );
                    $webRoutesPath      =   $moduleBasePath . 'Routes\web.php';

                    // check index existence
                    $config[ 'index-file' ]                 =   is_file( $indexPath ) ? $indexPath : false;
                    $config[ 'routes-file' ]                =   is_file( $webRoutesPath ) ? $webRoutesPath : false;
                    $config[ 'controllers-path' ]           =   $moduleBasePath . 'Http\Controllers';
                    $config[ 'controllers-relativePath' ]   =   ucwords( $config[ 'namespace' ] ) . '\Http\Controllers';
                    $config[ 'views-path' ]                 =   $moduleBasePath . 'Resources\Views\\';
                    $config[ 'dashboard-path' ]             =   $moduleBasePath . 'Dashboard\\';
                    $config[ 'enabled' ]                    =   false; // by default the module is set as disabled

                    /**
                     * If the system is installed, then we can check if the module is enabled or not
                     * since by default it's not enabled
                     */
                    if ( Helper::AppIsInstalled() ) {
                        $modules                =   ( array ) json_decode( $this->options->get( 'enabled_modules' ), true );
                        $config[ 'enabled' ]    =   in_array( $config[ 'namespace' ], $modules ) ? true : false;
                    }
                    
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

            if ( ! $module[ 'enabled' ] ) {
                continue;
            }
            
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
        return array_filter( $this->modules, function( $module ) {
            if ( $module[ 'enabled' ] === true ) {
                return $module;
            }
        });
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

    /**
     * Extract module using provided namespace
     * @param string module namespace
     * @return array of module details
     */
    public function extract( $namespace )
    {
        if ( $module  = $this->get( $namespace ) ) {
            $zipFile        =   storage_path() . '\module.zip';
            // unlink old module zip
            if ( is_file( $zipFile ) ) {
                unlink( $zipFile );
            }

            // create new archive
            $zipArchive     =   new \ZipArchive;
            $zipArchive->open( 
                storage_path() . '\module.zip', 
                \ZipArchive::CREATE | 
                \ZipArchive::OVERWRITE 
            );
            $zipArchive->addEmptyDir( ucwords( $namespace ) );

            $moduleDir      =   dirname( $module[ 'index-file' ] );
            $files          =   Storage::disk( 'modules' )->allFiles( ucwords( $namespace ) );
            
            foreach( $files as $index => $file ) {
                $zipArchive->addFile( config( 'tendoo.modules_path' ) . $file, $file );
            }

            $zipArchive->close();

            return [
                'path'      =>  $zipFile,
                'module'    =>  $module
            ];
        }
    }

    /**
     * Upload a module
     * @param File module
     * @return boolean
     */
    public function upload( $file )
    {
        // move file to temp directory
        $path   =   Storage::disk( 'temp-modules' )->putFile( 
            null, 
            $file 
        );

        $fullPath   =   storage_path( 'modules\\' . $path );        
        $dir        =   dirname( $fullPath );

        $archive    =   new \ZipArchive;
        $archive->open( $fullPath );
        $archive->extractTo( $dir );
        $archive->close();
        // delete zip
        unlink( $fullPath );

        $directories    =   Storage::disk( 'temp-modules' )->directories();
        $resultMessage  =   'invalid_module';
        $module         =   [];
        
        /**
         * Seach if we can have a config.xml file within the extracted files
         */
        foreach( $directories as $dir ) {
            // browse directory files
            $files          =   Storage::disk( 'temp-modules' )->allFiles( $dir );

            foreach( $files as $file ) {
                if ( $file == $dir . '/config.xml' ) {
                    $xml    =   new \SimpleXMLElement( 
                        Storage::disk( 'temp-modules' )->get( $file )
                    );
                    
                    if ( 
                        ! isset( $xml->namespace ) &&
                        ! isset( $xml->version ) &&
                        ! isset( $xml->name )
                    ) {
                        /**
                         * The resultMessage is already "invalid_message"
                         */
                        Storage::disk( 'temp-modules' )->deleteDirectory( $dir );
                        break;
                    }

                    /**
                     * Check if a similar module already exists
                     * and if the new module is outdated
                     */
                    if ( $module = $this->get( ucwords( $xml->namespace ) ) ) {
                        if ( version_compare( $module[ 'version' ], $xml->version, '>=' ) ) {
                            $resultMessage   =   'old_module';
                            break;
                        }
                    }

                    /**
                     * No errors has been found, We\'ll install the module then
                     */

                    // @step 1 : creating host module
                    Storage::disk( 'modules' )->makeDirectory( ucwords( $xml->namespace ) );

                    /**
                     * We're not looping to move files
                     */
                    
                    foreach( $files as $file ) {
                        // $realFile   =   substr( $file, strlen( $dir ) + 1 );
                        Storage::disk( 'modules' )->put( 
                            $file,
                            Storage::disk( 'temp-modules' )->get( $file )
                        );
                    }

                    /**
                     * If the module has been copied, no need to continue the loop. Just break it
                     */
                    $resultMessage   =   'valid_message';
                    break;
                }
            }
        }

        /**
         * The user may have uploaded some unuseful files. 
         * We should then delete everything and return an error.
         */

        $files  =   Storage::disk( 'temp-modules' )->allFiles();

        foreach( $files as $file ) {
            Storage::disk( 'temp-modules' )->delete( $file );
        }

        /**
         * Return result message
         */
        return [
            'status'    =>  'danger',
            'code'      =>  $resultMessage,
            'module'    =>  $module
        ];
    }

    /**
     * delete Modules
     * @param string module namespace
     * @return array of error message
     */
    public function delete( string $namespace )
    {
        /**
         * Check if module exists first
         */
        if ( $module = $this->get( $namespace ) ) {
            // disabling module first
            $this->disable( $namespace );

            Storage::disk( 'modules' )->deleteDirectory( ucwords( $namespace ) );

            return [
                'status'    =>  'success',
                'code'      =>  'module_deleted',
                'module'    =>  $module
            ];
        }

        /**
         * This module can't be found. then return an error
         */
        return [
            'status'    =>  'danger',
            'code'      =>  'unknow_module'
        ];
    }

    /**
     * Enable module
     * @param string namespace
     * @return array of error message
     */
    public function enable( string $namespace )
    {
        // check if module exists
        if ( $module = $this->get( $namespace ) ) {
            // @todo sandbox to test if the module runs
            $enabledModules     =   ( array ) json_decode( $this->options->get( 'enabled_modules' ), true );

            // make sure to enable only once
            if ( ! in_array( $namespace, $enabledModules ) ) {
                $enabledModules[]   =   $namespace;
                $this->options->set( 'enabled_modules', json_encode( $enabledModules ) );
            }

            return [
                'status'    =>  'success',
                'code'      =>  'module_enabled',
                'module'    =>  $module
            ];
        }

        return [
            'status'    =>  'warning',
            'code'      =>  'unknow_module'
        ];
    }

    /**
     * Disable Module
     * @param string module namespace
     * @return array of status message
     */
    public function disable( string $namespace )
    {
        // check if module exists
        if ( $module = $this->get( $namespace ) ) {
            // @todo sandbox to test if the module runs
            $enabledModules     =   ( array ) json_decode( $this->options->get( 'enabled_modules' ), true );
            $indexToRemove      =   array_search( $namespace, $enabledModules );

            // if module is found
            if ( $indexToRemove !== false ) {
                unset( $enabledModules[ $indexToRemove ] );
            }

            $this->options->set( 'enabled_modules', json_encode( $enabledModules ) );

            return [
                'status'    =>  'success',
                'code'      =>  'module_disabled',
                'module'    =>  $module
            ];
        }

        return [
            'status'        =>  'danger',
            'code'          =>  'unknow_module'
        ];
    }
}