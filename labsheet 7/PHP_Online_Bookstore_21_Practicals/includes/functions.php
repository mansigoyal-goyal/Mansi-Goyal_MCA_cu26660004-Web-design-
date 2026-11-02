<?php
if(session_status()===PHP_SESSION_NONE){session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax']);session_start();}
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function logged(){return isset($_SESSION['user_id']);}
function login_required(){if(!logged()){header('Location: /PHP_Online_Bookstore_21_Practicals/auth/login.php');exit;}}
function admin_required(){login_required();if(($_SESSION['role']??'')!=='admin'){http_response_code(403);exit('Admin access only');}}
function cash($v){return '₹'.number_format((float)$v,2);}
function cart_count(){return array_sum($_SESSION['cart']??[]);}
