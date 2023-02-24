<?php
define("BR", "
");

function isInteger($input){
	return(ctype_digit(strval($input)));
}

$address = "./";
$filesaddress = "./files/";
$filename = "./content/news.txt";

if(isset($_GET['article'])){
	$article = $_GET['article'];
	$data = file($filesaddress . $filename);
	if(!isInteger($_GET['article']) || $article < 1 || $article > count($data)){
		header("Location: ". $address ."");
		exit;
	}
}else{
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		if(!isInteger($_GET['page'])){
			header("Location: ". $address ."");
			exit;
		}else if($page < 1){
			header("Location: ". $address ."?page=1");
			exit;
		}
	}else{
		$page = 1;
	}
	$messages = 10;

	$data = file($filesaddress . $filename);
	if(count($data) > 0){
		$pages = ceil(count(file($filesaddress . $filename)) / $messages);
		if($page > $pages){
			header("Location: ". $address ."?page=". $pages ."");
			exit;
		}
		$plist = BR.'			<p id="pagelist">';
		if($page != 1){
			$plist = $plist .'[<a class="blue" href="'. $address .'?page='. ($page-1) .'">&lt; Předchozí strana</a>]';
		}
		if($page != $pages){
			$plist = $plist .'[<a class="blue" href="'. $address .'?page='. ($page+1) .'">Další strana ></a>]';
		}
		$plist = $plist ."</p>".BR;
	}
}
?>
<?php include $filesaddress ."head.txt"; ?>
	<title>Aktuality | <?php include $filesaddress ."title.txt"; ?></title>
	<link rel="shortcut icon" href="./styles/favicon.ico" />
	<link rel="stylesheet" href="./styles/styles.css" />
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
<?php
if(isset($_GET['article'])){
	$article = explode(";;;",$data[(count($data)-$article)]);
	echo '			<div class="article2">
';
	echo '				<h1>'. $article[0] .'</h1>
';
	echo '				<p>'. $article[2] .'</p>
';
	echo '				<p class="date">'. $article[3] .' '. $article[4] .'</p>
';
	echo '			</div>
';
	echo '			<p id="pagelist">[<a class="blue" href="'. $address .'" onclick="history.back(); return false;">Zpět</a>]</p>
';
}else{
	$firstmessage = $page * $messages - ($messages - 1);
	$lastmessage =  $page * $messages;

	if(count($data) > 0){
		for($i = $firstmessage - 1; $i < $lastmessage; $i++){
			if($i >= count($data)){
				$i = $lastmessage;
			}else{
				$article = explode(";;;",$data[$i]);
				echo '			<div class="article">
';
				echo '				<h1><a class="no-decoration" href="'. $address .'?article='. (count($data)-$i) .'">'. $article[0] .'</a></h1>
';
				echo '				<p>'. $article[1] .'</p>
';
				echo '				<p class="date">'. $article[3] .' '. $article[4] .'</p>
';
				echo '			</div>
';
			}
		}
		echo '			<br />';
		echo $plist;
	}else{
		echo BR.'<p id="pagelist">Zatím zde nejsou žadné zprávy!</p>';
	}
}
?>
			<br />
		</div>
		<p id="footer"><?php include $filesaddress ."footer.txt"; ?></p>
	</div>
</body>
</html>