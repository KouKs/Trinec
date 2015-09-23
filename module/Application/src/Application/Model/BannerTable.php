<?php

/**
 * Banner table gateway
 *
 * @author Pavel
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class BannerTable {
    
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $select = $this->tableGateway->getSql()
                ->select()
                ->join("uzivatele" , "uzivatele.id = banner.autor_id" , array("nick","jmeno","prijmeni"));
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
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
            'zaplaceno'   => $ban->zaplaceno,
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
    
    public function select( $where = null , $join = null , $cond = null , $cols = null , $order = "id ASC" )
    {
        $select = $this->tableGateway->getSql()
                ->select()
                ->where( $where )
                ->order( $order )
                ->join( $join , $cond , $cols );
        $result = $this->tableGateway->getSql()->prepareStatementForSqlObject( $select )->execute();
        
        $rs = new ResultSet();
        $rs->initialize( $result );
        
        return $rs;
    }
}