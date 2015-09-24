<?php

/**
 * Kategorie table gateway
 *
 * @author Pavel
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class KategorieTable {
    
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
    
    public function add( Kategorie $cat ) {
        $data = array( 
            'nazev' => $cat->nazev,
            'level' => $cat->level,
            'typ' => $cat->typ,
            'parent' => $cat->parent,
            'aktivni' => $cat->aktivni,
        );
        if( !$this->tableGateway->insert( $data ) )
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
    }
    
    public function edit( $id , $data )
    {
        
        if( !$this->tableGateway->update( $data , [ 'id' => $id ] ) )
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
    }
    
    public function delete( $id )
    {
        if( !$this->tableGateway->delete( [ 'id' => $id ] ) )
            throw new \Exception( "Nastala chyba! Konktaktujte, prosím, správce webových stránek." );
    }
}