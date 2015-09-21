<?php

/**
 *
 *
 * @author Michal
 */
namespace Application\Model;

class Msg {
    private $config;
    
    public function __construct() {
        $this->config = parse_ini_file(__DIR__ . '/../../../../../config/autoload/messages.ini' , true);
    }
    
     /**
     * @param route = [array] [ messages_module, messages_type, messages_id ]
     * @param params [array] [ 'placeholder' => 'replacement' ] | OPTIONAL
     */
    public function get( $route, $params = [] ) {
        $route = explode( ".", $route );
        
        $return = $this->config[ $route[0] ][ $route[1] ][ $route[2] ];
        foreach ( $params as $search => $value ) {
            $return = str_replace( "%".$search."%", $value, $return);
        }
        
        return $return;
    }
}
