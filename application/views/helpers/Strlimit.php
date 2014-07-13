<?php
class Zend_View_Helper_Strlimit
{
function strlimit($str,$limit=100)
{
	if(strlen($str)>$limit){
		$str = substr($str, 0, strrpos(substr($str, 0, $limit), ' ')).'...';
		}
	return $str;
}
}

