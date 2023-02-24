<html>
<head>
<title></title>
<style>
body {font-size: 110px; background-color: grey;}
a {text-decoration: none; color: blue}
#nadpis {position: absolute; left: 20; top: 25; background-color: royalblue; border-radius: 10px; width: 955px;}
#mojesady {position: absolute; left: 110; top: 300; font-size: 85px; background-color: green; border-radius: 10px; color: black;}
#novasada {position: absolute; left: 85; top: 550; font-size: 85px; background-color: green; border-radius: 10px; z-index: 2;}
#soubor {position: absolute; left: 30; top: 750; font-size: 50px; z-index: 2;}
#jmeno {position: absolute; left: 350; top: 850; font-size: 50px; z-index: 2;}
#name {position: absolute; left: 30; top: 850; font-size: 50px; z-index: 2;}
#odeslat {position: absolute; left: 400; top: 950; font-size: 50px; z-index: 2;}
#form {position: absolute; left: 30; top: 530; background-color: khaki; border-radius: 10px; width: 935px; height: 490px; z-index: 1;}
#menu {position: absolute; left: 20; top: 290; background-color: red; border-radius: 10px; width: 955px; height: 740px;}
#request {position: absolute; left: 33; top: 1050; font-size: 50px; max-width: 900px;}
</style>
<script>
function kontrola(Form)
	{
	var c,i,x,p,reg; i=-1; c=new Array();
	
	x = "jmeno";
	p = Form[x].value;
	if (p == ""){i++;c[i] = "Název sady: nevyplněn!";}

	x = "sada";
	p = Form[x].value;
	if (p == ""){i++;c[i] = "Sada: soubor nevybrán!";}

	if (i>=0) {alert(c.join("\n")); return false;}
	else	  {return true;}
	}
</script>
</head>
<body>
<div id="form"></div>
<div id="menu"></div>
<span id="nadpis">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Slovíčkář</span>
<span id="mojesady"><a href="slovicka.php">Moje sady slovíček</a></span>
<span id="novasada">Přidat sadu slovíček</span>
<form action="index.php" method="post" enctype="multipart/form-data" onsubmit="return kontrola(this);">
<input id="soubor" name="sada" type="file">
<span id="name">Název sady: </span><input id="jmeno" name="jmeno" type="text" size="13">
<input id="odeslat" name="submit" type="submit" value="Přidat">
</form>
<div id="request">
<?php
$typ = "text/plain";
$misto = "./sady/";

if($_SERVER["REQUEST_METHOD"] == "POST"){
if($_FILES['sada']['type'] == $typ){
$soubor = move_uploaded_file($_FILES['sada']['tmp_name'], $misto . $_POST['jmeno'] . ".txt");

if($soubor == "true"){
echo "Sada <strong>" .$_FILES['sada']['name']. "</strong> byla úspěšně nahrána a uložena jako <strong>" .$_POST['jmeno']. "</strong>.<br>";
}else{
echo "Někde se stala <strong>chyba</strong>, nic se nenehrálo!";
}
}else{
echo 'Lze nahrávat pouze soubory typu <strong>.txt</strong>!';
}
}
?>
</div>
</body>
</html>