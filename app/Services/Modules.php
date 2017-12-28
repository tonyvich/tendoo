<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
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
                    $indexPath  =   config( 'tendoo.modules_path' ) . '\\' . $dir . '\\' . ucwords( $config[ 'namespace' ] . 'Module.php' );
                    // check index existence
                    $config[ 'index' ]          =   is_file( $indexPath ) ? $indexPath : false;
                    
                    // entry class name
                    $config[ 'entry-class' ]    =  'Modules\\' . $config[ 'namespace' ] . 'Module'; 

                    // an index MUST be provided and MUST have the same Name than the module namespace + 'Module'
                    if ( $config[ 'index' ] ) {
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
        foreach( $this->modules as $module ) {

            /**
             * We might check whether the module is enabled or not
             */
            
            // include module index file
            include_once( $module[ 'index' ] );

            // run module entry class
            $module     =   new $module[ 'entry-class' ];
        }
    }
}