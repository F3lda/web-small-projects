<html>
<head>
<?php
$sloty = file_get_contents('players.txt');
if(isset($_GET['loging'])){
if(strpos($sloty, ':OFF:'. $_GET['name'] .',')!=false){
$smaz = '/:OFF:'. $_GET['name'] .',/';
$napis  = ':ON:'. $_GET['name'] .',';
$sloty2 = preg_replace($smaz, $napis, $sloty);
file_put_contents('players.txt', $sloty2);
header("location: hra.php?name=" .$_GET['name']."");
}
}
?>
</head>
<body>
<h1>hra Miner</h1>
<form action="index.php" method="get">
Jméno: <input type="text" id="namee" name="name">
<input type="submit" name="loging" value="Přihlásit se">
<?php
if(isset($_GET['login']))
{
echo "<strong><font color='red'>Nejsi přihlášen!</font></strong>";
}
if(isset($_GET['logout']))
{
echo "<strong><font color='green'>Jsi odhlášen!</font></strong>";
}

?>
</form>
</body>
</html>
