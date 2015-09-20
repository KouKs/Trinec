<?php

/**
 * Kategorie table gateway
 *
 * @author Michael
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable {
    
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function register( User $cat ) {
        $data = array( 
            'nick' => $cat->nick,
            'email' => $cat->email,
            'heslo' => $cat->heslo,
        );
        if( !$this->tableGateway->insert( $data ) )
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
        
        return true;
    }
    
    public function edit($row, $value, $nick ) {
        $data = [ $row => $value ];
        
        if( !$this->tableGateway->update( $data, [ 'nick' => $nick ] ) )
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
    }
    
    public function login( User $cat ) {
        $nick = $cat->nick;
        $heslo = $cat->heslo;
        
        $user = $this->tableGateway->select( [ 'nick' => $nick, 'heslo' => $heslo ] );
        
        if( count( $user ) == 1 ) {
            return $user;
        } else if( count( $user ) == 0 ) { 
            return false;
        } else {
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
        }
    }
    
    public function getUserByNick( $nick ) {
        $user = $this->tableGateway->select( [ 'nick' => $nick ] );
        
        if( count( $user ) == 1 ) {
            return $user;
        } else if( count( $user ) == 0 ) { 
            return false;
        } else {
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
        }        
    }
}