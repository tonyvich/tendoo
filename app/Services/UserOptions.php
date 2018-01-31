<?php
namespace App\Services;

use App\Services\Options;

class UserOptions extends Options
{
    public function __construct( $user_id )
    {
        parent::__construct( $user_id );
    }

    /**
     * Get user option
     * @return mixed
     */
    public function getOption( $key = null, $default = null )
    {
        /**
         * If key is provided
         */
        if ( $key !== null ) {
            return $this->get( $key, $default );
        }

        /**
         * If no keys are provided
         */
        return $this->get();
    }
}