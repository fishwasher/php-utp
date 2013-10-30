<?php
/**
A sample data conversion and validation class test
*/

$cls = 'DemoClassA';
$fname = $cls . '.php';

require $fname;

assert("{$cls}::any(1,2,3)===1");
assert("{$cls}::any('a', 'b', 'c')==='a'");
assert("{$cls}::any(false, 'a')==='a'");
assert("{$cls}::any('', '0', 1)===1");
assert("{$cls}::any(0, '0', '')===''");

ph::pass();
?>