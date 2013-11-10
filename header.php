<html>
	<head>
		<meta charset="<?php bloginfo('charset') ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset') ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Wade Urry - http://www.iwader.co.uk/">
		<link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/img/favicon.ico">
		
		<title><?php wp_title('-', true, 'right'); ?> <?php bloginfo('name') ?></title>
		
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/css/style.css">
		
		<script type="text/javascript" src="<?php blogingo('template_url') ?>/js/jquery-2.0.3.min.js"></script>
		
		<!-- HTML5 shim and Respond.js - IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
        
        <?php wp_head(); ?>
	</head>
    <body>
		<div id="wrap">
			<header>
				<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							
							<a class="navbar-brand" href="<?php bloginfo('url') ?>">
								<h1><?php bloginfo('name') ?></h1>
								<p><?php bloginfo('description') ?></p>
							</a>
						</div>
						
						<div class="collapse navbar-collapse pull-right">
							<ul class="nav navbar-nav">
								<li class="active">
									<a href="#">Home</a>
								</li>
								<li>
									<a href="#">Portfolio</a>
								</li>
								<li>
									<a href="#">About Me</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</header>
			
			<div id="content" class="container">