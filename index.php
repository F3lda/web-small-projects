<!DOCTYPE html>
<html>
	<head>
		<title>Small Web Projects</title>
	</head>
	<body>
		<h1>Small Web Projects:</h1>
		<ul>
			<?php 
				foreach (array_diff(scandir('.'), array('.', '..', 'index.php')) as $item)
				{
					echo '<li><a href="./'.$item.'">'.$item.'</a></li>';
				}
			?>
		</ul>
	</body>
</html>
