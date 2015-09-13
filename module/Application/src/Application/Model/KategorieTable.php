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
            'parent' => $cat->parent,
            'aktivni' => $cat->aktivni,
        );
        if( !$this->tableGateway->insert( $data ) )
            throw new \Exception( "xD" );
    }
}