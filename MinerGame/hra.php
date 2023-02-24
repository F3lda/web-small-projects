<html>
<head>
</head>
<body id="body" onload="window.setTimeout('pozicuj(); kdeje();', 1000);" onkeypress="pohyb(event)">
<iframe name="data" src="data.php"></iframe>
<script>
var status = "ON";

var data = "";
function pozicuj(){
var sloty = data.split(",");

for(var i = 0; i < sloty.length; i ++){
var slot = sloty[i].split(":");
if(sloty[i] != ""){
if(slot[4] == "ON"){
if(slot[0] != "<?php echo $_GET['name']; ?>"){
	if(document.getElementById(slot[0])){
	document.getElementById(slot[0]).style.left = slot[1];
	document.getElementById(slot[0]).style.top = slot[2];
	document.getElementById(slot[0]).src = "miner"+ slot[3] +".png";
	}
	else
	{
	c = document.createElement("img");
    a = document.createAttribute("src");
	a.value = "miner"+ slot[3] +".png";
	b = document.createAttribute("style");
	b.value = "position: absolute; left: "+ slot[1] +"px; top: "+ slot[2] +"px; width: 120px; height: 200px";
	c2 = document.createAttribute("id");
	c2.value = slot[0];
	d = document.createAttribute("alt");
	d.value = slot[0];

    parentObj = document.getElementById("body");
    parentObj.appendChild(c);
    c.setAttributeNode(a);
    c.setAttributeNode(b);
    c.setAttributeNode(c2);
    c.setAttributeNode(d);
	}

}else if(!document.getElementById('<?php echo $_GET['name']; ?>')){
	c2 = document.createElement("img");
	a2 = document.createAttribute("src");
	a2.value = "miner"+ slot[3] +".png";
	b2 = document.createAttribute("style");
	b2.value = "position: absolute; left: "+ slot[1] +"px; top: "+ slot[2] +"px; width: 120px; height: 200px";
	c22 = document.createAttribute("id");
	c22.value = "<?php echo $_GET['name']; ?>";
	d2 = document.createAttribute("alt");
	d2.value = "<?php echo $_GET['name']; ?>";

	parentObj2 = document.getElementById("body");
	parentObj2.appendChild(c2);
	c2.setAttributeNode(a2);
	c2.setAttributeNode(b2);
	c2.setAttributeNode(c22);
	c2.setAttributeNode(d2);
}
}
}
}
window.setTimeout("pozicuj();", 1000);
}
</script>
<?php
if(isset($_GET['name'])){echo "<a href='' onclick='logout(); return false'>Odhlásit se</a>";
}else{header("location: ./index.php?login=out");}
?>
<script>
function logout(){
status = "OFF";
alert(status + "\n Za tři vteřiny budeš odhlášen.");
window.setTimeout("window.location.href = './index.php?logout=out'", 3000);
}
</script>
<script>
var name = "<?php echo $_GET['name']; ?>";
var str = "L";
function pohyb(e){
var pelement = document.getElementById("<?php echo $_GET['name']; ?>");
if(status == "ON"){
if(String.fromCharCode(e.charCode) == "w"){pelement.style.top = parseInt(pelement.style.top)+ -200 +"px"; str = "vP"; document.getElementById("<?php echo $_GET['name']; ?>").src = "minervP.png"; return kdeje()}
if(String.fromCharCode(e.charCode) == "s"){pelement.style.top = parseInt(pelement.style.top)+ 200 +"px"; str = "Z"; document.getElementById("<?php echo $_GET['name']; ?>").src = "minerZ.png"; return kdeje()}
if(String.fromCharCode(e.charCode) == "a"){pelement.style.left = parseInt(pelement.style.left)+ -120 +"px"; str = "L"; document.getElementById("<?php echo $_GET['name']; ?>").src = "minerL.png"; return kdeje()}
if(String.fromCharCode(e.charCode) == "d"){pelement.style.left = parseInt(pelement.style.left)+ 120 +"px"; str = "P"; document.getElementById("<?php echo $_GET['name']; ?>").src = "minerP.png"; return kdeje()}
}
}
var x = 0;
var y = 0;
function kdeje(){
x = 0;
y = 0;
var element = document.getElementById("<?php echo $_GET['name']; ?>")
while (element != null){
x += element.offsetLeft - element.scrollLeft;
y += element.offsetTop - element.scrollTop;
element = element.offsetParent;}
}
</script>
</body>
</html>
