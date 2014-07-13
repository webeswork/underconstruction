<?php
class Zend_View_Helper_Getrequestinfo
{
    public function getrequestinfo()
    {
        return Zend_Controller_Front::getInstance()->getRequest();
    }

}