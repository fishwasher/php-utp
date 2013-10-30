<?php
/**
A sample assertion-based data conversion and validation class test
*/

$cls = 'DemoClassA';
$fname = $cls . '.php';

require $fname;

assert("{$cls}::any(1,2,3)===1");
assert("{$cls}::any('a', 'b', 'c')==='a'");
assert("{$cls}::any(false, 'a')==='a'");
assert("{$cls}::any('', '0', 1)===1");
assert("{$cls}::any(0, '0', '')===''");

assert("{$cls}::sign(0)===0");
assert("{$cls}::sign('a')===0");
assert("{$cls}::sign('-a')===0");
assert("{$cls}::sign(2)===1");
assert("{$cls}::sign(-2)===-1");
assert("{$cls}::sign('2')===1");
assert("{$cls}::sign('-2')===-1");
assert("{$cls}::sign('-a')===0");
assert("{$cls}::sign('2a')===0");
assert("{$cls}::sign(null)===0");

assert("{$cls}::isAlphanum(null)===false");
assert("{$cls}::isAlphanum(0)===false");
assert("{$cls}::isAlphanum(1)===false");
assert("{$cls}::isAlphanum('')===false");
assert("{$cls}::isAlphanum(true)===false");
assert("{$cls}::isAlphanum('0')===true");
assert("{$cls}::isAlphanum('a')===true");
assert("{$cls}::isAlphanum('_')===false");

assert("{$cls}::smartbool('')===false");
assert("{$cls}::smartbool(0)===false");
assert("{$cls}::smartbool('0')===false");
assert("{$cls}::smartbool(false)===false");
assert("{$cls}::smartbool('FALSE')===false");
assert("{$cls}::smartbool('falSE')===false");
assert("{$cls}::smartbool(null)===false");
assert("{$cls}::smartbool('Null')===false");
assert("{$cls}::smartbool('NOPE')===false");
assert("{$cls}::smartbool('none')===false");
assert("{$cls}::smartbool('off')===false");
assert("{$cls}::smartbool('FALS')===true");
assert("{$cls}::smartbool('of')===true");
assert("{$cls}::smartbool(1)===true");
assert("{$cls}::smartbool('1')===true");

ph::pass();
?>