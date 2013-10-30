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

$s = '$d = $obj->get();';
ph::p("Checking data: " . $s);
eval($s);
ph::p('$d = ' . $d);

$s = '$obj->set("a");';
ph::p("Updating data: " . $s);
eval($s);
$s = '$d = $obj->get();';
ph::p("Checking data: " . $s);
eval($s);
ph::p('$d = ' . $d);

?>