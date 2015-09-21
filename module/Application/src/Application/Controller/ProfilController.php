<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Application\Model\Msg;

class ProfilController extends AbstractActionController
{
    private $logged;
    
    public $msg;
    
    public function __construct( ) {
        $this->msg = new Msg;
        
        echo $this->msg->get( 'admin.error.inputInvalid', [ 'val' => 'kategorie' ] );
        die();
        $this->logged = new Container('user');
        
        if( !isset( $this->logged->nick ) ) {
            // nepřihlášený uživatel
            var_dump( $this->logged->nick );
            die( 'denied' );  
        }
    }

    public function indexAction()
    {
        $table = $this->getUserTable();
        foreach( $table->getUserByNick( $this->logged->nick ) as $u ) {
            return [ 
                   'user' => $u

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

}

