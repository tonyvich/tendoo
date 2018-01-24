<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\Modules;
use App\Services\Setup;
use App\Services\Helper;

class DisableModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:disable {namespace}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable an existing module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $modules    =   app()->make( Modules::class );
        $this->module   =   $modules->get( ucwords( $this->argument( 'namespace' ) ) );

        if ( $this->module ) {
            $modules->disable( ucwords( $this->argument( 'namespace' ) ) );
            return $this->info( sprintf( '%s has been disabled.', $this->module[ 'name' ] ) );
        }

        return $this->error( 'Unable to locate the module !' );
    }
}
