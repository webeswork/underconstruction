<?php

class Zend_View_Helper_TranslateSeparator {

    function TranslateSeparator( $content, $lang, $strip=0) {

        //regexp próbálkozás:
        //  $pattern = "/(<!--:hu-->)(.*)(<!--:-->)/";
        //    preg_match($pattern, $content, $matches);
        //   var_dump($matches);
        //

        $startpos = strpos($content, "<!--:" . $lang . "-->");
        $endpos = strpos($content, "<!--:-->", $startpos);

        //  echo  "<br>".$startpos .", ". $endpos."<br>";
    if($strip==1){$translation = trim(strip_tags(substr($content, $startpos, $endpos)));  }
    else {  $translation = trim(substr($content, $startpos, $endpos));}
      
      $foo = strip_tags($translation);
        if (empty($foo)) {
            return $content;
        } else {
            return $translation;
        }
    }

}

