<?php
/*
package php-utp
class DemoClassA
A sample static class with some data conversion and validation methods
Author: Vlad Podvorny
*/

class DemoClassA {


    static function any(){ // return 1st non-empty parameter, or 1st non-empty entry if single param is an array
        $a = func_get_args();
        if (1===sizeof($a) && is_array($a[0])) $a = $a[0];
        $val = null;
        foreach ($a as $val) {
            if ($val) return $val;
        }
        return $val; // return last one as fallback
    }

    static function sign($num) {
        if (!is_numeric($num) || $num==0) return 0;
        return ($num > 0) ? 1 : -1;
    }

    static function isAlphanum($val){
        return (is_string($val) && preg_match("/^[0-9A-Z]+$/i", $val));
    }

    static function smartbool($val){ // evaluates 'no', 'off' etc. to false
        if (!$val || !trim($val)) return false;
        $s = strtolower(trim($val));
        $a = array('', '0', 'false', 'no', 'nope', 'off', 'null', 'none', 'nil');
        return (in_array($s, $a)) ? false : true;
    }

}
?>