<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\KategorieForm;
use Application\Model\Kategorie;

class AdminController extends AbstractActionController
{
    
    public function indexAction()
    {
        //$this->redirector('kategorie', 'admin');
        return new ViewModel();
    }

    public function kategorieAction()
    {
        $table = $this->getCategoryTable();
        $form = new KategorieForm( );
        $view = new ViewModel();
        //$reader = new \Zend\Config\Reader\Ini();
        //$messages = $reader->fromFile( '../../../../../config/autoload/messages.ini');
        
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
                //$view->error = $messages["admin"]["error"]["category"]["inputInvalid"];
            }
        }
        
        $view->kategorie = $this->buildHierarchy( $table->fetchAll( ) );
        $view->form = new KategorieForm( null , $this->buildSelect( $table->fetchAll( ) ) );
        return $view;
    }
    /**
     * kategorie
     */
    private function getCategoryTable()
    {
        return $this->getServiceLocator()->get('Application\Model\KategorieTable');
    }
    private function buildSelect( $result )
    {
        $ret = [];
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
    private function buildHierarchy( $__result )
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
}