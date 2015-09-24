<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\KategorieForm;
use Application\Model\Kategorie;
use Application\Model\Msg;
use Application\Model\Menu;
use Zend\Session\Container;

class AdminController extends AbstractActionController
{
    private $msg;
    private $user;
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->msg = new Msg( );
        $this->logged = new Container('user'); 
        
        if( !$this->logged->admin )
        {
            return $this->redirect()->toRoute('application/login' );
        }
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return $this->redirect()->toRoute('application/admin/kategorie');
    }
    
    /***************************************
     * KATEGORIE
     */
    public function kategorieAction()
    {
        $table = $this->getCategoryTable();
        $form = new KategorieForm( null , $this->buildSelect( $table->fetchAll( ) ) );

        $request = $this->getRequest();
        if( $request->isPost( ) )
        {
            $cat = new Kategorie( );
            $form->setInputFilter( $cat->getInputFilter( ) );
            $form->setData( $request->getPost( ) );
            
            if( $form->isValid( ) )
            {
                $data = array( 
                    'nazev' => $form->getData()["nazev"],
                    'level' => $form->getData()["kategorie"] ? 1 : 0,
                    'typ'   => $form->getData()["typ"],
                    'parent' => $form->getData()["kategorie"],
                    'aktivni' => 1,
                );
                $cat->exchangeArray( $data );
                $table->add( $cat );
            }
            else
            {
                $error = $this->msg->get( "form.error.invalidInput" , array( "val" => "kategorie" ) );
            }
        }

        $kategorie = $this->buildHierarchy( $table->fetchAll( ) );

        return array( 
            'kategorie'     => $kategorie,
            'form'          => $form,
            'error'         => isset( $error ) ? $error : null,
            'menu'          => new Menu( $this->url()->fromRoute("application/admin") , array( 
                                        "kategorie", 
                                        "log",
                                        "schvalovani" => "schvalování",
                                        "bannery",
                               ) , "kategorie" ),
        );
    }
    private function getCategoryTable()
    {
        return $this->getServiceLocator()->get('Application\Model\KategorieTable');
    }

    private function buildSelect($result)
    {
        $ret[] = array( 
            "label" => "Hlavní kategorie" , 
            "value" => 0,
        );
        foreach( $result as $row )
        {   
            if( !$row->level )
            {
                $ret[] = array( 
                    'value' => $row->id,
                    'label' => $row->nazev,
                    'attributes' => array(
                        'data-key' => $row->typ,
                    ),
                );
            }
        }
        return $ret;
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

    public function editcategoryAction()
    {
        $id = $this->params()->fromPost('id');
        $value = $this->params()->fromPost('value');

        $table = $this->getCategoryTable();
        $table->edit( $id , array( "nazev" => $value ) );

        return $this->response;
    }

    public function deletecategoryAction()
    {
        $id = $this->params()->fromPost('id');

        $table = $this->getCategoryTable();
        $table->delete( $id );

        return $this->response;
    }
    
    /****************************************
     * SCHVALOVANI
     */
    public function schvalovaniAction()
    {
        $bannery = $this->getBannerTable( );
        
        
        return array( 
            'bannery'       => $this->buildBanners( $bannery->select( "aktivni=0" , "uzivatele" , "uzivatele.id = banner.autor_id" , array("nick" , "jmeno" , "prijmeni") ) ),
            'error'         => isset( $error ) ? $error : null,
            'menu'          => new Menu( $this->url()->fromRoute("application/admin") , array( 
                                        "kategorie", 
                                        "log",
                                        "schvalovani" => "schvalování",
                                        "bannery",
                               ) , "schvalovani" ),
        );
    }
    
    /****************************************
     * BANNERY
     */
    public function banneryAction( )
    {
        $table = $this->getBannerTable( );
        
        
        return array( 
            'bannery'       => $this->buildBanners( $table->select( "zaplaceno=1" , "uzivatele" , "uzivatele.id = banner.autor_id" , array("nick" , "jmeno" , "prijmeni") ) ),
            'error'         => isset( $error ) ? $error : null,
            'menu'          => new Menu( $this->url()->fromRoute("application/admin") , array( 
                                        "kategorie", 
                                        "log",
                                        "schvalovani" => "schvalování",
                                        "bannery",
                               ) , "bannery" ),
        );
    }
    
    public function editbannerAction( )
    {
        $id = $this->params()->fromPost('id');
        $aktivni = $this->params()->fromPost('aktivni');
        $cas = $this->params()->fromPost('cas');

        $table = $this->getBannerTable();
        $table->edit( $id , array( "potvrzeno" => $cas , "aktivni" => $aktivni ) );

        return $this->response;
    }
    
    private function buildBanners( $result )
    {
        $ret = [];
        foreach( $result as $index=>$row )
        {
            $ret[ $index ]["data"] = $row;
            $ret[ $index ]["parsedTime"] = $this->parseTime( $row->cas );
        }
        return $ret;
    }
    
    private function getBannerTable( )
    {
        return $this->getServiceLocator()->get('Application\Model\BannerTable');
    }
    
    private function parseTime( $data )
    {
        $ret = "";
        $casy = explode( "|" , $data );
        foreach( $casy as $index=>$cas )
        {
            if( $index === 0 ) 
            {
                $ret .= $cas . ":00 - ";
                $beingSpaned = $cas;
            }
            elseif( $casy[ $index-1 ] != $cas-2 )
            {
                $ret .= ( $casy[ $index-1 ] + 2 ) . ":00, " .  $cas . ":00 - ";
                $beingSpaned = $cas;
            }
        }
        $ret .= ( $cas + 2 ) . ":00";
        return $ret;
    }


}

