<?php

/**
 * Banner table gateway
 *
 * @author Pavel
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class BannerTable {
    
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
    
    public function add( Banner $ban ) {
        $data = [
            'autor_id'    => $ban->autor_id,
            'url'         => $ban->url,
            'img'         => $ban->img,
            'doba'        => $ban->doba,
            'pozice'      => $ban->pozice,
            'vlozeno'     => $ban->vlozeno,
            'potvrzeno'   => $ban->potvrzeno,
            'cas'         => $ban->cas,
            'aktivni'     => $ban->aktivni,
        ];
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