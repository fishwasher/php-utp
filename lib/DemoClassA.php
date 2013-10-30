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

}
?>