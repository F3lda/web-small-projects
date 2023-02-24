<html>
<head>
<title></title>
<style>
body {font-size: 60px; background-color: grey;}
a {text-decoration: none; color: blue}
#nadpis {position: absolute; left: 20; top: 25; background-color: royalblue; border-radius: 10px; width: 955px; font-size: 110px; text-align: center;}
#menu {position: absolute; left: 20; top: 200; background-color: red; border-radius: 10px; width: 955px; height: 800;}
#menu ul li a {font-size: 60px;}
#menu ul li {list-style: none;}
#cesky {position: absolute; left: 20; top: 200; background-color: green; border-radius: 10px; width: 915px; font-size: 80px; text-align: center;}
#preklad {position: absolute; left: 20; top: 330; background-color: teal; border-radius: 10px; width: 915px; font-size: 80px; text-align: center;}
#cislo {position: absolute; left: 20; top: 450;}
#minule {position: absolute; left: 20; top: 580; background-color: silver; border-radius: 10px; width: 213px; font-size: 80px; text-align: center;}
#dalsi {position: absolute; left: 253; top: 580; background-color: silver; border-radius: 10px; width: 213px; font-size: 80px; text-align: center;}
#nahodne {position: absolute; left: 490; top: 580; background-color: silver; border-radius: 10px; width: 447px; font-size: 80px; text-align: center;}
span a {color: black;}
</style>
<script>
var cesky = new Array();
var preklad = new Array();

var index = 0;
function prelozit(){
	document.getElementById("preklad2").innerHTML = preklad[index];
}
function minule(){
	document.getElementById("preklad2").innerHTML = "překlad";
	if(index == 0){
		index = cesky.length - 1;
	}else{
		index = index - 1;
	}
	document.getElementById("cesky").innerHTML = cesky[index];
	return cislo();
}
function dalsi(){
	document.getElementById("preklad2").innerHTML = "překlad";
	if(index == cesky.length - 1){
		index = 0;
	}else{
		index = index + 1;
	}
	document.getElementById("cesky").innerHTML = cesky[index];
	return cislo();
}
function nahodne(){
	document.getElementById("preklad2").innerHTML = "překlad";
	index = Math.floor(Math.random()*cesky.length);
	document.getElementById("cesky").innerHTML = cesky[index];
	return cislo();
}
function cislo(){
	var cislo = index + 1;
	document.getElementById("cislo").innerHTML = "Slovíčko " + cislo + "/" + cesky.length;
}
</script>
</head>
<body>
<iframe onload="document.getElementById('cesky').innerHTML = cesky[0]; cislo();" src="nacteni.php?sada=<?php echo $_GET['sada']; ?>" style="display: none;"></iframe>
<span id="nadpis">Sada: <?php echo $_GET['sada']; ?></span>
<div id="menu">
<ul>
	<li><a href="slovicka.php">ZPĚT K SADÁM</a></li>
</ul>
<span id="cesky">.</span>
<span id="preklad"><a href="#" id="preklad2" onclick="prelozit(); return false;">překlad</a></span>
<span id="cislo">.</span>
<span id="dalsi"><a href="#" onclick="dalsi(); return false;">Další slov.</a></span>
<span id="minule"><a href="#" onclick="minule(); return false;">Min. slov.</a></span>
<span id="nahodne"><a href="#" onclick="nahodne(); return false;">Náhodné slovíčko</a></span>
</div>
</body>
</html>