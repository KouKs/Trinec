<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\KategorieForm;
use Application\Model\Kategorie;
use Application\Model\Msg;
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
            //return $this->redirect()->toRoute('application/login' );
        }
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        //return $this->redirector()->toRoute('admin/kategorie/');
    }

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
        );
    }

    /**
     * kategorie
     */
    private function getCategoryTable()
    {
        return $this->getServiceLocator()->get('Application\Model\KategorieTable');
    }

    private function buildSelect($result)
    {
        $ret = array( "Hlavní kategorie" );
        foreach( $result as $row )
        {   
            if( !$row->level )
            {
                $ret[] = array( 
                    'value' => $row->id,
                    'label' => $row->nazev,
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

    public function schvalovaniAction()
    {
        return new ViewModel();
    }

    public function banneryAction()
    {
        return new ViewModel();
    }


}

