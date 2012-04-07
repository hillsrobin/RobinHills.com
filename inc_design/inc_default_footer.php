		<div class="left">
			<div class="validate"><a href="http://www.validome.org/validate/?uri=http://www.robinhills.com" title="Validate">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr> 1.0 Strict</a></div>
			<div class="themes"><a href="" rel="csstheme" name="default"<?PHP echo $theme->getName() == "default" ? ' class="active"' : '';?>>Day</a> | <a href="" rel="csstheme" name="moon"<?PHP echo $theme->getName() == "moon" ? ' class="active"' : '';?>>Night</a></div>
			<div class="clear"></div>
		</div>
		<div class="right">&copy; 2009-<?PHP echo date('Y');?> robinhills.com. All Rights Reserved.</div>
		<div class="clear"></div>
		<?PHP
		if($_SERVER['DEV'] != 'TRUE')
		{
			// Analytics Code
			?>
			<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
				try 
				{
					var pageTracker = _gat._getTracker("UA-7981520-1");
					pageTracker._trackPageview();
				} catch(err) {}
			</script>
			<?PHP
		}
