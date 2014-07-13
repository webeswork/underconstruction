<?php

class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    protected $_aclvar;

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        // set up acl
        $acl = new Zend_Acl();

        // add the roles
        $acl->addRole(new Zend_Acl_Role('guest'));
        $acl->addRole(new Zend_Acl_Role('admin'));


        // add the resources, controllok
        $acl->add(new Zend_Acl_Resource('index'));
        $acl->add(new Zend_Acl_Resource('contact'));
        $acl->add(new Zend_Acl_Resource('user'));
        $acl->add(new Zend_Acl_Resource('error'));
        $acl->add(new Zend_Acl_Resource('imagegenerator'));



        //$acl->deny('guest', 'index');
        // $acl->allow('guest', 'index',  array('userregistration','notallowed'));
        $acl->allow('guest', 'index');
        $acl->allow('guest', 'user');
        $acl->allow('guest', 'error');
        $acl->allow('guest', 'contact');
        $acl->allow('guest', 'imagegenerator');


        // administrators can do anything except superadmin do

        $acl->allow('admin', 'index');
        $acl->allow('admin', 'contact');
        $acl->allow('admin', 'error');
        $acl->allow('admin', 'user');
        $acl->allow('admin', 'imagegenerator');





        // fetch the current user
        $auth = Zend_Auth::getInstance();
        # session namespace beállítás
        $auth->setStorage(new Zend_Auth_Storage_Session('zendpress_Auth'));


        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            //   var_dump($identity);
            $role = strtolower($identity->role);
        } else {
            $role = 'guest';
        }


        try {
            $controller = $request->controller;
            $action = $request->action;
            //echo "megengedett?:". $acl->isAllowed($role, $controller, $action);

            if (!$acl->isAllowed($role, $controller, $action)) {
                //  $request->setControllerName('error');
                //  $request->setActionName('error');

                $request->setControllerName('index');
                $request->setActionName('notallowed');
            }
        } catch (Zend_Exception $e) {
            echo "ACL Error message: <p>" . $e->getMessage() . "</p>\n";
            //$fc = Zend_Controller_Front::getInstance();
            //echo $fc->getBaseUrl();
            //echo "<H1><a href='".$fc->getBaseUrl()."'>VISSZA</a></h1><br>";
            //exit();
        }
    }

}

