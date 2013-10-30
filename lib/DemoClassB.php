<?php
/*
package php-utp
class DemoClassB
A sample class
Author: Vlad Podvorny
*/

class DemoClassB {

    protected $data;
    
    function __construct($data=null){
        $this->set($data);
    }
    
    function set($data){
        $this->data = $data;
    }
    
    function get(){
        return $this->data;
    }
    
    function __toString(){
        return __CLASS__;
    }

}
?>