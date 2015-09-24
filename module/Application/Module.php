<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Kategorie;
use Application\Model\User;
use Application\Model\Banner;
use Application\Model\KategorieTable;
use Application\Model\UserTable;
use Application\Model\BannerTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // SESSIONS
        $this->initSession(array(
            'remember_me_seconds' => 300,
            'use_cookies' => true,
            'cookie_httponly' => true,
        ));
        $eventManager->attach('dispatch', array($this, 'loadConfiguration' ));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /**
                 * kategorie
                 */
                'Application\Model\KategorieTable' =>  function($sm) {
                    $tableGateway = $sm->get('KategorieTableGateway');
                    $table = new KategorieTable($tableGateway);
                    return $table;
                },
                'KategorieTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Kategorie());
                    return new TableGateway('kategorie', $dbAdapter, null, $resultSetPrototype);
                },
                /**
                 * user
                 */
                'Application\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('uzivatele', $dbAdapter, null, $resultSetPrototype);
                },
                /**
                 * banner
                 */
                'Application\Model\BannerTable' =>  function($sm) {
                    $tableGateway = $sm->get('BannerTableGateway');
                    $table = new BannerTable($tableGateway);
                    return $table;
                },
                'BannerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Banner());
                    return new TableGateway('banner', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
    public function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }
    
    public function loadConfiguration(MvcEvent $e)
    {           
        $controller = $e->getTarget();
        $controller->layout()->user = new Container('user');
        /*
         * $config = parse_ini_file(__DIR__ . '/../../config/autoload/messages.ini' , true);
        $controller->msg = "test";
        $controller->msg = function( $route , $params = [] ) use( $config ){
            $route = explode( ".", $route );
        
            $return = $config[ $route[0] ][ $route[1] ][ $route[2] ];
            foreach ( $params as $search => $value ) {
                $return = str_replace( "%".$search."%", $value, $return);
            }

            return $return;
        };
         */
    }
    
    
}
