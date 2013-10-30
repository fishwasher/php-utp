<?php
/*
package utp
Unit Test entry point
Author: Vlad Podvorny
*/
error_reporting(-1);
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// DO NOT OUTPUT ANYTHING UNTIL TEST FILE GETS INCLUDED
// SINCE IT MIGHT NEED TO USE THE HEADER
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

define('INFOKEY', 'info'); // GET key for phpinfo

if (isset($_GET[INFOKEY])) { // phpinfo requested?
    phpinfo();
    exit;
}
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

//date_default_timezone_set('UTC');
date_default_timezone_set('America/New_York');

if (!defined('DOCPATH')) define('DOCPATH', __FILE__); // might be defined in 'index.php'

define('DOCDIR', __DIR__);
define('TESTDIR', DOCDIR . DIRECTORY_SEPARATOR . 'test'); // test scripts
define('INCDIR', TESTDIR . DIRECTORY_SEPARATOR . 'app'); // utp includes
define('LIBDIR', DOCDIR . DIRECTORY_SEPARATOR . 'lib');   // directory with scripts being tested
define('TESTKEY', 'test'); // GET key to select test

define('PASSWORD', ''); // leave empty if no user authentication is required
define('NO_COMMENTS', 0); // deflate script before rendering?

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
include INCDIR . DIRECTORY_SEPARATOR . 'login.php';// optional user authentication
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

// add more definitions if required..
//define('DATADIR', DOCDIR . DIRECTORY_SEPARATOR . 'data');   // cache, databases, etc.

set_include_path(get_include_path() . PATH_SEPARATOR . LIBDIR); // add more locations if needed

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// a helper static class
include INCDIR . DIRECTORY_SEPARATOR . 'ph.php';
//ph::p('?');
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// if test name is not specified, list all available tests
if (empty($_GET[TESTKEY])) {
    include INCDIR . DIRECTORY_SEPARATOR . 'testlist.php';
    exit;
}
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
header("Content-Type: text/plain; charset=utf-8");

$err404 = "HTTP/1.0 404 Not Found";
$msg404 = "404 Not Found";
$testname = preg_replace("/\W+/", '', $_GET[TESTKEY]);

if (empty($testname) || $testname!=$_GET[TESTKEY]) {// validate test name
    header($err404);
    exit($msg404);
}

$testfile = TESTDIR . DIRECTORY_SEPARATOR . ph::name2filename($testname); // follow the pattern: 'MyTest' --> 'test.MyTest.php'

if (!is_file($testfile)) { // check if specified test exists
    header($err404);
    exit($msg404);
}

define('TESTPATH', $testfile);
unset($err404, $msg404, $testname, $testfile);

// configure assert behavior
assert_options(ASSERT_ACTIVE,   true);
assert_options(ASSERT_BAIL,     true);
assert_options(ASSERT_WARNING,  false);
assert_options(ASSERT_CALLBACK, 'ph::assertcallback');

set_error_handler("ph::exceptionhandler");

// run test
ph::begin();
try {
    include TESTPATH;
    ph::p();
    ph::finish();
    ph::p();
}
catch (Exception $e) {
    ph::h("EXCEPTION, SIR!");
    ph::p();
    ph::p($e->getMessage());
    ph::p();
    ph::p("in file " . $e->getFile() . " on line " . $e->getLine());
    ph::p();
    ph::p($e->getTraceAsString());
    ph::p();
}

// show test script
ph::h("TEST SCRIPT FOLLOWS");

if (NO_COMMENTS) {
    ph::pd(file_get_contents(TESTPATH)); // print clean script
}
else {
    ph::pl(file_get_contents(TESTPATH)); // print with comments and line numbers
}

ph::h(date('Y-m-d H:i'));
//ph::stop('', __FILE__, __LINE__);

exit;
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
?>