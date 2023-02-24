<html>
<head>
</head>
<body onload="pis()">
<?php
$server = file_get_contents('players.txt');
?>
<script>
parent.data = '<?php echo $server; ?>';
</script>
<?php
$sloty = file_get_contents('players.txt');
if(isset($_GET['rel'])){
echo $_POST['xx'];
echo "-";
echo $_POST['yy'];
echo "-";
echo $_POST['strana'];
echo "-";
echo $_POST['name'];
echo "-";
echo $_POST['status'];

$smaz = '/'. $_POST['name'] .':(.*?.):'. $_POST['name'] .',/';
$napis  = ''. $_POST['name'] .':'. $_POST['xx'] .':'. $_POST['yy'] .':'. $_POST['strana'] .':'. $_POST['status'] .':'. $_POST['name'] .',';
$sloty2 = preg_replace($smaz, $napis, $sloty);
file_put_contents('players.txt', $sloty2);
}
?>
<br>
<script>
var xx = parent.x;
var yy = parent.y;
var player = parent.name;
var strana = parent.str;
var stats = parent.status;
document.write(xx);
document.write("-");
document.write(yy);
document.write("-");
document.write(strana);
document.write("-");
document.write(player);
document.write("-");
document.write(stats);
function pis(){
document.getElementById('xxx').value = xx;
document.getElementById('yyy').value = yy;
document.getElementById('pname').value = player;
document.getElementById('str').value = strana;
document.getElementById('stav').value = stats;
}
window.setTimeout("document.form.submit();", 1000);
</script>

<form name="form" action="data.php?rel=rel" method="post">
X: <input type="text" id="xxx" name="xx" value=""><br>
Y: <input type="text" id="yyy" name="yy" value=""><br>
Name: <input type="text" id="pname" name="name" value=""><br>
Strana: <input type="text" id="str" name="strana" value=""><br>
Stav: <input type="text" id="stav" name="status" value="">
</form>
</body>
</html>
