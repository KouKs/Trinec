<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Msg;
use Application\Model\Menu;
use Zend\Session\Container;

class InzeratyController extends AbstractActionController
{

    public function indexAction()
    {
        $table = $this->getCategoryTable();
        
        
        return [
            'menu' => new Menu( ),
        ];
    }

    private function getCategoryTable()
    {
        return $this->getServiceLocator()->get('Application\Model\KategorieTable');
    }

}

