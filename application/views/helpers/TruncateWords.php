<?php

class Zend_View_Helper_TruncateWords {

    function truncatewords($text, $maxLength = 55) {
        // explode the text into an array of words
        $wordArray = explode(' ', $text);

        // do we have too many?
        if (sizeof($wordArray) > $maxLength) {
            // remove the unwanted words
            $wordArray = array_slice($wordArray, 0, $maxLength);

            // turn the word array back into a string and add our ...
            return implode(' ', $wordArray) . '&hellip;';
        }

        // if our array is under the limit, just send it straight back
        return $text;
    }

}

