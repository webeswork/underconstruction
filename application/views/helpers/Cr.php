<?php

//carriage return
class Zend_View_Helper_Cr {

    public function cr($text) {

        //return nl2br($text);
        //  I don't want to allow people to use more then one enter (br) allowed in text
        //http://stackoverflow.com/questions/3365013/allow-only-one-br-in-nl2br

       
        $text = nl2br($text);
        /* $pattern = array();
        $pattern[0] = '/(<br \/>)+/';
        $pattern[1] = '/(<br>)+/';
        $text = preg_replace($pattern, '<br>', $text);*/
        return $text;
    }

}
