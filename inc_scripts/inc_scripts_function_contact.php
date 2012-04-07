<?PHP
// Check to make sure everything is valid

$email = $_POST['your_email'];
$name = $_POST['your_name'];
$message = $_POST['your_message'];

$bValid = true;

/*
if(preg_match("//",$email) ==  0)
	$bValid = false;
*/	

if(preg_match("/[^a-z,A-Z, ,\-,\']+/",$name) > 0)
	$bValid = false;
	
if((strlen(trim($message)) == 0) || (strlen(trim($email)) == 0))
	$bValid = false;
	
if($bValid)
{
	$more_headers =	'Content-type: text/plain; charset=iso-8859-1' . "\r\n"; 
					'From: '.$email. "\r\n" .
    				'Reply-To: '.$email. "\r\n" .
    				'X-Mailer: PHP/'. phpversion();
	
	mail("robin.hills@gmail.com","From robinhills.com",$message,$more_headers);
}
	
Utils::Redirect('contact.php?sent');

?>