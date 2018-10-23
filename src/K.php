<?php
/**
 * Created by PhpStorm.
 * User: etouraille
 * Date: 23/10/18
 * Time: 14:50
 */

namespace K;

class K {

    public static function get( $key ) {
        switch( $key ) {
            case 'Hello' :
                    return [1, 2, 3];

                    break;

            case 'The' :
                    return [4, 5, 6];
                break;

            case 'World':
                    return [ 7, 8, 9];
                    break;


            default :
                return false;
            break;


        }
    }
}