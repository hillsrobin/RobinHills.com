<?PHP
	session_start();

	// Set a default if it does not exist
	!isset($_SESSION['User']) ? $_SESSION['User'] = '' :  null;
	
	if (isset($_COOKIE['Logged']))
	{
		if((!isset($_SESSION['User'])) || ($_SESSION['User'] == ''))
		{
			$id_res = $db->QueryAsRow('SELECT id FROM users WHERE id="'.$_COOKIE['Logged'].'"');
			
			if(!$db->Error())
				$_SESSION['User'] = $id_res['id'];
			else
			{	
				setcookie ("Logged", "", time( ) - 1, "/", COOKIE_DOMAIN);
				unset($_SESSION['User']);
			}
		}
	}
	else if(isset($_SESSION['User']))
		unset($_SESSION['User']);
?>
