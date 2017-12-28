<?php
namespace App\Services\Helpers;

trait ArrayHelper {
    /**
     * Return Odds
     * @param array 
     * @param string type
     * @return array
     */
    static function arrayDivide( array $array, string $type = '' )
    {
        if( $array ) {
            $result     =   [
                'odd'   =>  [],
                'even'  =>  []
            ];

            foreach ($array as $k => $v) {
                if ($k % 2 == 0) {
                    $result[ 'even' ][] = $v;
                }
                else {
                    $result[ 'odd' ][] = $v;
                }
            }

            if( ! empty( $type ) ) {
                return $result[ $type ];
            }
            return $result;
        }
        return [];
    }
}