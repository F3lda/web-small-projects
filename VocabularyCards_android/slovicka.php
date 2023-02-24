<html>
<head>
<title></title>
<style>
body {font-size: 80px; background-color: grey;}
a {text-decoration: none; color: blue}
#nadpis {position: absolute; left: 20; top: 25; background-color: royalblue; border-radius: 10px; width: 955px; font-size: 110px; text-align: center;}
#menu {position: absolute; left: 20; top: 200; background-color: red; border-radius: 10px; width: 955px; height: auto;}
#menu ul li a {font-size: 80px;}
#menu ul li {list-style: none;}
</style>
</head>
<body>
<span id="nadpis">Moje sady</span>
<div id="menu">
<ul>
	<li><a href="index.php">ZPĚT DO MENU</a></li>
	<?php
	$projectsListIgnore = array ('.','..');
	$handle = opendir("./sady/");
	while ($file = readdir($handle)) 
	{
		$explode = explode(".",$file);
		if($explode[1] == "txt" && !in_array($file,$projectsListIgnore)){
			echo '<li><a href="zobraz.php?sada='.$explode[0].'">'.$explode[0].'</a></li>';
		}
	}
	closedir($handle);
	?>
</ul>
</div>
</body>
</html>