<?php
/*
package utp
testlist.php
List available tests
Author: Vlad Podvorny
*/

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
if (!defined('DOCPATH')) exit;
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

$lang = 'en-US';
$charset = 'utf-8';
$testdir = TESTDIR;
//$frontpage = basename(DOCPATH);
$testpref = 'test.';
$testsuf = '.php';

//$listhead = "Test List";
$title = "Unit Test Page at " . $_SERVER['HTTP_HOST'];

$testlist = array(); // list of pairs testname => description

header("Content-Type: text/html; charset={$charset}");

?><!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head><title><?php echo $title; ?></title>
<style>
body {font:10pt arial,helvetica,sans-serif; padding:0; margin:0;}
.error {color:red;}

.header {padding-left:1em;}
.wrap {width:800px;}
.infobox {width:180px; margin:8px; padding:0; background:#dcdcdc; border-radius:4px; float:left;}

.testlistbox {width:560px; height:600px; overflow-y:scroll; border:4px solid #dcdcdc; border-width: 4px 0; float:left;}

.testlist a {font-size:12pt; text-decoration:none; color:#03c;}
.testlist a:hover {text-decoration:underline;}
.testlist .upd {font-size:8pt;}
.testlist li {padding:0.2em 0; border-top:1px dotted #999;}
.testlist li:first-child {border:0;}

.infobox ul {list-style-type:none; margin:0; padding:0;}
.infobox ul li {margin:0; padding:0.2em;}
.infobox ul li a {font:bold 10pt arial,helvetica,sans-serif; text-decoration:none; color:#03c; width:100%; height:100%; display:block;}
.infobox ul li a:hover {color:#000; background-color:#ccc;}

.footer {padding:4px; font-size:8pt; clear:both;}
</style>
</head>
<body>
<div class="header"><h2><?php echo $title; ?></h2></div>
<div class="wrap">
<div class="infobox">
<?php

include __DIR__ . DIRECTORY_SEPARATOR . 'links.php';

?>
</div>
<?php
if (is_dir($testdir)) {
    if ($dh = opendir($testdir)) {
        while(($fn = readdir($dh)) !== false) {
            if (($s = ph::filename2name($fn))!=='') {
                $fp = TESTDIR . DIRECTORY_SEPARATOR . $fn;
                $descr = ph::readdoc($fp);
                $ft = filemtime($fp);
                if ($descr) $descr = htmlspecialchars($descr);
                $testlist[$s] = implode("\n", array_filter(array($descr, "<span class=\"upd\">" . date("Y/m/d H:i", $ft) . "</span>")));
            }
        }
        closedir($dh);
    } else { ?><p class="error">Cannot open <em><?php echo $testdir; ?></em>!</p><?php }
} else { ?><p class="error"><em><?php echo $testdir; ?></em> is not a directory!</p><?php }

if ($testlist) { ?>
<div class="testlistbox">
    <ol class="testlist">
<?php
    ksort($testlist);
    foreach ($testlist as $testname=>$descr) {
        $url = basename(DOCPATH) . '?' . TESTKEY . '=' . $testname;
        if (strlen($descr)) $descr = nl2br("\n".$descr);
        echo "        <li><a href=\"{$url}\" target=\"_blank\">{$testname}</a>{$descr}</li>\n";
    }
?>    </ol>
</div>
<?php } else { ?><p class="error">Test directory has no test files!</p><?php }
?>
</div>
<div class="footer"></div>
</body></html>