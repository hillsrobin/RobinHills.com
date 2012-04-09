<?PHP
session_start();

$res = $db->QueryAsRow('SELECT id FROM users WHERE username="'.EncodeText($_POST['username']).'" AND password="'.md5($_POST['password']).'"');
	
if((!$db->Error())&&($_POST['username'] != "")) 
{
	if(strtolower($_POST['remember']) == 'on')
		$_POST['remember'] = '1';
	
	if(intval($_POST['remember']) == 1)
		setcookie("Logged",$res['id'], time() + 315360000 /*10 years*/ , "/",COOKIE_DOMAIN);
	else
		setcookie("Logged",$res['id'], 0 /* Session Cookie*/ ,"/",COOKIE_DOMAIN);
	
	$_SESSION['User'] = $res['id'];
	
	Utils::Redirect('__LAST_PAGE__');
}
else
	Utils::Redirect('login.php?error');
?>
