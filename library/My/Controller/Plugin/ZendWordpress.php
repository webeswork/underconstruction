<?php

class My_Controller_Plugin_ZendWordpress extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
	$catid = $request->getParam('catid','');

	if ($catid == '')
	    $request->setParam('catid',0);



    }

}