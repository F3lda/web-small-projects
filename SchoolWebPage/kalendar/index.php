<?php
define("BR", "
");

$address = "../";
$filesaddress = "../files/";
$filename = "./content/calendar/";

/*$year = (int) Date("Y");
$month = (int) Date("n");
$day = (int) Date("j");*/

function isInteger($input){
	return(ctype_digit(strval($input)));
}

function JePrechodnyRok($rok)
{
  return (boolean) date("L", mktime(0,0,0,1,1,$rok));
}

function PocetDnuVMesici($mesic, $rok)
{
	return cal_days_in_month(CAL_GREGORIAN, $mesic, $rok);
}

function PrvniDenDenVMesici($mesic, $rok)
{
	$anglickeporadi = date("w", mktime(0, 0, 0, $mesic, 1, $rok));
	return ($anglickeporadi==0) ? 7 : $anglickeporadi;
}

function SchoolYear1($year,$month)
{
	if($month > 8){
	}else if($month < 7){
		$year--;
	}else{
		$year = -1;
	}
	return $year;
}

function SchoolYearExist($filesaddress,$year)
{
	$year = str_replace("/", ",", $year);
	$files = scandir($filesaddress.'content/calendar/', 1);
	for($i = 0; $i < count($files); $i++)
	{
		if($files[$i] == $year){
			return 1;
		}
	}
	return 0;
}

/*----- CALENDAR -----*/
function SchoolYears($filesaddress,$schoolyear)
{
	$files = scandir($filesaddress.'content/calendar/', 1);
	$year_selected = false;
    echo '<select onchange="location.href=this.options[this.selectedIndex].value">';
	for($i = 0; $i < count($files); $i++)
	{
		if($files[$i] != '.' && $files[$i] != '..'){
			$array = explode(',',$files[$i]);
			if($schoolyear == $array[0]){
                $year_selected = true;
				echo '<option value="./?date='. str_replace(",", "/", $files[$i]) .'" selected="selected">';
			}else{
				echo '<option value="./?date='. str_replace(",", "/", $files[$i]) .'">';
			}
			echo str_replace(",", "/", $files[$i]);
			echo '</option>';
		}
	}
    if($year_selected == false){
        echo '<option value="./" selected="selected">Vyberte rok</option>';
    }
	echo '</select>';
}

function YearCalendar($year,$filesaddress)
{
	$path_year = $year;
	$month = 8;
	$months = array("Září", "Říjen", "Listopad", "Prosinec", "Leden", "Únor", "Březen", "Duben", "Květen", "Červen");
	echo BR.'				<table id="calendar">'.BR;
	echo '					<tr>'.BR;
	echo '						<td colspan="4"><h1><a href="./?date='.$year.'/'.($year+1).'">Školní rok '.$year.'/'.($year+1).'</a></h1></td>'.BR;
	echo '					</tr>'.BR;
	echo '					<tr>'.BR;
	for($i = 0; $i < 10; $i++)
	{
		if($i % 4 == 0 && $i != 0){
			echo '					</tr>' .BR. '					<tr>'.BR;
		}
		if($i == 8){
			echo '						<td></td>'.BR;
		}
		echo '						<td class="border">'.BR;
		$month++;
		if($month == 13){
			$month -= 12;
			$year++;
		}
		$data = file($filesaddress.'content/calendar/'.$path_year.','.($path_year+1).'/'.$month.'.txt');
		if($month < 10){
			$month_temp = '0'.$month;
		}else{
			$month_temp = $month;
		}
		echo '							<table class="subcalendar">
								<tr>
									<td class="month" colspan="8"><a href="./?date=00'. $month_temp.$path_year .'">' .$months[$i]. ' ' .$year. '</a></td>
								</tr>
								<tr>
									<th></th>
									<th title="Pondělí">Po</th>
									<th title="Úterý">Út</th>
									<th title="Středa">St</th>
									<th title="Čtvrtek">Čt</th>
									<th title="Pátek">Pá</th>
									<th title="Sobota">So</th>
									<th title="Neděle">Ne</th>
								</tr>'.BR;
		$day = (PrvniDenDenVMesici($month,$year)*-1)+2;
		for($ii = 0; $ii < ceil((PrvniDenDenVMesici($month,$year)-1+PocetDnuVMesici($month,$year))/7); $ii++)/* sloupce */
		{
			echo '								<tr>'.BR;
			echo '								<td  title="Zobraz tento týden" class="show_week"><a href="#"> </a></td>'.BR;
			for($iii = 1; $iii < 8; $iii++)/* řádky */
			{
				$day_tmp = $day;
				if($day_tmp < 10){
					$day_tmp = '0'.$day_tmp;
				}
				if($day > 0 && PocetDnuVMesici($month,$year) >= $day){
					if($day > 0 && count($data) > ($day-1) && $data[$day-1] != "" && $data[$day-1] != BR){
						echo '									<td><a class="notice" href="./?date='.$day_tmp.$month_temp.$path_year.'">' .$day. '</a></td>'.BR;
					}else{
						echo '									<td><a href="./?date='.$day_tmp.$month_temp.$path_year.'">' .$day. '</a></td>'.BR;
					}
				}else{
					echo '									<td> </td>'.BR;
				}
				$day++;
			}
			echo '								</tr>'.BR;
		}
		echo '							</table>'.BR;
		echo '						</td>'.BR;
	}
	echo '					</tr>'.BR.'				</table>';
}
?>
<?php include $filesaddress ."head.txt"; ?>
	<title>Kalendář | <?php include $filesaddress ."title.txt"; ?></title>
	<link rel="shortcut icon" href="../styles/favicon.ico" />
	<link rel="stylesheet" href="../styles/styles.css" />
	<script type="text/javascript">
	</script>
</head>
<body id="main">
<?php include $filesaddress ."menu.txt"; ?>
	<div id="rightmenu">
		<ul class="normal_list">
			<li class="list_title">Kalendář</li>
			<li>Školní rok: <?php if(isset($_GET['date']) && strstr($_GET['date'], '/') && SchoolYearExist($filesaddress,$_GET['date'])){$array_tmp = explode('/', $_GET['date']); SchoolYears($filesaddress,$array_tmp[0]);}else if(isset($_GET['date']) && isInteger($_GET['date'])){$year = ltrim(substr($_GET['date'], 4),"0"); if(SchoolYearExist($filesaddress,$year.'/'.($year+1))){SchoolYears($filesaddress,$year);}}else{SchoolYears($filesaddress,SchoolYear1(Date("Y"),Date("n")));} ?></li>
			<li>Zobraz:</li>
			<li><a href="./?date=<?php if(Date('m') < 7){echo Date('dm'); echo Date('Y')-1;}else{echo Date('dmY');} ?>">Dnes</a></li>
			<li><a href="#">Zítra (nefunguje)</a></li>
			<li><a href="#">Tento týden (nefunguje)</a></li>
			<li><a href="./?date=<?php if(Date('m') < 7){echo '00'.Date('m'); echo Date('Y')-1;}else{echo '00'.Date('mY');} ?>">Tento měsíc</a></li>
			<li><a href="./">Tento školní rok</a></li>
		</ul>
<?php include $filesaddress ."right_menu.txt"; ?>
	</div>
	<div id="text2">
		<div id="text">
			<?php
				if(isset($_GET['date'])){
					$date = $_GET['date'];
					if(strstr($date, '/') && SchoolYearExist($filesaddress,$date)){/* Zobraz ŠKOLNÍ ROK */
						$array_tmp = explode('/',$date);
						YearCalendar($array_tmp[0],$filesaddress);
					}else if(isInteger($date)){
						$day = ltrim(substr($date, 0, 2),"0");
						$month = ltrim(substr($date, 2, 2),"0");
						$year = ltrim(substr($date, 4),"0");
						if($month == 7 || $month == 8){
							echo '<br /><h1 id="cal_month_h1"><a href="#">Jsou prázdniny!</a></h1>'.BR;
							echo '			<br /><p id="pagelist">[<a class="blue" href="'. $address .'" onclick="history.back(); return false;">Zpět</a>]</p>'.BR;
						}else if($day == NULL && $month > 0 && $year > 0 && $month < 12 && $year < 32767 && SchoolYearExist($filesaddress,$year.'/'.($year+1))){/* Zobraz MĚSÍC */
							$months = array("leden", "únor", "březen", "duben", "květen", "červen", "", "", "září", "říjen", "listopad", "prosinec");
							$days = array("Po", "Út", "St", "Čt", "Pá", "So", "Ne");
							$data = file($filesaddress.'content/calendar/'.$year.','.($year+1).'/'.$month.'.txt');
							$month_tmp = $month;
							if($month < 10){
								$month_tmp = '0'.$month_tmp;
							}
							echo '<br /><h1 id="cal_month_h1"><a href="./?date=00'.$month_tmp.$year.'">Školní rok '.$year.'/'.($year+1).' - '. $months[$month-1] .'</a></h1>'.BR;
							$year_tmp = $year;
							if($month < 7){
								$year++;
							}
							echo '				<table id="cal_month">'.BR;
							for($i = 0; $i < PocetDnuVMesici($month,$year); $i++)
							{
								$day_tmp = $i+1;
								if($day_tmp < 10){
									$day_tmp = '0'.$day_tmp;
								}
								$dayy = date("w", mktime(0, 0, 0, $month, $i, $year));
								if(count($data) > $i && $data[$i] != BR && $data[$i] != ""){
									if($i % 2 == 0){
										echo '					<tr><td class="notice"><a href="./?date='.$day_tmp.$month_tmp.$year_tmp.'">'. ($i+1) .'<br />'.$days[$dayy].'</a></td><td class="pink2">'. $data[$i] .'</td></tr>'.BR;
									}else{
										echo '					<tr><td class="notice"><a href="./?date='.$day_tmp.$month_tmp.$year_tmp.'">'. ($i+1) .'<br />'.$days[$dayy].'</a></td><td>'. $data[$i] .'</td></tr>'.BR;
									}
								}else{
									if($i % 2 == 0){
										echo '					<tr><td class="normal"><a href="./?date='.$day_tmp.$month_tmp.$year_tmp.'">'. ($i+1) .'<br />'.$days[$dayy].'</a></td><td class="pink2"></td></tr>'.BR;
									}else{
										echo '					<tr><td class="normal"><a href="./?date='.$day_tmp.$month_tmp.$year_tmp.'">'. ($i+1) .'<br />'.$days[$dayy].'</a></td><td></td></tr>'.BR;
									}
								}
							}
							echo '				</table>'.BR;
							echo '			<br /><p id="pagelist">[<a class="blue" href="'. $address .'" onclick="history.back(); return false;">Zpět</a>]</p>'.BR;
						}else if($day < 32 && $month < 13 && $year < 32768 && $day > 0 && $month > 0 && $year > 0 && checkdate($month, $day, $year) && SchoolYearExist($filesaddress,$year.'/'.($year+1))){/* Zobraz DEN */
							$months = array("ledna", "února", "března", "dubna", "května", "června", "", "", "září", "října", "listopadu", "prosinece");
							$days = array("pondělí", "úterý", "středa", "čtvrtek", "pátek", "sobota", "neděle");
							$data = file($filesaddress.'content/calendar/'.$year.','.($year+1).'/timetable.txt');
							$data2 = file($filesaddress.'content/calendar/'.$year.','.($year+1).'/'. $month .'.txt');
							$month_tmp = $month;
							if($month_tmp < 10){
								$month_tmp = '0'.$month_tmp;
							}
							$day_tmp = $day;
							if($day_tmp < 10){
								$day_tmp = '0'.$day_tmp;
							}
							$dayy = date("w", mktime(0, 0, 0, $month, $day, $year));
							if($dayy < 5){
								$data = explode(";",$data[$dayy]);
								if(count($data2) > $day-1){
									$data2 = explode(";",$data2[$day-1]);
								}else{
									$data2 = 0;
								}
								echo '<br /><h1 id="cal_month_h1"><a href="./?date='.$day_tmp.$month_tmp.$year.'">Školní rok '.$year.'/'.($year+1).' - '.$day.'. '.$months[$month-1] .', '.$days[$dayy].'</a></h1>'.BR;
								echo '				<table id="cal_day">'.BR;
								for($i = 0; $i < count($data)-1; $i++)
								{	
									echo '					<tr>'.BR;
									if(count($data2) > $i && $data2[$i] != "" && $data2[$i] != BR){
										echo '						<th class="notice">'.$data[$i].'</th>'.BR;
									}else{
										echo '						<th>'.$data[$i].'</th>'.BR;
									}
									if(count($data2) > $i && $data2[$i] != "" && $data2[$i] != BR){
										if($i % 2 == 0){
											echo '						<td class="nd">'.$data2[$i].'</td>'.BR;
										}else{
											echo '						<td>'.$data2[$i].'</td>'.BR;
										}
									}else{
										if($i % 2 == 0){
											echo '						<td class="nd"></td>'.BR;
										}else{
											echo '						<td></td>'.BR;
										}
									}
									echo '					</tr>'.BR;
								}
								echo '				</table>'.BR;
								echo '			<br /><p id="pagelist">[<a class="blue" href="'. $address .'" onclick="history.back(); return false;">Zpět</a>]</p>'.BR;
							}else{
								echo '<br /><h1 id="cal_month_h1"><a href="./?date='.$day_tmp.$month_tmp.$year.'">Školní rok '.$year.'/'.($year+1).' - '.$day.'. '.$months[$month-1] .', '.$days[$dayy].'</a></h1>'.BR;
								echo '				<table id="cal_day">'.BR;
								if(count($data2) > $day-1){
									$data2 = explode(";",$data2[$day-1]);
								}else{
									$data2 = 0;
								}
								if($data2[0] == ""){
									echo '					<tr><td>Na tento den nemusíš nic dělat!</td></tr>'.BR;
								}else{
									echo '					<tr><td>'.$data2[0].'</td></tr>'.BR;
								}
								echo '				</table>'.BR;
								echo '			<br /><p id="pagelist">[<a class="blue" href="'. $address .'" onclick="history.back(); return false;">Zpět</a>]</p>'.BR;
							}
						}else{
							header("Location: ". $address ."kalendar/");
						}
					}else if(strstr($date, 'w') && checkdate(ltrim(substr(str_replace("w", "", $date), 2, 2),"0"), ltrim(substr(str_replace("w", "", $date), 0, 2),"0"), ltrim(substr(str_replace("w", "", $date), 4),"0"))){/* Zobraz TÝDEN */
						/* Zobraz TÝDEN */
						$day = ltrim(substr($date, 0, 2),"0");
						$month = ltrim(substr($date, 2, 2),"0");
						$year = ltrim(substr($date, 4),"0");
						if(($day > 31 || $month > 12 || $year > 32767) || !checkdate($month, $day, $year)){
							header("Location: ". $address ."kalendar/");
						}
						echo 'Zobraz týden!<br />';
					}else{
						header("Location: ". $address ."kalendar/");
					}
				}else{
                    if(SchoolYearExist($filesaddress,Date("Y"))){
					    YearCalendar(SchoolYear1(Date("Y"),Date("n")),$filesaddress);
                    } else {
                        echo "<H3>Vyberte platný školní rok!</H3>";
                    }
				}
			?>
			
			<br />
		</div>
		<p id="footer"><?php include $filesaddress ."footer.txt"; ?></p>
	</div>
</body>
</html>