<?php
/*
package mute
login.php
Cookie-based user authentication
Author: Vlad Podvorny
*/

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
if (!defined('DOCPATH')) exit;
if (!defined('PASSWORD') || !strlen(PASSWORD)) return;
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$cookiename = 'qute_token';
$pwhash = md5(strrev(PASSWORD) . PASSWORD);

if (!empty($_COOKIE[$cookiename]) && $_COOKIE[$cookiename]===$pwhash) return; // already logged in with current password

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// process POST
if ('POST'==strtoupper($_SERVER['REQUEST_METHOD'])) {
    if (isset($_POST['password']) && PASSWORD===trim($_POST['password'])) {
        setcookie($cookiename, $pwhash);
    }
    header("Location: " . basename(DOCPATH)); // redirect to itself
    exit;
}
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// Login form
header("Content-Type: text/html; charset=utf-8");
?><!DOCTYPE html>
<html lang="en-US">
<head><title>Sign In</title>
<style>
</style>
</head>
<body>
<div id="wrap">
	<form method="post" onsubmit="return (this.elements.password.value.replace(/\\s+/g, '')!=='')">
	<label for="password">Password:</label>
	<input type="password" name="password" size="16" maxlength="32" autocomplete="off" />
	<input type="submit" name="submit" value="OK" />
	</form></div>
</body></html><?php exit; ?>