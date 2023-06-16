<?php

session_start();
session_unset();
session_destroy();
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time()-10800, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
}
if (isset($_COOKIE[$username])) {
    setcookie($username, '', time()-10800);
}
session_write_close();
header("Location: index.php");

?>