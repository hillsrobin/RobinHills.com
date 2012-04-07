<?PHP
	session_start();

	if (isset($_COOKIE['Logged']))
	{
		if((!isset($_SESSION['User'])) || ($_SESSION['User'] == ''))
		{
			$id_res = $db->QueryAsRow('SELECT id FROM users WHERE id="'.$_COOKIE['Logged'].'"');
			
			if(!$db->Error())
				$_SESSION['User'] = $id_res['id'];
			else
			{	
				$_SERVER['DEV'] == 'TRUE' ? $cookie_domain = '10.10.1.97' : $cookie_domain = 'robinhills.com';
				
				if(!is_numeric(str_replace('.','',$cookie_domain)))
					$cookie_domain = '.'.$cookie_domain;
				
				setcookie ("Logged", "", time( ) - 1, "/", $cookie_domain);
				unset($_SESSION['User']);
			}
		}
	}
	else if(isset($_SESSION['User']))
		unset($_SESSION['User']);
?>
