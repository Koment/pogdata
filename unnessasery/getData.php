<?php
@header ("Content-Type: text/html; charset=UTF-8");

// @header ("Content-Type: text/html; charset=windows-1251");

include 'simple_html_dom.php';

/*

var cityes = ['jankoy', 'feodosia', 'evpatoria', 'yalta', 'kerch', 'sevastopol', 'simferopol'];

'h2.location-title__place, strong.forecast-details__day-number, span.temp__value, td.weather-table__body-cell_type_condition'

*/

$cityes = ["simferopol" => "", "sevastopol" => "", "yalta" => "", "kerch" => "", "feodosia" => "", "sudak" => "", "evpatoria" => "",  "chernomorskoe" => "", "jankoy" => "", "krasnoperekopsk" => "", "armyansk" => ""];

$site = '';

$month = [];

if (isset($_POST['ya'])){

	$site = 'Yandex!';

	$days = $_POST['ya'];

	// echo 'days = <br>';
	//
	// print_r($days);
	//
	// echo '<br>';

	foreach($days as $key => $day){

		$month[explode('-', $day)[0]] = explode('-', $day)[1];

		$days[$key] = explode('-', $day)[0];

	}

	// echo 'days 2 = <br>';
	//
	// print_r($month);
	//
	// print_r($days);
	//
	// echo '<br>';
	//
	// die();

	foreach ($cityes as $key => $val) {

		$data = file_get_html('https://yandex.ru/pogoda/'. $key .'/details');

		foreach ($days as $day) {
			# code...

				for ($i = 0; $i < 10; $i++){

					// $month[$day] = mb_substr($data->find('span.forecast-details__day-month', $i)->plaintext, 0, 3);

					// $search = explode(" ", $data->find('dt.forecast-details__day', $i)->plaintext)[0];
					//
					// echo 'search = ' . $search;
					//
					// die();
					//
					// preg_match("/\d+/", $search, $match);

					if (trim($data->find('strong.forecast-details__day-number', $i)->plaintext) == $day) {

						$curvals = $data->find('table.weather-table', $i);

						$tmp = [

							'pog' => $curvals->find('td.weather-table__body-cell_type_condition', 1)->plaintext,
							'tempDay' => dropHellip($curvals->find('div.weather-table__temp', 1)->plaintext),
							'tempNight' => dropHellip($curvals->find('div.weather-table__temp', 3)->plaintext),
							'wind' => transWind($curvals->find('div.weather-table__wrapper', 3)->plaintext),

						];

						$cityes[$key][$day] = $tmp;

						break;
					}

				}

			}

		}

		// echo 'ya data start <br>';
		//
		// print_r($month);
		//
		// echo '<br>ya data end';

	// for ($i=0; $i < $times; $i++){
	//
	// 	$date = new DateTime('tomorrow');
	//
	// 	$date->modify('+'.$i.' day');
	//
	//
	// 	makeScript(${$date->format('Md')}, $date, $i);
	// }

}

elseif (isset($_POST['gis'])){

	$site = 'Gismeteo!';

	$days = $_POST['gis'];

	foreach($days as $key => $day){

		$month[explode('-', $day)[0]] = explode('-', $day)[1];

		$days[$key] = explode('-', $day)[0];

	}

	$index = 0;

	foreach ($cityes as $key => $val) {

		$code = ['weather-simferopol-4995', 'weather-sevastopol-5003', 'weather-yalta-5002', 'weather-kerch-5001', 'weather-feodosiya-4999', 'weather-sudak-4998', 'weather-evpatoriya-4992', 'weather-chernomorskoe-4991', 'weather-dzhankoy-4994', 'weather-krasnoperekopsk-11351', 'weather-armyansk-11366'];

		$data = file_get_html('https://www.gismeteo.ru/'. $code[$index] .'/weekly/');

		$index++;

		foreach ($days as $day) {
			# code...

			for ($i = 0; $i < 10; $i++){

				$tmpDate = trim($data->find('span.w_date__date', $i)->plaintext);

				$tmpDate = explode(' ', trim($tmpDate));

				// if(count($tmpDate) > 1) {
				//
				// 	$month[$day] = $tmpDate[1];
				//
				// }

				if ($tmpDate[0] == $day) {

					$s = 'data-text';
					$wd = $data->find('div.widget__container', 1);

					$tmp = [

						'pog' => $data->find('span.tooltip', $i)->$s,
						'tempDay' => dropHellip($data->find('div.maxt span.unit_temperature_c', $i)->plaintext),
						'tempNight' => dropHellip($data->find('div.mint span.unit_temperature_c', $i)->plaintext),
						'wind' => 'Ветер ' . gisTransWind(trim($wd->find('div.w_wind__direction', $i)->plaintext)) . ' ' . trim($wd->find('span.unit_wind_m_s', $i)->plaintext) . ' м/с',

					];

					$cityes[$key][$day] = $tmp;

					break;
				}

			}

		}

	}

	// echo 'gis data start <br>';
	//
	// print_r($cityes);
	//
	// echo '<br>gis data end';
	//
	// die();



}

else{

	exit('Поста нет....((');
}

// $cityes = ['jankoy', 'feodosia'];

// $times = 3;

// foreach ($days as $day) {
// 	# code...
//
// 	foreach ($cityes as $key => $value) {
// 		# code...
// 		print_r($key);
// 		echo ' - ' . $day . ' - ';
// 		print_r($value[$day]);
// 		echo "<br>";
// 	}
//
// }

makeScript($cityes, $days, $site, $month);


function makeScript($cityes, $days, $site, $month){

	$i = 0;

	foreach ($days as $day) {
		# code...

	$monthStr = date('M', mktime(0, 0, 0, (int)$month[$day], $day));

	$season = 0;

	if ($month[$day] == 12 || $month[$day] == 1 || $month[$day] == 2){

		$season = '1';
	}

	if ($month[$day] == 3 || $month[$day] == 4 || $month[$day] == 5){

		$season = '2';
	}

	if ($month[$day] == 6 || $month[$day] == 7 || $month[$day] == 8){

		$season = '3';
	}

	if ($month[$day] == 9 || $month[$day] == 10 || $month[$day] == 11){

		$season = '4';
	}

		$script = '//Взято с ' . $site . "\r\n" .

		"\r\n" .

		'season = "' . $season . '"; //сезон' . "\r\n" .

		"\r\n" .

		'date = "' . $day .' '. $monthStr . '"; //дата' . "\r\n" .

		"\r\n";

		$text = 'Взято с ' . $site . "\r\n" .

		"\r\n" .

		'Погода на "' . $day .' '. $monthStr . '"; //дата' . "\r\n" .

		"\r\n";

		foreach ($cityes as $key => $value) {
			# code...
			// print_r($key);
			// echo ' - ' . $day . ' - ';
			// print_r($value[$day]);
			// echo "<br>";

			// echo $key . '<br>';
			//
			// echo $value[$day]["tempDay"];
			//
			// die();



			$script .= $key . ' = {' . "\r\n" .

				'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
				'night: ' . '"' . $value[$day]["tempNight"] . '",' . "\r\n" .
				'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
				'pog: ' . '"' . transCond($value[$day]["pog"]) . '",' . "\r\n" .

			'};' . "\r\n" .

			"\r\n";

			$text .= makeText($key, $value[$day]);

		}

		$script_success = file_put_contents('TEST_pogodaScr-'.$monthStr.$day.'.txt', $script);

			if ($script_success){
				echo 'script '. $site .' pogoda'.$monthStr.$day.'.txt - write success!!!' . "<br />";
			}
			else {
				echo 'script '. $site .' pogoda'.$monthStr.$day.'.txt - 4eta ne tak....' . "<br />";
			}

			// $key . ' = {' . "\r\n" .
			//
			// 	'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
			// 	'night: ' . '"' . $value[$day]["temp_night"] . '",' . "\r\n" .
			// 	'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
			// 	'pog: ' . '"' . $value[$day]["pog"] . '",' . "\r\n" .
			//
			// '};' . "\r\n" .
			//
			// "\r\n" .
			//
			// $key . ' = {' . "\r\n" .
			//
			// 	'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
			// 	'night: ' . '"' . $value[$day]["temp_night"] . '",' . "\r\n" .
			// 	'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
			// 	'pog: ' . '"' . $value[$day]["pog"] . '",' . "\r\n" .
			//
			// '};' . "\r\n" .
			//
			// "\r\n" .
			//
			// $key . ' = {' . "\r\n" .
			//
			// 	'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
			// 	'night: ' . '"' . $value[$day]["temp_night"] . '",' . "\r\n" .
			// 	'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
			// 	'pog: ' . '"' . $value[$day]["pog"] . '",' . "\r\n" .
			//
			// '};' . "\r\n" .
			//
			// "\r\n" .
			//
			// $key . ' = {' . "\r\n" .
			//
			// 	'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
			// 	'night: ' . '"' . $value[$day]["temp_night"] . '",' . "\r\n" .
			// 	'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
			// 	'pog: ' . '"' . $value[$day]["pog"] . '",' . "\r\n" .
			//
			// '};' . "\r\n" .
			//
			// "\r\n" .
			//
			// $key . ' = {' . "\r\n" .
			//
			// 	'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
			// 	'night: ' . '"' . $value[$day]["temp_night"] . '",' . "\r\n" .
			// 	'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
			// 	'pog: ' . '"' . $value[$day]["pog"] . '",' . "\r\n" .
			//
			// '};' . "\r\n" .
			//
			// "\r\n" .
			//
			// $key . ' = {' . "\r\n" .
			//
			// 	'day: ' . '"' . $value[$day]["tempDay"] . '",' . "\r\n" .
			// 	'night: ' . '"' . $value[$day]["temp_night"] . '",' . "\r\n" .
			// 	'wind: ' . '"' . $value[$day]["wind"] . '",' . "\r\n" .
			// 	'pog: ' . '"' . $value[$day]["pog"] . '",' . "\r\n" .
			//
			// '};' . "\r\n";



			// $text = 'Взято с ' . $site . "\r\n" .
			//
			// "\r\n" .
			//
			// 'Погода на "' . $day . '"; //дата' . "\r\n" .
			//
			// "\r\n" .

			// 'В Джанкое, и Красноперекопске ' . $value[$day]["pog"] .  "\r\n" .
			// $value[$day]["tempDay"] . ' градусов днем ' . "\r\n" .
			// ' До '.$value[$day]["temp_night"].' тепла в ночное время суток' . "\r\n" .
			// $value[$day]["wind"] .
			//
			// "\r\n" .
			//
			// 'В Евпатории и Черноморском ' . $value[$day]["pog"] . "\r\n" .
			// $value[$day]["tempDay"] . ' градусов  днем' . "\r\n" .
			// $value[$day]["temp_night"] . ' градусов  ночью' . "\r\n" .
			// $value[$day]["wind"] .
			//
			// "\r\n" .
			//
			// 'В Керчи и Ленино ' . $value[$day]["pog"] . "\r\n" .
			// 'Воздух днем прогреется  до ' . $value[$day]["tempDay"] . ' градуса тепла' . "\r\n" .
			// 'ночью до ' . $value[$day]["temp_night"] . ' с плюсом' . "\r\n" .
			// $value[$day]["wind"] .
			//
			// "\r\n" .
			//
			// 'В Феодосии и Судаке ' . $value[$day]["pog"] . "\r\n" .
			// 'температура воздуха днем ' . $value[$day]["tempDay"] . "\r\n" .
			// 'ночью ' . $value[$day]["temp_night"] . "\r\n" .
			// $value[$day]["wind"] .
			//
			// "\r\n" .
			//
			// 'На Южном берегу Крыма ' . $value[$day]["pog"]. "\r\n" .
			// 'Днем столбики термометров покажут ' . $value[$day]["tempDay"] . ' градусов тепла' . "\r\n" .
			// $value[$day]["temp_night"] . ' ночью' . "\r\n" .
			// $value[$day]["wind"] .
			//
			// "\r\n" .
			//
			// 'В Севастополе и Бахчисарае ' . $value[$day]["pog"] . "\r\n" .
			// 'днем ' . $value[$day]["tempDay"] . ' градусов' . "\r\n" .
			// 'ночью ' . $value[$day]["temp_night"] . "\r\n" .
			// $value[$day]["wind"] .
			//
			// "\r\n" .
			//
			// 'В центральной части и Симферополе ' . $value[$day]["pog"] . "\r\n" .
			// 'дневная температура  воздуха '. $value[$day]["tempDay"] . ' градусов ' . "\r\n" .
			// 'Ночью ' . $value[$day]["temp_night"] . "\r\n" .
			// $value[$day]["wind"];

			// echo $script;

			$text_success = file_put_contents($site . 'TEST_pogodaTxt-'.$monthStr.$day.'.txt', $text);

				if ($text_success){
					echo 'text '. $site .' pogodaTxt-' . $monthStr.$day . '.txt - write success!!!' . "<br />";
				}
				else {
					echo 'text '. $site .' pogodaTxt-' . $monthStr.$day . '.txt - 4eta ne tak....' . "<br />";
				}

				$i++;

	}

}

function transCond ($condition){

	$condition = explode(', ', $condition);

	// echo 'condition = ' . $condition . '<br>';

	// print_r ($condition);

	// echo '<br> count condition = ' . count($condition) . '<br>';

	if(count($condition) > 1) {

		$cond = $condition[1];
		// echo 'cond if = ' . $cond;

		// if($cond == 'Гроза'){echo 'RAVNO!';}
	}
	else {
		$cond = $condition[0];
		// echo 'cond else = ' . $cond;
	}

	$cond = mb_convert_case($cond, MB_CASE_LOWER, "UTF-8");


	switch ($cond) {
		case 'ясно':
			return 'sun';
			break;

		case 'пасмурно':
			return 'cloud';
			break;

		case 'облачно с прояснениями':
			return 'cloudSun';
			break;

		case 'малооблачно':
			return 'cloudSun';
			break;

		case 'переменная облачность':
			return 'cloudSun';
			break;

		case 'небольшой дождь':
			return 'rain';
			break;

		case 'дождь':
			return 'rain';
			break;

		case 'сильный дождь':
			return 'groza';
			break;

		case 'гроза':
			return 'groza';
			break;

		case 'дождь со снегом':
			return 'rain';
			break;

		case 'ливень' :
			return 'groza';
			break;

		case 'снег':
			return 'snow';
			break;

		case 'небольшой снег':
			return 'snow';
			break;

		default:
			return 'значение не задано!!!';
			break;
	}
}

function transWind ($wind){

	$wind = explode(' ', $wind);

	switch($wind[2]) {

		case 'С':
			$wind[2] = 'северный';
			break;

		case 'СВ':
			$wind[2] = 'северо-восточный';
			break;

		case 'СЗ':
			$wind[2] = 'северо-западный';
			break;

		case 'Ю':
			$wind[2] = 'южный';
			break;

		case 'ЮВ':
			$wind[2] = 'юго-восточный';
			break;

		case 'ЮЗ':
			$wind[2] = 'юго-западный';
			break;

		case 'З':
			$wind[2] = 'западный';
			break;

		case 'В':
			$wind[2] = 'восточный';
			break;

		default:
			'значение ПРОЁБАНО!';
			break;

	}

	return 'Ветер ' . $wind[2] . ' ' . $wind[0] . ' м/с';

}

function gisTransWind ($wind){

	$wind = trim($wind);

	switch($wind) {

		case 'С':
			$wind = 'северный';
			break;

		case 'СВ':
			$wind = 'северо-восточный';
			break;

		case 'СЗ':
			$wind = 'северо-западный';
			break;

		case 'Ю':
			$wind = 'южный';
			break;

		case 'ЮВ':
			$wind = 'юго-восточный';
			break;

		case 'ЮЗ':
			$wind = 'юго-западный';
			break;

		case 'З':
			$wind = 'западный';
			break;

		case 'В':
			$wind = 'восточный';
			break;

		default:
			'значение ПРОЁБАНО!';
			break;

	}

	return $wind;

}


function dropHellip ($str){

	$substr = trim(preg_replace('/[^0-9\°\+\-\−]+/', ' ', preg_replace('/\ /', '', $str)));

	if (strlen($substr) < 7){

		$sign = mb_substr($substr, 0, 1);

		$tmp = (int)preg_replace('/[^\d\+\-]+/', '', $substr);

		if ($sign == '+') {

			$newVal = $tmp-2;

			$substr = $sign . $newVal . "°" . " " . $substr . "°";

		}

		if ($sign == '−') {

			$newVal = $tmp+2;

			$substr =  $sign . $newVal . "°" . " " . $substr . "°";

		}

	}

	$substr = explode(' ', $substr)[0] . ' ... ' . explode(' ', $substr)[1];

	return $substr;
}


// $cityes = ["jankoy" => "", "evpatoria" => "", "kerch" => "", "feodosia" => "",  "yalta" => "",  "sevastopol" => "", "simferopol" => ""];

function makeText($city, $value){

	switch($city) {


		case 'simferopol' :
			return 'В центральной части и Симферополе ' . $value["pog"] . "\r\n" .
							'дневная температура  воздуха '. $value["tempDay"] . ' градусов ' . "\r\n" .
							'Ночью ' . $value["tempNight"] . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'sevastopol' :
			return 'В Севастополе и Бахчисарае ' . $value["pog"] . "\r\n" .
							'днем ' . $value["tempDay"] . ' градусов' . "\r\n" .
							'ночью ' . $value["tempNight"] . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'yalta' :
			return 'На Южном берегу Крыма ' . $value["pog"]. "\r\n" .
							'Днем столбики термометров покажут ' . $value["tempDay"] . ' градусов тепла' . "\r\n" .
							$value["tempNight"] . ' ночью' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'kerch' :
			return 'В Керчи и Ленино ' . $value["pog"] . "\r\n" .
							'Воздух днем прогреется  до ' . $value["tempDay"] . ' градуса тепла' . "\r\n" .
							'ночью до ' . $value["tempNight"] . ' с плюсом' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'feodosia' :
			return 'В Феодосии ' . $value["pog"] . "\r\n" .
							'температура воздуха днем ' . $value["tempDay"] . "\r\n" .
							'ночью ' . $value["tempNight"] . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'sudak' :
			return 'В Судаке ' . $value["pog"] . "\r\n" .
							'температура воздуха днем ' . $value["tempDay"] . "\r\n" .
							'ночью ' . $value["tempNight"] . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'evpatoria' :
			return 'В Евпатории ' . $value["pog"] . "\r\n" .
							$value["tempDay"] . ' градусов  днем' . "\r\n" .
							$value["tempNight"] . ' градусов  ночью' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'chernomorskoe' :
			return 'В Черноморском ' . $value["pog"] . "\r\n" .
							$value["tempDay"] . ' градусов  днем' . "\r\n" .
							$value["tempNight"] . ' градусов  ночью' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'jankoy' :
			return 'В Джанкое ' . $value["pog"] .  "\r\n" .
							$value["tempDay"] . ' градусов днем ' . "\r\n" .
							' До '.$value["tempNight"].' тепла в ночное время суток' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'krasnoperekopsk' :
			return 'В Красноперекопске ' . $value["pog"] .  "\r\n" .
							$value["tempDay"] . ' градусов днем ' . "\r\n" .
							' До '.$value["tempNight"].' тепла в ночное время суток' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		case 'armyansk' :
			return 'В Армянске ' . $value["pog"] .  "\r\n" .
							$value["tempDay"] . ' градусов днем ' . "\r\n" .
							' До '.$value["tempNight"].' тепла в ночное время суток' . "\r\n" .
							$value["wind"] . "\r\n" . "\r\n";

		default:
			return 'default!';

	}

}

?>
