		<div class="left">
			<div class="validate">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr> 1.0 Strict</div>
			<div class="clear"></div>
		</div>
		<div class="right">&copy; 2009-<?PHP echo date('Y');?> robinhills.com. All Rights Reserved.</div>
		<div class="clear"></div>
		<?PHP
		if(!MODE_DEV)
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
