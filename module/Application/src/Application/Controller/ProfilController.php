<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\Session\Container;
use Application\Model\Msg;
use Application\Model\Menu;

class ProfilController extends AbstractActionController
{

    private $logged = null;

    public $msg = null;

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->msg = new Msg;
                
                $this->logged = new Container('user');
                
                if( !isset( $this->logged->nick ) ) {
                    return $this->redirect()->toRoute('application/login' );
                }
                return parent::onDispatch($e);
    }

    public function indexAction()
    {
        $table = $this->getUserTable();
                foreach( $table->getUserByNick( $this->logged->nick ) as $u ) {
                    return [ 
                           'user' => $u,
                           'menu'          => new Menu( $this->url()->fromRoute("application/profil") , array( 
                                    "index" => 'Profil', 
                                    "bannery" => 'Bannery',
                            ) , "index" ),
                           ];            
                }
    }

    public function editAction()
    {
        $accepted = [ 'email', 'jmeno', 'prijmeni', 'telefon', 'adresa', 'zarizeni', 'display' ];
                $row = $this->params()->fromPost('row');
                $value = $this->params()->fromPost('value');
                
                if( in_array( $row, $accepted ) ) {
                    $table = $this->getUserTable();
                    $table->edit( $row, $value, $this->logged->nick );
                }
                return $this->response;
    }

    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Application\Model\UserTable');
    }

    public function banneryAction()
    {
        
        return [
            'menu' => new Menu( $this->url()->fromRoute("application/profil") , array( 
                "index" => 'Profil', 
                "bannery" => 'Bannery',
            ) , "bannery" ),
        ];    
    }


}

