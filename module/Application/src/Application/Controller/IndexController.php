<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


use Zend\Session\Container;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Model\User;
use Application\Model\Msg;

class IndexController extends AbstractActionController
{
    public $msg;
    
    private $logged;
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $this->msg = new Msg;
        
        $this->logged = new Container('user');

        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {          
        if( !isset( $this->logged->nick ) ) {
            $form = new LoginForm();
            $request = $this->getRequest();
            if( $request->isPost( ) )
            {
                $login = new User( );
                $login->setInputs([ 'nick', 'heslo' ]);
                $form->setInputFilter( $login->getInputFilter(  ) );
                $form->setData( $request->getPost( ) );

                if( $form->isValid( ) )
                {
                    $table = $this->getUserTable();
                    $data = array( 
                        'nick' => $form->getData()['nick'],
                        'heslo' => $form->getData()['heslo']
                    );
                    $login->exchangeArray( $data );

                    if( $user = $table->login( $login ) ) {
                        foreach( $user as $u ) {
                            $this->logged->nick = $u->nick;
                            $this->logged->admin = $u->admin;
                            return $this->redirect()->toRoute('application/default', array(
                                        'controller' => 'profil'
                            ));
                        }
                    } else {
                        $error = $this->msg->get( 'login.error.invalidCredentials');
                    }
                }
                else
                {
                    $error = $this->msg->get( 'form.error.invalidData');
                }
            }
            return array( 
                'form'          => $form,
                'error'         => isset( $error ) ? $error : null,
                'menu' => new Menu( $this->url()->fromRoute("application") , array( 
                    "login", 
                    "registrace",
                    "obnovit" => "zapomenuté heslo",
                ) , "login" ),
            );
        } else {
            return $this->redirect()->toRoute('application/default', array(
                        'controller' => 'profil'
            ));
        }
    }

    private function getUserTable()
    {
        return $this->getServiceLocator()->get('Application\Model\UserTable');
    }

    public function registraceAction()
    {
                
        if( !isset( $this->logged->nick ) ) {
            $form = new RegisterForm();
            $request = $this->getRequest();
            if( $request->isPost( ) )
            {
                $register = new User( );
                $register->setInputs([ 'nick', 'heslo', 'email' ]);
                $form->setInputFilter( $register->getInputFilter( ) );
                $form->setData( $request->getPost( ) );

                if( $form->isValid( ) )
                {
                    if( $form->getData()['heslo'] == $form->getData()['heslo_repeat'] ) {
                        $table = $this->getUserTable();
                        $data = array( 
                            'nick' => $form->getData()['nick'],
                            'heslo' => $form->getData()['heslo'],
                            'email' => $form->getData()['email']
                        );
                        $register->exchangeArray( $data );
                            $bool = $table->register( $register );
                            if( $bool === true ) {
                                $this->logged->nick = $register->nick;
                                $this->logged->admin = 0;
                                     // redirect
                            } else if( $bool == 'nick'  ) {
                                $error = $this->msg->get( 'login.error.nickUsed', [ 'nick' => $data['nick'] ]);
                            } else if( $bool == 'email' ) {
                                $error = $this->msg->get( 'login.error.emailUsed', [ 'email' => $data['email'] ]);
                            } else {
                                $error = $this->msg->get( 'other.error.unknownError' );
                            }
                    } else {
                        $error = $this->msg->get( 'login.error.passwordsNotMatching');
                    }
                }
                else
                {
                    $error = $this->msg->get( 'form.error.invalidData');
                }
            }
            return array( 
                'form'          => $form,
                'error'         => isset( $error ) ? $error : null,
                'menu' => new Menu( $this->url()->fromRoute("application") , array( 
                    "login", 
                    "registrace",
                    "obnovit" => "zapomenuté heslo",
                ) , "registrace" ),
            );
        } else {
            return $this->redirect()->toRoute('application/default', array(
                        'controller' => 'profil'
            ));
        }
    }


}

