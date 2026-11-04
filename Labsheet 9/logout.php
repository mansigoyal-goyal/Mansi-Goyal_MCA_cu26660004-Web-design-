<?php
// Task 6: Secure logout
session_start();
$_SESSION = [];                                   // clear variables
if (ini_get('session.use_cookies')) {             // remove session cookie
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();                                // destroy session
header('Location: login.php');
exit;
