<script type="text/javascript" src="javascript/inc_scripts_common_validation.js"></script>
<script type="text/javascript">

	var contact_validate = validate_form;
		
	window.addEvent('domready',function(){
		$('contact_form').setProperty('action','function.php?action=contact');
		contact_validate.add_field({id:'your_name', type: 'blank'});
		contact_validate.add_field({id:'your_email', type: ['blank','email']});
		contact_validate.add_field({id:'your_message', type: 'blank'});

		document.getElement('.contact_me input[type=button]').addEvent('click',function(){
			if(contact_validate.form())
				$('contact_form').submit();
		});
		
	});
</script>

<div class="contact_page">

	<?PHP
	if(isset($_GET['sent']))
	{
		?>
		<div class="confirm">Your message has been sent.</div>
		<?PHP
	}
	?>
	<h3>Contact details</h3>
	
	<div class="contact_label">Mailing Address:</div>
	<div class="contact_detail">
		<div>191 Indian Mountain Road</div>
		<div>Indian Mountain, New Brunswick</div>
		<div>E1H 1C4</div>
	</div>
	<div class="clear"></div>
	
	<div class="contact_label">Phone numbers:</div>
	<div class="contact_detail">
		<div>506-869-9107</div>
		<div>506-878-3314</div>
	</div>
	<div class="clear"></div>
	
	<div class="contact_label">Email:</div>
	<div class="contact_detail"><a href="mailto:robin.hills@gmail.com" title="Email me directly">robin.hills@gmail.com</a></div>
	<div class="clear"></div>

	<div class="contact_label">Twitter:</div>
	<div class="contact_detail"><a href="http://twitter.com/rdhills" title="Follow me on Twitter">@rdhills</a></div>
	<div class="clear"></div>
	
	<div class="contact_label">Linked In:</div>
	<div class="contact_detail"><a href="http://www.linkedin.com/pub/robin-hills/33/a32/ab5" title="View my profile on Linked In">View Profile</a></div>
	<div class="clear"></div>

	
	<div class="contact_label">Google+:</div>
	<div class="contact_detail"><a href="https://plus.google.com/116169936861129306953/posts" title="View my profile">View Profile</a></div>
	<div class="clear"></div>

	
	<form action="" method="post" id="contact_form">
	<div class="contact_body">
		<h3>Contact me directly</h3>
		<div class="contact_label">Your name:</div>
		<div class="contact_detail"><input type="text" name="your_name" id="your_name"/></div>
		<div class="clear"></div>
		<div class="required_field" id="your_name_error">Required Field</div>
		
		<div class="contact_label">Email address:</div>
		<div class="contact_detail"><input type="text" name="your_email" id="your_email"/></div>
		<div class="clear"></div>
		<div class="required_field" id="your_email_error">Required Field</div>
		
		<div class="contact_label">Your message:</div>
		<div class="contact_detail">
			<textarea cols="" rows="" name="your_message" id="your_message"></textarea>
		</div>
		<div class="clear"></div>
		<div class="required_field" id="your_message_error">Required Field</div>
		
		<div class="contact_me"><input type="button" value="Send your Message"/></div>
	</div>
	</form>
	
</div>
