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
        
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $cat = new Kategorie( );
            $data = array( 
                'nazev' => $request->getPost()->nazev,
                'level' => $request->getPost()->kategorie ? 1 : 0,
                'parent' => $request->getPost()->kategorie,
                'aktivni' => 1,
            );
            $cat->exchangeArray( $data );
            $table->add( $cat );
    }
        
        $view = new ViewModel();
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
    private function buildHierarchy( $result )
    {
        return $result;
    }
}