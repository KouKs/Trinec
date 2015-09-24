<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Menu;
use Zend\Session\Container;
use Application\Model\Msg;
use Application\Model\Banner;
use Application\Form\BannerForm;

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
                                    "" => 'Profil', 
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
        $table = $this->getBannerTable( );
        $msg = false;
        $form = new BannerForm();
            $request = $this->getRequest();
            if( $request->isPost( ) )
            {
                $banner = new Banner( );
                $form->setInputFilter( $banner->getInputFilter(  ) );
                $form->setData( $request->getPost( ) );

                if( $form->isValid( ) )
                {
                    $data = array( 
                        'id' => $form->getData()['banner'],
                        'url' => $form->getData()['url'],
                        //'file' => $form->getData()['soubor']
                    );
                    
                    $table->edit( $data['id'] , array( "url" => $data['url'] /*, "file" => 'file_name'*/ ) );
                }
                else
                {
                    $msg = $this->msg->get( 'form.error.invalidData');
                }
            }
        
        return [
            'form' => $form,
            'message' => $msg,
            'user' => $this->logged->nick,
            'bannery' => $this->buildBanners( $table->select( "zaplaceno=1" , "uzivatele" , "uzivatele.id = banner.autor_id" , array("nick" , "jmeno" , "prijmeni") ) ),
            'menu' => new Menu( $this->url()->fromRoute("application/profil") , array( 
                "" => 'Profil', 
                "bannery" => 'Bannery',
            ) , "bannery" ),
        ];
    }

    public function payAction()
    {
       $message = false;
       $table = $this->getBannerTable( );
       $params = $this->params()->fromPost();
       
       $hours = explode( '|', substr( $params['time'], 0, strlen( $params['time'] ) - 1 ) );
       $data['doba'] = intval( $params['form_weeks'] ) > 5 ? 5 : intval( $params['form_weeks'] );
       $data['pozice'] = intval( $params['banner'] ) > 4 ? 1 : intval( $params['banner'] );
       $data['vlozeno'] = time();
       $data['autor_id'] = $this->getUserTable()->getUserByNick( $this->logged->nick )->current()->id;
       
       $banners = $table->select( 'pozice = '.$data['pozice'].' AND zaplaceno = 1' );
       foreach( $hours as $index => $hour ) {
           $hours[ $index ] = intval($hour);
       }
       sort( $hours );
       
       foreach( $banners as $banner ) {
           $time = explode( '|', $banner->cas );
           if( count( array_intersect($time, $hours) ) > 0 ) {
               $message = $this->msg->get( 'banner.error.hourBooked');
               break;
           }
       }
       
        if( !$message ) {
            $data[ 'cas' ] = implode( '|', $hours );
            $add = new Banner;
            $add->exchangeArray($data);
            $table->add( $add );
            
            // redirect
            die();
        }
                  
        return [
            'message' => $message,
            'menu' => new Menu( $this->url()->fromRoute("application/profil") , array( 
                "" => 'Profil', 
                "bannery" => 'Bannery',
             )),
        ];
    }
    
    private function getBannerTable( )
    {
        return $this->getServiceLocator()->get('Application\Model\BannerTable');
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

