<?php
/*
package utp
links.php
Author: Vlad Podvorny
*/

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
if (!defined('DOCPATH')) exit;
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$linktarget = "second"; // keep them in one place
//$linktarget = "_blank";

$sep = "\n";
$links = array(
    "My PHP (" . phpversion() . ") Info {$sep}" . basename(DOCPATH) . '?' . INFOKEY . '=1',
    "PHP.net {$sep} http://www.php.net/",
    "GitHub {$sep} https://github.com/",
    "http://stackoverflow.com/",
    "Google Developers {$sep} https://developers.google.com/",
);
?>

    <ul>
<?php
foreach ($links as $entry) {
    $a = array_map('trim', explode($sep, $entry));
    $url = array_pop($a);
    $title = ($a) ? $a[0] : rtrim(preg_replace("|^https?://|", '', $url), '/');
    ?>
        <li><a href="<?php echo $url; ?>" target="<?php echo $linktarget; ?>"><?php echo htmlspecialchars($title); ?></a></li>
<?php }
?>    </ul>
