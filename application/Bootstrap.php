<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    

    protected function _initRoutes() {
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $router->removeDefaultRoutes();

        //default
        $router->addRoute(
                'default',
                new Zend_Controller_Router_Route('/',
                        array(
                            'controller' => 'index',
                            'action' => 'index'
                        )
                )
        );







        $router->addRoute(
                'controller-category',
                new Zend_Controller_Router_Route('/index/:termid',
                        array(
                            'controller' => 'index',
                            'action' => 'index'
                        )
                )
        );



        $router->addRoute(
                'controller-view',
                new Zend_Controller_Router_Route(':controller/:action/id/:id',
                        array(
                            'controller' => 'index',
                            'action' => 'view'
                        )
                )
        );





        $router->addRoute(
                'controller-pager',
                new Zend_Controller_Router_Route(':controller/:action/termid/:termid/page/:page',
                        array(
                            'controller' => 'index',
                            'action' => 'index'
                        )
                )
        );


    }
   


    protected function _initAutoload() {
        // Add autoloader empty namespace
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $autoLoader->registerNamespace('My_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(
                        array('basePath' => APPLICATION_PATH, 'namespace' => '',
                            'resourceTypes' => array('form' => array('path' => 'forms/',
                                    'namespace' => 'Form_'),
                                'model' => array('path' => 'models/',
                                    'namespace' => 'Model_'))));
        // Return it so that it can be stored by the bootstrap
        return $autoLoader;
    }

}

