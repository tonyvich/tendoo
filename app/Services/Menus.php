<?php

namespace App\Services;

class Menus 
{
    private $namesace;
    private $menus;

    public function __construct( )
    {

    }

    /**
     * Push new menu to a specific menu namespaced
     * @param array of menus
     * @param string of namespace
     * @return void
     */
    public function add( $menus )
    {
        $this->menus[]     =   $menus;
    }

    /**
     * Get menus
     */
    public function get( $namespace = null )
    {
        if( $namespace == null ) {
            return $this->menus;
        }

        foreach( $this->menus as $index => &$menu ) {
            if ( $menu->namespace === $namespace ) {
                return $menu;
            }
        }
        return [];
    }

    /**
     * Add menu on
     * @param string menu namespace
     * @return void
     */
    public function addTo( $namespace, $menus )
    {
        if ( $menu = $this->get( $namespace ) ) {
            // if submenu doesn't exist create it
            if ( @$menu->childrens == null ) {
                $menu->childrens   =   [];
            }

            $menu->childrens[]   =   $menus;
        }
    }
}