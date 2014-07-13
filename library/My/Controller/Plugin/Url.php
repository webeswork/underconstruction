<?php

//Wordpress Url szűrés
 //Routing and complex URLs in Zend Framework
//http://codeutopia.net/blog/2007/11/16/routing-and-complex-urls-in-zend-framework/

class My_Controller_Plugin_Url extends Zend_Controller_Plugin_Abstract
{

	
	public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $url = $request->getRequestUri();

       // var_dump($url);

       //preg_match("/^(.*)\/(\?p=)(\d+)/", $url, $matches); print_r($matches);

        $pos = strpos($url, "?"); //echo $pos;

        if($pos>0) {
            $dirPart = substr($url,0,strrpos($url,'/')); //echo "<br>".$dirPart;
            $url= substr($url,$pos+1); //echo "<br>".$url;
            


          $request->setRequestUri($dirPart."/".$url);

        }

    }   
    
    



}




