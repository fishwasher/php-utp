<?php
/**
A sample freestyle text-mode test
*/

$cls = 'DemoClassB';
$fname = $cls . '.php';

ph::h("Testing class {$cls}");

require $fname;

$s = '$obj = new ' . $cls . '(1);';
ph::p("Creating an instance of {$cls}: " . $s);
eval($s);
ph::p();

$s = '$d = $obj->get();';
ph::p("Checking data: " . $s);
eval($s);
ph::p('$d = ' . ph::fmt($d));
ph::p();

$s = '$obj->set("a");';
ph::p("Updating data: " . $s);
eval($s);
ph::p();

$s = '$d = $obj->get();';
ph::p("Checking data: " . $s);
eval($s);
ph::p('$d = ' . ph::fmt($d));
ph::p();

$s = '$obj->set(array("a", "b"=>1, 5=>null, ""=>"null", array(true, false, "true", "false"), "x"=>new '.$cls.'));';
ph::p("Updating data: " . $s);
eval($s);
ph::p();

$s = '$d = $obj->get();';
ph::p("Checking data: " . $s);
eval($s);
ph::p('$d = ' . ph::fmt($d));
ph::p();
ph::ps();

?>