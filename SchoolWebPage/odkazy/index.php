<?php
$address = "../";
$filesaddress = "../files/";
?>
<?php include $filesaddress ."head.txt"; ?>
	<title>Odkazy | <?php include $filesaddress ."title.txt"; ?></title>
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
			<h1>Odkazy, které se mohou hodit</h1>
			<ul>
				<li><a href="http://www.gvid.cz/">Web školy Gymnázium Vídeňská 47</a></li>
				<li><a href="https://isas.gvid.cz/">ISAS - databáze známek</a></li>
				<li><a href="http://moodle.gvid.cz/">Moodle</a></li>
				<li><a href="http://moodle.gvid.cz/wiki/index.php/Hlavn%C3%AD_strana">MyFiBi (Gvid - Wiki)</a></li>
			</ul>
			<br />
		</div>
		</div>
		<p id="footer"><?php include $filesaddress ."footer.txt"; ?></p>
	</div>
</body>
</html>