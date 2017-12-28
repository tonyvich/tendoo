<?php
namespace App\Http\Controllers;

class ModulesController
{
    public function __construct()
    {
        app()->make( 'App\Services\Dashboard\MenusConfig' );
    }
}