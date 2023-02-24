<?php
$address = "../";
$filesaddress = "../files/";
$filename = "../content/news.txt";
?>
<?php include $filesaddress ."head.txt"; ?>
	<title>O nás | <?php include $filesaddress ."title.txt"; ?></title>
	<link rel="shortcut icon" href="../styles/favicon.ico" />
	<link rel="stylesheet" href="../styles/styles.css" />
	<script type="text/javascript">
	</script>
</head>
<body id="main">
<?php include $filesaddress ."menu.txt"; ?>
	<div id="rightmenu">
<?php include $filesaddress ."right_menu.txt"; ?>
	</div>
	<div id="text2_news">
		<div id="text">
		<div class="article2">
			<h1>O třídě II.G</h1>
			<p>Zde bude něco napsáno o naší třídě a plus nějaké foto. :D</p>
			<br />
		</div>
		</div>
		<p id="footer"><?php include $filesaddress ."footer.txt"; ?></p>
	</div>
</body>
</html>