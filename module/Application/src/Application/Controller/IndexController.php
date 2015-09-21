<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;



use Zend\Session\Container;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Model\User;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        $logged = new Container('user');
                
                if( !isset( $logged->nick ) ) {
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
                                    $logged->nick = $u->nick;
                                    $logged->admin = $u->admin;
                                    return $this->redirect()->toRoute('application/default', array(
                                                'controller' => 'profil'
                                    ));
                                }
                            } else {
                                // chyba
                            }
                        }
                        else
                        {
                            // není validní
                        }
                    }
                    return array( 
                        'form'          => $form
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
        $logged = new Container('user');
                
                if( !isset( $logged->nick ) ) {
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

                                    if( $table->register( $register ) ) {
                                        $logged->nick = $register->nick;
                                        $logged->admin = 0;
                                            // redirect na předchozí stránku
                                    } else {
                                        // chyba
                                    }
                            } else {
                                // nestejná hesla
                            }
                        }
                        else
                        {
                            // není validní
                        }
                    }
                    return array( 
                        'form'          => $form
                    );
                } else {
                    return $this->redirect()->toRoute('application/default', array(
                                'controller' => 'profil'
                    ));
                }
    }


}

