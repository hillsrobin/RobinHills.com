<?PHP
session_start();

setcookie ("Logged", "", time( ) - 1, "/", COOKIE_DOMAIN);
unset($_SESSION['User']);

Utils::Redirect($_SERVER['HTTP_REFERER']);
?>
