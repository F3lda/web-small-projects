<html>
<head>
<meta http-equiv="cache-control" content="no-cache">
<script>
function kontrola(Form)
	{
	var c,i,x,p,reg; i=-1; c=new Array();
	
	x = "name";
	p = Form[x].value;
	if (p == ""){i++;c[i] = "Jméno: nevyplněno!";}

	x = "text";
	p = Form[x].value;
	if (p == ""){i++;c[i] = "Zpráva: nevyplněno!";}

	if (i>=0) {alert(c.join("\n")); return false;}
	else	  {return true;}
	}
</script>
</head>
<body>
<div style="position: absolute; top: 17px; left: 16px; height:350px; width:245px; border:none; background:white; display:none;" id="setting">
<h2><center>Nastavení chatu</center></h2>
<center><p>Chat <input type="text" value="je zapnutý!" id="off" size="6" disabled></p></center>
<center><a onclick="document.getElementById('chat').src = 'off.php'"><input type="button" title="Chat se nebude aktualizovat." value="Vypnout chat" onclick="document.getElementById('off').value = 'je vypnutý!'"></a>
<a onclick="document.getElementById('chat').src = 'chat.php'"><input type="button" value="Zapnout chat" onclick="document.getElementById('off').value = 'je zapnutý!'"></a></center>
<form action="index.php" name="form" method="post" target="ifrejm" onsubmit="return kontrola(this)"><center><p>Zadej jméno: <input type="text" name="name" id="name" size="10"></p></center><br><br><br><br><br><br>
<center><input type="button" value="Zpět" title="Zpět na chat" onclick="document.getElementById('setting').style.display = 'none'"></center>
</div><input type="hidden" id="time" value="" name="time">
<table border="2">
<tr><td width="250"><iframe src="chat.php" width="245" height="350" id="chat"></iframe></td><td width="120"><iframe src="online.php" width="115" height="350"></iframe></td></tr>
<tr><td width="250"><input name="text" type="text" size="35" onmousedown="if(event.button == '0'){document.form.text.value = ''}"></td><td width="120"><center><input type="submit" name="odeslat" value="Odeslat" onclick="kontrola()"></form><input id="submit" name="submit" type="button" value="=>!!!" title="Nastavení" onclick="document.getElementById('setting').style.display = 'block'"></center></td></tr>
</table>
<?php
if(isset($_POST['odeslat'])){
$text1 = '<tr><td><strong>' .$_POST['name']. '</strong><code>(' .$_POST['time']. ')</code><strong>:</strong> ' .$_POST['text']. '<br></td></tr>
';
$text2 = file_get_contents('chat.txt');
$text =  $text2 . $text1;
file_put_contents('chat.txt', $text);
}
?>
<script>
var datum = new Date();
min = "0";
minut = datum.getMinutes();
if(minut < 10){min = "0"}else{min = ""};
var retezec = "čas: " + datum.getHours() + ":";
retezec += min + datum.getMinutes();
document.getElementById("time").value = retezec;
</script>
<a href="./../">Zpět</a>
<iframe name="ifrejm" style="visibility: hidden" width="0" height="0"></iframe>
</body>
</html>