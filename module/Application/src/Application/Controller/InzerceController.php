<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Msg;
use Application\Model\Menu;
use Zend\Session\Container;

class InzerceController extends AbstractActionController
{

    
    /*##################################
     * Kategorie
     */
    public function indexAction()
    {
        $table = $this->getCategoryTable();
        
        
        return [
            'kategorie' => $this->buildHierarchy( $table->fetchAll( ) ),
            'menu' => new Menu( $this->url()->fromRoute("application/inzerce") , array( 
                                        "vypis" => "výpis", 
                                        "pridat" => "přidat nový",
                               ) , "vypis" ),
        ];
    }

    private function getCategoryTable()
    {
        return $this->getServiceLocator()->get('Application\Model\KategorieTable');
    }

    private function buildHierarchy($__result)
    {
        $ret = $result = [ ];
        foreach( $__result as $temp )
        {
            $result[] = $temp;
        }
        foreach( $result as $row )
        {
            if( $row->level == 0 )
            {
                $ret[ $row->id ]["data"] = $row;
            }
            foreach( $result as $child )
            {
                if( $child->parent == $row->id )
                {
                    $ret[ $row->id ]["children"][] = array( "data" => $child , "parentString" => $row->nazev );
                }
            }
        }
        return $ret;
    }
    
    
    /*##################################
     * Pridavani
     */
    public function pridatAction( )
    {
        
        
        return [
            'menu' => new Menu( $this->url()->fromRoute("application/inzerce") , array( 
                                        "vypis" => "výpis", 
                                        "pridat" => "přidat nový",
                               ) , "pridat" ),
        ];
    }
}

