<?php
	function getOS($user_agent)
	{
		$os_platform    =   "Unknown OS Platform";

		$os_array       =   array(
								'/windows nt 6.3/i'     =>  'Windows 8.1',
								'/windows nt 6.2/i'     =>  'Windows 8',
								'/windows nt 6.1/i'     =>  'Windows 7',
								'/windows nt 6.0/i'     =>  'Windows Vista',
								'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								'/windows nt 5.1/i'     =>  'Windows XP',
								'/windows xp/i'         =>  'Windows XP',
								'/windows nt 5.0/i'     =>  'Windows 2000',
								'/windows me/i'         =>  'Windows ME',
								'/win98/i'              =>  'Windows 98',
								'/win95/i'              =>  'Windows 95',
								'/win16/i'              =>  'Windows 3.11',
								'/macintosh|mac os x/i' =>  'Mac OS X',
								'/mac_powerpc/i'        =>  'Mac OS 9',
								'/linux/i'              =>  'Linux',
								'/ubuntu/i'             =>  'Ubuntu',
								'/iphone/i'             =>  'iPhone',
								'/ipod/i'               =>  'iPod',
								'/ipad/i'               =>  'iPad',
								'/android/i'            =>  'Android',
								'/blackberry/i'         =>  'BlackBerry',
								'/webos/i'              =>  'Mobile'
							);

		foreach ($os_array as $regex => $value) { 
			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}
		}   

		return $os_platform;
	}

	function getBrowser($user_agent) {
		$browser        =   "Unknown Browser";

		$browser_array  =   array(
								'/msie/i'       =>  'Internet Explorer',
								'/firefox/i'    =>  'Firefox',
								'/safari/i'     =>  'Safari',
								'/chrome/i'     =>  'Chrome',
								'/opera/i'      =>  'Opera',
								'/netscape/i'   =>  'Netscape',
								'/maxthon/i'    =>  'Maxthon',
								'/konqueror/i'  =>  'Konqueror',
								'/mobile/i'     =>  'Mobile Browser'
							);

		foreach ($browser_array as $regex => $value) { 
			if (preg_match($regex, $user_agent)) {
				$browser    =   $value;
			}
		}

		return $browser;
	}
	
	if(isset($_GET['vyhodnoceni'])){
		echo '<!doctype html>
<html>
	<head>
		<title>Kvíz - vyhodnocení</title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
				background-color: #20a439;
				overflow: hidden;
			}
			img {
				width: 100%;
				height: 100%;
				object-fit: contain;
			}
			a:link, a:visited {
				background-color: #f44336;
				color: white;
				padding: 14px 25px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
			}
			a:hover, a:active {
				background-color: red;
			}
			#button {
				position: absolute;
				bottom: 0px;
				width: 100%
			}
			#button2 {
				text-align: center;
			}
			#button2 a {
				margin: 0 10px;
			}
			#name {
				position:absolute;
				bottom: 0px;
				left: 0;
			}
			#exit {
				position:absolute;
				bottom: 0px;
				right: 0;
			}
			#overlay
			{
				position: fixed;
				top: 0;
				left: 0;
				background-color: #000;
				opacity: 0.5;
				width: 100%;
				height: 100%;
			}
			table {
				border-collapse: collapse;
				width: 100%;
				background-color: #A2A2A2;
			}
			th, td {
				text-align: left;
				padding: 8px;
			}
			tr:nth-child(even){
				background-color: #f2f2f2;
			}
			th {
				background-color: #4CAF50;
				color: white;
			}
			h2 {
				text-align: center;
				color: white;
			}
			p {
				text-align: center;
				color: white;
			}
		</style>
		<script>
			function deleteAll()
			{
				if(confirm("Opravdu chcete vynulovat vyhodnocení celého kvízu?")){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE) {
							if (xmlhttp.status == 200) {
								if (xmlhttp.responseText != 5) {
									document.getElementById("results").innerHTML = "<tr><th>Jméno týmu</th><th>Počet výher</th><th>Celkové pořadí</th></tr>"+xmlhttp.responseText;
								} else {
									alert("Chyba: 5");
								}
							} else {
								alert("Chyba: " + xmlhttp.status);
							}
						}
					};
					xmlhttp.open("POST", "./", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("cmd=deleteall");
				}
			}
		</script>
	</head>
	<body>		
		<h2>Vyhodnocení kvízu</h2>
		<table id="results">
		  <tr>
			<th>Jméno týmu</th>
			<th>Počet výher</th>
			<th>Celkové pořadí</th>
		  </tr>';
			if(!file_exists("vysledky.txt")) {
				file_put_contents("vysledky.txt", "");
			}
			
			$file = fopen("vysledky.txt", "r");
			if($file !== false) {
				$i = 1;
				while (($line = fgets($file)) !== false) {
					$parts = explode("-----", $line);
					if(count($parts) >= 3) {
						$teamName = htmlspecialchars(trim($parts[0]), ENT_QUOTES, 'UTF-8');
						$wins = htmlspecialchars(trim($parts[2]), ENT_QUOTES, 'UTF-8');
						echo "<tr><td>".$teamName."</td><td>".$wins."</td><td>".$i++.".</td></tr>".PHP_EOL;
					}
				}
				fclose($file);
			} else {
				echo "<tr><td colspan='3'>Žádné výsledky k zobrazení</td></tr>";
			}
echo'		</table>
		<div id="button">
			<div id="button2">
				<a href="?vysledky">Výsledky kola</a>
				<a href="" onclick="deleteAll(); return false;">Vynulovat vyhodnocení celého kvízu</a>
			</div>
		</div>
    </body>
</html>';
	} else if(isset($_GET['vysledky'])) {
		echo '<!doctype html>
<html>
	<head>
		<title>Kvíz - výsledky</title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
				background-color: #20a439;
				overflow: hidden;
			}
			img {
				width: 100%;
				height: 100%;
				object-fit: contain;
			}
			a:link, a:visited {
				background-color: #f44336;
				color: white;
				padding: 14px 25px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
			}
			a:hover, a:active {
				background-color: red;
			}
			#button {
				position: absolute;
				bottom: 0px;
				width: 100%
			}
			#button2 {
				text-align: center;
			}
			#name {
				position:absolute;
				bottom: 0px;
				left: 0;
			}
			#exit {
				position:absolute;
				bottom: 0px;
				right: 0;
			}
			#overlay
			{
				position: fixed;
				top: 0;
				left: 0;
				background-color: #000;
				opacity: 0.5;
				width: 100%;
				height: 100%;
			}
			table {
				border-collapse: collapse;
				width: 100%;
				background-color: #A2A2A2;
			}
			th, td {
				text-align: left;
				padding: 8px;
			}
			tr:nth-child(even){
				background-color: #f2f2f2;
			}
			th {
				background-color: #4CAF50;
				color: white;
			}
			h2 {
				text-align: center;
				color: white;
			}
			p {
				text-align: center;
				color: white;
			}
		</style>
		<script>
			function restart()
			{
				if(confirm("Opravdu chcete vynulovat výsledky aktuálního kola?")){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE) {
							if (xmlhttp.status == 200) {
								document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
							} else {
								alert("Chyba: " + xmlhttp.status);
							}
						}
					};
					xmlhttp.open("POST", "./", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("cmd=delete");
				}
			}

			function save(nick)
			{
				if(confirm("Potvrdit tým <"+nick+"> jako vítěze kola?")){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE) {
							if (xmlhttp.status == 200) {
								document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
							} else {
								alert("Chyba: " + xmlhttp.status);
							}
						}
					};
					xmlhttp.open("POST", "./", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("cmd=save&team="+nick);
				}
			}

			function resutlsCheck()
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == XMLHttpRequest.DONE) {
						if (xmlhttp.status == 200) {
							if (xmlhttp.responseText != 5) {
								document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
							} else {
								alert("Chyba: 5");
							}
						} else {
							alert("Chyba: " + xmlhttp.status);
						}
					}
				};
				xmlhttp.open("POST", "./", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send("cmd=preResults");
					
				var checkExist = setInterval(function() {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE) {
							if (xmlhttp.status == 200) {
								if (xmlhttp.responseText != 5) {
									document.getElementById("results").innerHTML = "<tr><th>Pořadí</th><th>Jméno týmu</th></tr>"+xmlhttp.responseText;
								} else {
									alert("Chyba: 5");
								}
							} else {
								alert("Chyba: " + xmlhttp.status);
							}
						}
					};
					xmlhttp.open("POST", "./", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("cmd=preResults");
				}, 1000);
			}
		</script>
	</head>
	<body onload="resutlsCheck();">		
		<h2>Výsledky kola</h2>
		<p>Pro určení vítěze kola klikni na řádek daného týmu.</p>
		<table id="results">
		  <tr>
			<th>Pořadí</th>
			<th>Jméno týmu</th>
		  </tr>
		</table>
		<div id="button">
			<div id="button2">
				<a href="?vyhodnoceni">Celkové vyhodnocení</a>
				<a href="" onclick="restart(); return false;">Vynulovat výsledky aktuálního kola</a>
			</div>
		</div>
    </body>
</html>';
	} else if(isset($_POST['cmd'])){
		if($_POST['cmd'] == "add"){
			if(!file_exists("kviz.txt")) {
				file_put_contents("kviz.txt", "");
			}
			
			$team = "";
			if(isset($_POST['name'])) {
				$team = $_POST['name'];
			} else {
				die(1);
			}
			$new = $team."-----".$_SERVER['REMOTE_ADDR'].PHP_EOL;
			
			$already = false;
			$file = fopen("kviz.txt", "r");
			if($file != false) {
				while (($line = fgets($file)) !== false) {
					//if(explode("-----",$line)[1] == $_SERVER['REMOTE_ADDR'].PHP_EOL){
					if(explode("-----",$line)[0] == $team){
						$already = true;
					}
				}
				fclose($file);
			} else {
				die(2);
			}
			
			if($already == false) {
				$handle = fopen("kviz.txt", "a");
				if($handle != false) {
					fwrite($handle, $new);
					fclose($handle);
					die(0);
				} else {
					die(3);
				}
			}
			die(4);
		} else if($_POST['cmd'] == "check"){
			if(!file_exists("kviz.txt")) {
				file_put_contents("kviz.txt", "");
			}
			
			$wait = false;
			$file = fopen("kviz.txt", "r");
			if($file !== false) {
				while (($line = fgets($file)) !== false) {
					$parts = explode("-----", $line);
					if(isset($parts[1]) && trim($parts[1]) == $_SERVER['REMOTE_ADDR']){
						$wait = true;
						break;
					}
				}
				fclose($file);
			}
			
			echo $wait ? 1 : 0;
		} else if($_POST['cmd'] == "preResults"){
			if(!file_exists("kviz.txt")) {
				file_put_contents("kviz.txt", "");
			}
			
			$file = fopen("kviz.txt", "r");
			if($file !== false) {
				$i = 1;
				while (($line = fgets($file)) !== false) {
					$parts = explode("-----", $line);
					if(isset($parts[0]) && !empty(trim($parts[0]))) {
						$teamName = htmlspecialchars(trim($parts[0]), ENT_QUOTES, 'UTF-8');
						echo "<tr onclick='save(\"".addslashes($teamName)."\");'><td>".$i++.".</td><td>".$teamName."</td></tr>".PHP_EOL;
					}
				}
				fclose($file);
			}
		} else if($_POST['cmd'] == "delete"){
			file_put_contents('kviz.txt', "");
		} else if($_POST['cmd'] == "save"){		
			// Ensure files exist
			if(!file_exists("vysledky.txt")) {
				file_put_contents("vysledky.txt", "");
			}
			if(!file_exists("kviz.txt")) {
				file_put_contents("kviz.txt", "");
			}
			
			$array = [];
			$file = fopen("vysledky.txt", "r");
			if($file !== false) {
				while (($line = fgets($file)) !== false) {
					$parts = explode("-----", $line);
					if(count($parts) >= 3) {
						$ip = trim($parts[1]);
						$teamName = trim($parts[0]);
						$wins = intval(trim($parts[2]));
						//$array[$ip] = [$teamName, $wins];
						$array[$teamName] = [$teamName, $wins];
					}
				}
				fclose($file);
			}
			
			if(isset($_POST['team'])) {
				$winningTeam = trim($_POST['team']);
				$handle = fopen("kviz.txt", "r");
				if($handle !== false) {
					while (($line = fgets($handle)) !== false) {
						$parts = explode("-----", $line);
						if(count($parts) >= 2) {
							$teamName = trim($parts[0]);
							$ip = trim($parts[1]);
							$points = ($teamName == $winningTeam) ? 1 : 0;
							
							if(array_key_exists($teamName, $array)){
							//if(array_key_exists($ip, $array)){
								//$array[$ip][1] += $points;
								$array[$teamName][1] += $points;
							} else {
								//$array[$ip] = [$teamName, $points];
								$array[$teamName] = [$teamName, $points];
							}
						}
					}
					fclose($handle);
				}
			}
			
			// Sort teams by wins (descending)
			uasort($array, function($a, $b) {
				return $b[1] - $a[1];
			});
			
			$handle2 = fopen("vysledky.txt", "w");
			if($handle2 !== false) {
				foreach($array as $ip => $data) {
					fwrite($handle2, $data[0]."-----".$ip."-----".$data[1].PHP_EOL);
				}
				fclose($handle2);
			}
			
			file_put_contents('kviz.txt', "");
		} else if($_POST['cmd'] == "deleteall"){
			file_put_contents('vysledky.txt', "");
		}
	}else{
echo '<!doctype html>
<html>
	<head>
		<title>Kvízové tlačítko</title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<style>
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
				background-color: #20a439;
				overflow: hidden;
			}
			img {
				width: 100%;
				height: 100%;
				object-fit: contain;
			}
			a:link, a:visited {
				background-color: #f44336;
				color: white;
				padding: 14px 25px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
			}
			a:hover, a:active {
				background-color: red;
			}
			#button {
				position: absolute;
				bottom: 0px;
				width: 100%
			}
			#button2 {
				text-align: center;
			}
			#name {
				position:absolute;
				bottom: 0px;
				left: 0;
			}
			#exit {
				position:absolute;
				bottom: 0px;
				right: 0;
			}
			#overlay
			{
				position: fixed;
				top: 0;
				left: 0;
				background-color: #000;
				opacity: 0.5;
				width: 100%;
				height: 100%;
			}
			table {
				border-collapse: collapse;
				width: 100%;
				background-color: #A2A2A2;
			}
			th, td {
				text-align: left;
				padding: 8px;
			}
			tr:nth-child(even){
				background-color: #f2f2f2;
			}
			th {
				background-color: #4CAF50;
				color: white;
			}
			h2 {
				text-align: center;
				color: white;
			}
			p {
				text-align: center;
				color: white;
			}
		</style>
		<script>
			cleanUpCheck = false;

			function onLoad() {
				new Image().src = "button-ready-low.png";
				new Image().src = "button-pushed-low.png";
				//document.getElementById("name").style.display = "none";
				//document.getElementById("exit").style.display = "none";
			}

			function fullscreen(show) {
				var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
					(document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
					(document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
					(document.msFullscreenElement && document.msFullscreenElement !== null);

				var docElm = document.documentElement;
				if (show) {
					if (docElm.requestFullscreen) {
						docElm.requestFullscreen();
					} else if (docElm.mozRequestFullScreen) {
						docElm.mozRequestFullScreen();
					} else if (docElm.webkitRequestFullScreen) {
						docElm.webkitRequestFullScreen();
					} else if (docElm.msRequestFullscreen) {
						docElm.msRequestFullscreen();
					}
				} else {
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.webkitExitFullscreen) {
						document.webkitExitFullscreen();
					} else if (document.mozCancelFullScreen) {
						document.mozCancelFullScreen();
					} else if (document.msExitFullscreen) {
						document.msExitFullscreen();
					}
				}
			}

			function onPushed(imgId)
			{
				if(imgId.src.indexOf("button-pushed-low.png") == -1) {
					imgId.src = "button-pushed-low.png";
					
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE) {
							if (xmlhttp.status == 200) {
								if(xmlhttp.responseText != ""){
									alert("Chyba: " + xmlhttp.responseText);
								} else {
									var checkExist = setInterval(function() {
										var xmlhttp = new XMLHttpRequest();
										xmlhttp.onreadystatechange = function() {
											if (xmlhttp.readyState == XMLHttpRequest.DONE) {
												if (xmlhttp.status == 200) {
													if (xmlhttp.responseText == 0) {
														document.getElementById("image").src = "button-ready-low.png";
														clearInterval(checkExist);
													} else if(xmlhttp.responseText != 1) {
														alert(xmlhttp.responseText);
													}
												} else {
													alert("Chyba: " + xmlhttp.status);
												}
											}
										};
										xmlhttp.open("POST", "./", true);
										xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
										xmlhttp.send("cmd=check");
									}, 1000);
								}
							} else {
								alert("Chyba: " + xmlhttp.status);
							}
						}
					};
					xmlhttp.open("POST", "./", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("cmd=add&name="+document.getElementById("name").innerHTML);
				}
			}

			/*function ready()
			{
				fullscreen(true);
				if(document.getElementById("name").innerHTML != "Jméno týmu") {
					document.getElementById("overlay").style.display = "none";
				}
				document.getElementById("ready").style.display = "none";
				document.getElementById("name").style.display = "block";
				document.getElementById("exit").style.display = "block";
			}*/

			function rename()
			{
				team = prompt("Zadejte jméno vašeho týmu:", "");
				if(team != "" && team != null) {
					document.getElementById("name").innerHTML = team;
					document.getElementById("overlay").style.display = "none";
				}
				fullscreen(true);
				document.getElementById("exit").innerHTML = "Odejít";
			}

			function exit()
			{
				if (document.getElementById("exit").innerHTML == "Připravit") {
					if(document.getElementById("name").innerHTML == "Jméno týmu") {
						alert("Nejprve zadejte jméno svého týmů!");
						return;
					}
					
					fullscreen(true);
					document.getElementById("overlay").style.display = "none";
					document.getElementById("exit").innerHTML = "Odejít";
				} else {
					document.getElementById("overlay").style.display = "block";
					document.getElementById("exit").innerHTML = "Připravit";
					
					//document.getElementById("image").src = "button-ready-low.png";
					cleanUpCheck = false;
					fullscreen(false);
				}
				
				/*document.getElementById("ready").style.display = "inline-block";
				document.getElementById("overlay").style.display = "block";
				document.getElementById("name").style.display = "none";
				document.getElementById("exit").style.display = "none";
				document.getElementById("image").src = "button-ready-low.png";*/
			}
		</script>
	</head>
	<body onload="onLoad();">		
		<img id="image" onclick="onPushed(this);" src="button-ready-low.png" />
		<div id="overlay"></div>
		<!--<div id="button"><div id="button2"><a id="ready" href="" onclick="ready(); return false;">Připravit</a></div></div>-->
		<a id="name" href="" onclick="rename(); return false;">Jméno týmu</a>
		<a id="exit" href="" onclick="exit(); return false;">Připravit</a>
    </body>
</html>';
	}
?>
