	<?PHP
	$theme = new CSSTheme();
	$theme->ThemePath = ROOT_PATH."docroot/css/theme/";
	$theme->UseCookie = true;
	?>
	
	<link href="css/layout.css" rel="stylesheet" media="all" type="text/css"/>		
	<link href="css/design.css" rel="stylesheet" media="all" type="text/css"/>
	<link href="css/typography.css" rel="stylesheet" media="all" type="text/css"/>
	
	<link href="css/theme/<?PHP echo $theme->getName();?>.css" rel="stylesheet" media="all" type="text/css"/>
