<html>
<head>
<title></title>
<script>
var cesky = new Array(<?php $data = file("./sady/". $_GET['sada'] .".txt"); $words = count($data); for($i = 1; $i <= $words; $i++){$word = explode('=', $data[$i-1]); if($i != $words){echo '"'. $word[0] .'", ';}else{echo '"'. $word[0] .'"';}} ?>);
var preklad = new Array(<?php $data = file("./sady/". $_GET['sada'] .".txt"); $words = count($data); for($i = 1; $i <= $words; $i++){$word = explode('=', $data[$i-1]); if($i != $words){echo '"'. $word[1] .'", ';}else{echo '"'. $word[1] .'"';}} ?>);

for(i = 0; i < cesky.length; i++)
{
	parent.cesky[i] = cesky[i];
	parent.preklad[i] = preklad[i];
}
</script>
</head>
<body>
</body>
</html>