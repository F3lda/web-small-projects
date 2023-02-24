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
	
	//$user_os        =   getOS($_SERVER['HTTP_USER_AGENT']);
	//$user_browser   =   getBrowser($_SERVER['HTTP_USER_AGENT']);

	if(isset($_GET['vyhodnoceni'])){
		echo '<!doctype html>
<html>
	<head>
		<title>Kvíz - vyhodnocení</title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="js.js"></script>
	</head>
	<body>		
		<h2>Vyhodnocení</h2>
		<table id="results">
		  <tr>
			<th>Jméno týmu</th>
			<th>Počet výher</th>
			<th>Celkové pořadí</th>
		  </tr>';
			$file = fopen("vysledky.txt", "r");
			if($file != false) {
				$i = 1;
				while (($line = fgets($file)) !== false) {
					echo "<tr><td>".trim(explode("-----",$line)[0])."</td><td>".trim(explode("-----",$line)[2])."</td><td>".$i++.".</td></tr>".PHP_EOL;
				}
				fclose($file);
			} else {
				echo 9;
			}
echo'		</table>
		<div id="button"><div id="button2"><a href="" onclick="deleteAll(); return false;">Vynulovat vyhodnocení</a></div></div>
    </body>
</html>';
	} else if(isset($_GET['vysledky'])) {
		echo '<!doctype html>
<html>
	<head>
		<title>Kvíz - výsledky</title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="js.js"></script>
	</head>
	<body onload="resutlsCheck();">		
		<h2>Výsledky kola</h2>
		<table id="results">
		  <tr>
			<th>Pořadí</th>
			<th>Jméno týmu</th>
		  </tr>
		</table>
		<div id="button"><div id="button2"><a href="" onclick="restart(); return false;">Vynulovat</a></div></div>
    </body>
</html>';
	} else if(isset($_POST['cmd'])){
		if($_POST['cmd'] == "add"){
			$team = "";
			if(isset($_POST['name'])) {
				$team = $_POST['name'];
			} else {
				echo 1;
			}
			$new = $team."-----".$_SERVER['REMOTE_ADDR'].PHP_EOL;
			
			$already = false;
			$file = fopen("kviz.txt", "r");
			if($file != false) {
				while (($line = fgets($file)) !== false) {
					if(explode("-----",$line)[1] == $_SERVER['REMOTE_ADDR'].PHP_EOL){
						$already = true;
					}
				}
				fclose($file);
			} else {
				echo 2;
			}
			
			if($already == false) {
				$handle = fopen("kviz.txt", "a");
				if($handle != false) {
					fwrite($handle, $new);
					fclose($handle);
				} else {
					echo 3;
				}
			}
		} else if($_POST['cmd'] == "check"){
			$wait = false;
			$file = fopen("kviz.txt", "r");
			if($file != false) {
				while (($line = fgets($file)) !== false) {
					if(explode("-----",$line)[1] == $_SERVER['REMOTE_ADDR'].PHP_EOL){
						$wait = true;
					}
				}
				fclose($file);
				
				if($wait){
					echo 1;
				} else {
					echo 0;
				}
			} else {
				echo 4;
			}
		} else if($_POST['cmd'] == "preResults"){
			$file = fopen("kviz.txt", "r");
			if($file != false) {
				$i = 1;
				while (($line = fgets($file)) !== false) {
					echo "<tr onclick='save(\"".trim(explode("-----",$line)[0])."\");'><td>".$i++.".</td><td>".trim(explode("-----",$line)[0])."</td></tr>".PHP_EOL;
				}
				fclose($file);
			} else {
				echo 5;
			}
		} else if($_POST['cmd'] == "delete"){
			file_put_contents('kviz.txt', "");
		} else if($_POST['cmd'] == "save"){		
			$array;
			$file = fopen("vysledky.txt", "r");
			if($file != false) {
				while (($line = fgets($file)) !== false) {
					$array[trim(explode("-----",$line)[1])] = [trim(explode("-----",$line)[0]),trim(explode("-----",$line)[2])];
				}
				fclose($file);
			} else {
				echo 6;
			}
			
			$handle = fopen("kviz.txt", "r");
			if($handle != false) {
				while (($line = fgets($handle)) !== false) {
					$i = 0;
					if(trim(explode("-----",$line)[0]) == $_POST['team']){
						$i++;
					}
					
					if(array_key_exists(trim(explode("-----",$line)[1]),$array)){
						$array[trim(explode("-----",$line)[1])][1] += $i;
					} else {
						$array[trim(explode("-----",$line)[1])] = [trim(explode("-----",$line)[0]), $i];
					}
				}
				fclose($handle);
			} else {
				echo 7;
			}
			
			$arrayIPs;
			$i = 0;
			foreach($array as $key => $value)
			{
				$arrayIPs[$i++] = $key;
			}
			
			$newArray;
			for($i = 0; $i < count($arrayIPs); $i++){
				$bestIP = "";
				for($ii = 0; $ii < count($arrayIPs); $ii++){
					if($array[$arrayIPs[$ii]][1] != 0){
						if($bestIP == ""){
							$bestIP = $arrayIPs[$ii];
						} else {
							if($array[$bestIP][1] < $array[$arrayIPs[$ii]][1]){
								$bestIP = $arrayIPs[$ii];
							}
						}
					}
				}
				
				$newArray[$i] = [$array[$bestIP][0],$bestIP,$array[$bestIP][1]];
				$array[$bestIP][1] = 0;
			}
			
			$handle2 = fopen("vysledky.txt", "w");
			if($handle2 != false) {
				for($i = 0; $i < count($newArray); $i++){
					fwrite($handle2, $newArray[$i][0]."-----".$newArray[$i][1]."-----".$newArray[$i][2].PHP_EOL);
				}
				fclose($handle2);
			} else {
				echo 8;
			}
			
			file_put_contents('kviz.txt', "");
		} else if($_POST['cmd'] == "deleteall"){
			file_put_contents('vysledky.txt', "");
		}
	}else{
echo '<!doctype html>
<html>
	<head>
		<title>Filmový kvíz</title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="js.js"></script>
	</head>
	<body onload="onLoad();">		
		<img id="image" onclick="onPushed(this);" src="button-ready-low.png" />
		<div id="overlay"></div>
		<div id="button"><div id="button2"><a id="ready" href="" onclick="ready(); return false;">Připravit</a></div></div>
		<a id="name" href="" onclick="rename(); return false;">Jméno týmu</a>
		<a id="exit" href="" onclick="exit(); return false;">Konec</a>
    </body>
</html>';
	}
?>
