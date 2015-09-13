<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\KategorieForm;

class AdminController extends AbstractActionController
{

    public function indexAction()
    {
        $this->redirector('kategorie', 'admin');
                return new ViewModel();
    }

    public function kategorieAction()
    {
        $this->getServiceLocator()->get('db');
        $view = new ViewModel();
        $view->form = new KategorieForm( );
        return $view;
    }


}

