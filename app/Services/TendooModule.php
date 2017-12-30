<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;

class TendooModule
{
    public function __construct( $file )
    {
        $this->modules  =   app()->make( 'App\Services\Modules' );
        $this->module   =   $this->modules->asFile( $file );
        $eventFiles     =   Storage::disk( 'modules' )->files( $this->module[ 'namespace' ] . '\Events' );
        
        // including events files
        foreach( $eventFiles as $file ) {
            include_once( config( 'tendoo.modules_path' ) . '\\' . $file );
        }
    }
}