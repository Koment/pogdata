<?php
@header ("Content-Type: text/html; charset=UTF-8");

include 'simple_html_dom.php';

/*

var cityes = ['jankoy', 'feodosia', 'evpatoria', 'yalta', 'kerch', 'sevastopol', 'simferopol'];

'h2.location-title__place, strong.forecast-details__day-number, span.temp__value, td.weather-table__body-cell_type_condition'

*/

$cityes = ['jankoy', 'evpatoria', 'kerch', 'feodosia',  'yalta',  'sevastopol', 'simferopol', 'chernomorskoe'];

if (isset($_POST['times'])){

	$times = is_numeric($_POST['times']) ? $_POST['times'] : (int)$_POST['times'];

	// echo "times  = " . $times;
	//
	// die('norm!');

	// $yaData = getYaData($cityes, $times);

	foreach ($cityes as $city) {

		$data = file_get_html('https://yandex.ru/pogoda/'.$city.'/details');

		// echo $data;

		$data = $data->find('dd.forecast-details__day-info');

		// echo ($data[0]->plaintext);

		$i=0;

		$j=0;

		$date = new DateTime('tomorrow');

		foreach($data as $key => $day) {

			if($i >= 2 && $i < $times+2){

				${$city} = [

					'temp_day' => $day->find('div.weather-table__temp', 1)->plaintext,
					'temp_night' => $day->find('div.weather-table__temp', 3)->plaintext,
					'condition' => $day->find('td.weather-table__body-cell_type_condition', 1)->plaintext,
					'wind' => $day->find('div.weather-table__wrapper', 3)->plaintext,

				];

				${$date->format('Md')}[] = ${$city};

				$date->modify('+1 day');

				$j++;
			}

			$i++;
		}

	}

	for ($i=0; $i < $times; $i++){

		$date = new DateTime('tomorrow');

		$date->modify('+'.$i.' day');


		makeScript(${$date->format('Md')}, $date, $i);
	}


}

elseif (isset($_POST['gis'])) {

	$days = $_POST['gis'];

	$code = ['weather-dzhankoy-4994', 'weather-evpatoriya-4992', 'weather-kerch-5001', 'weather-feodosiya-4999', 'weather-yalta-5002', 'weather-sevastopol-5003', 'weather-simferopol-4995', 'weather-chernomorskoe-4991'];

	foreach ($days as $day) {

		foreach($code as $link){

			$data = file_get_html('https://www.gismeteo.ru/' . $link . '/weekly');

			echo trim($data->find('span.w_date__date', 2)->plaintext);

					for ($i = 0; $i < 8; $i++){

							if ($data->find('span.w_date__date', $i)->plaintext == (int)$day) {

									echo $data->find('h1', 0)->plaintext;

									$s = 'data-text';

									echo $pog = $data->find('span.tooltip', $i)->$s;
									echo $tempDay = $data->find('div.maxt span.unit_temperature_c', $i)->plaintext;
									echo $tempNight = $data->find('div.mint span.unit_temperature_c', $i)->plaintext;

									$wd = $data->find('div.widget__container', 1);

									$dir = $wd->find('div.w_wind__direction', $i)->plaintext;

									echo $wind = 'Ветер ' . gisTransWind($dir) . ' ' . $wd->find('span.unit_wind_m_s', $i)->plaintext . ' м/с';

									echo "<br>";

									// ${$city} = [
									//
									// 	'temp_day' => $data->find('div.maxt span.unit_temperature_c', $i)->plaintext,
									// 	'temp_night' => $data->find('div.mint span.unit_temperature_c', $i)->plaintext,
									// 	'condition' => $data->find('span.tooltip', $i)->$s,
									// 	'wind' => 'Ветер ' . $wd->find('div.w_wind__direction', $i)->plaintext . ' ' . $wd->find('span.unit_wind_m_s', $i)->plaintext . ' м/с',
									//
									// ];

									// echo "city";
									//
									// print_r(${$sity});

									break;
						}
					}
				}
			}


}

else{

	die('Поста нет....((');
}

// $cityes = ['jankoy', 'feodosia'];

// $times = 3;



function makeScript($arr, $date, $i){

	$season = 0;

	if ($date->format('m') == '01' || $date->format('m') == '02' || $date->format('m') == '12'){

		$season = '1';
	}

	if ($date->format('m') == '03' || $date->format('m') == '04' || $date->format('m') == '05'){

		$season = '2';
	}

	if ($date->format('m') == '06' || $date->format('m') == '07' || $date->format('m') == '08'){

		$season = '3';
	}

	if ($date->format('m') == '09' || $date->format('m') == '10' || $date->format('m') == '11'){

		$season = '4';
	}

	$script = 'season = "'.$season.'"; //сезон' . "\r\n" .

	"\r\n" .

	'date = "'.$date->format('d/m').'"; //дата' . "\r\n" .

	"\r\n" .

	'simferopol = {' . "\r\n" .

		'day: ' . '"' . dropHellip($arr[6]["temp_day"]) . '",' . "\r\n" .
		'night: ' . '"' . dropHellip($arr[6]["temp_night"]) . '",' . "\r\n" .
		'wind: ' . '"' . transWind($arr[6]["wind"]) . '",' . "\r\n" .
		'pog: ' . '"' . transCond($arr[6]["condition"]) . '",' . "\r\n" .

	'};' . "\r\n" .

"\r\n" .

	'sevastopol = {' . "\r\n" .

		'day: ' . '"' . dropHellip($arr[5]["temp_day"]) . '",' . "\r\n" .
		'night: ' . '"' . dropHellip($arr[5]["temp_night"]) . '",' . "\r\n" .
		'wind: ' . '"' . transWind($arr[5]["wind"]) . '",' . "\r\n" .
		'pog: ' . '"' . transCond($arr[5]["condition"]) . '",' . "\r\n" .

	'};' . "\r\n" .

"\r\n" .

'ubk = {' . "\r\n" .

		'day: ' . '"' . dropHellip($arr[4]["temp_day"]) . '",' . "\r\n" .
		'night: ' . '"' . dropHellip($arr[4]["temp_night"]) . '",' . "\r\n" .
		'wind: ' . '"' . transWind($arr[4]["wind"]) . '",' . "\r\n" .
		'pog: ' . '"' . transCond($arr[4]["condition"]) . '",' . "\r\n" .

'};' . "\r\n" .

"\r\n" .

'ker4 = {' . "\r\n" .

	'day: ' . '"' . dropHellip($arr[2]["temp_day"]) . '",' . "\r\n" .
	'night: ' . '"' . dropHellip($arr[2]["temp_night"]) . '",' . "\r\n" .
	'wind: ' . '"' . transWind($arr[2]["wind"]) . '",' . "\r\n" .
	'pog: ' . '"' . transCond($arr[2]["condition"]) . '",' . "\r\n" .

'};' . "\r\n" .

"\r\n" .

'evpatoriya = {' . "\r\n" .

	'day: ' . '"' . dropHellip($arr[1]["temp_day"]) . '",' . "\r\n" .
	'night: ' . '"' . dropHellip($arr[1]["temp_night"]) . '",' . "\r\n" .
	'wind: ' . '"' . transWind($arr[1]["wind"]) . '",' . "\r\n" .
	'pog: ' . '"' . transCond($arr[1]["condition"]) . '",' . "\r\n" .

'};' . "\r\n" .

'feodosiya = {' . "\r\n" .

	'day: ' . '"' . dropHellip($arr[3]["temp_day"]) . '",' . "\r\n" .
	'night: ' . '"' . dropHellip($arr[3]["temp_night"]) . '",' . "\r\n" .
	'wind: ' . '"' . transWind($arr[3]["wind"]) . '",' . "\r\n" .
	'pog: ' . '"' . transCond($arr[3]["condition"]) . '",' . "\r\n" .

'};' . "\r\n" .

"\r\n" .

'chernomorskoe = {' . "\r\n" .

	'day: ' . '"' . dropHellip($arr[7]["temp_day"]) . '",' . "\r\n" .
	'night: ' . '"' . dropHellip($arr[7]["temp_night"]) . '",' . "\r\n" .
	'wind: ' . '"' . transWind($arr[7]["wind"]) . '",' . "\r\n" .
	'pog: ' . '"' . transCond($arr[7]["condition"]) . '",' . "\r\n" .

'};' . "\r\n" .

"\r\n" .

	'djankoy = {' . "\r\n" .

		'day: ' . '"' . dropHellip($arr[0]["temp_day"]) . '",' . "\r\n" .
		'night: ' . '"' . dropHellip($arr[0]["temp_night"]) . '",' . "\r\n" .
		'wind: ' . '"' . transWind($arr[0]["wind"]) . '",' . "\r\n" .
		'pog: ' . '"' . transCond($arr[0]["condition"]) . '",' . "\r\n" .

	'};' . "\r\n";

	$text =

	'Погода на "'.$date->format('d/m').'"; //дата' . "\r\n" .

	"\r\n" .

	'В центральной части и Симферополе ' .$arr[6]['condition'] . "\r\n" .
	'дневная температура  воздуха '.dropHellip($arr[6]["temp_day"]).' градусов ' . "\r\n" .
	'Ночью ' .dropHellip($arr[6]["temp_night"]). "\r\n" .
	transWind($arr[6]["wind"]) . "\r\n" .

	"\r\n" .

	'В Севастополе ' .$arr[5]['condition']. "\r\n" .
	'днем '.dropHellip($arr[5]["temp_day"]).' градусов' . "\r\n" .
	'ночью ' .dropHellip($arr[5]["temp_night"]). "\r\n" .
	transWind($arr[5]["wind"]) . "\r\n" .

	"\r\n" .

	'На Южном берегу Крыма ' .$arr[4]['condition']. "\r\n" .
	'Днем столбики термометров покажут '.dropHellip($arr[4]["temp_day"]).' градусов тепла' . "\r\n" .
	dropHellip($arr[4]["temp_night"]).' ночью' . "\r\n" .
	transWind($arr[4]["wind"]) . "\r\n" .

	"\r\n" .

	'В Керчи ' .$arr[2]['condition']. "\r\n" .
	'Воздух днем прогреется  до '.dropHellip($arr[2]["temp_day"]).' градуса тепла' . "\r\n" .
	'ночью до '.dropHellip($arr[2]["temp_night"]).' с плюсом' . "\r\n" .
	transWind($arr[2]["wind"]) . "\r\n" .

	"\r\n" .

	'В Евпатории ' . $arr[1]['condition'] . "\r\n" .
	dropHellip($arr[1]["temp_day"]). ' градусов  днем' . "\r\n" .
	dropHellip($arr[1]["temp_night"]). ' градусов  ночью' . "\r\n" .
	transWind($arr[1]["wind"]) . "\r\n" .

	"\r\n" .

	'В Феодосии ' . $arr[3]['condition'] . "\r\n" .
	'температура воздуха днем ' .dropHellip($arr[3]["temp_day"]). "\r\n" .
	'ночью '.dropHellip($arr[3]["temp_night"]). "\r\n" .
	transWind($arr[3]["wind"]) . "\r\n" .

	"\r\n" .

	'В Черноморском ' . $arr[7]['condition'] . "\r\n" .
	dropHellip($arr[7]["temp_day"]). ' градусов  днем' . "\r\n" .
	dropHellip($arr[7]["temp_night"]). ' градусов  ночью' . "\r\n" .
	transWind($arr[7]["wind"]) . "\r\n" .

	"\r\n" .

	'В Джанкое и Красноперекопске ' . $arr[0]['condition'] .  "\r\n" .
	dropHellip($arr[0]["temp_day"]) . ' градусов днем ' . "\r\n" .
	' До '.dropHellip($arr[0]["temp_night"]).' тепла в ночное время суток' . "\r\n" .
	transWind($arr[0]["wind"]) . "\r\n" .

	"\r\n";

	// echo $script;

	$script_success = file_put_contents('pogoda'.$i.'.txt', $script);

		if ($script_success){
			echo 'script pogoda'.$i.'.txt - write success!!!' . "<br />";
		}
		else {
			echo 'script pogoda'.$i.'.txt - 4eta ne tak....' . "<br />";
		}

	$text_success = file_put_contents('pogoda-'.$date->format('Md').'.txt', $text);

		if ($text_success){
			echo 'text pogoda-'.$date->format('Md').'.txt - write success!!!' . "<br />";
		}
		else {
			echo 'text pogoda-'.$date->format('Md').'.txt - 4eta ne tak....' . "<br />";
		}

}

function transCond ($condition){

	switch ($condition) {
		case 'Ясно':
			return 'sun';
			break;

		case 'Пасмурно':
			return 'cloud';
			break;

		case 'Облачно с прояснениями':
			return 'cloudSun';
			break;

		case 'Малооблачно':
			return 'cloudSun';
			break;

		case 'Небольшой дождь':
			return 'rain';
			break;

		case 'Дождь':
			return 'groza';
			break;

		case 'Дождь со снегом':
			return 'snowRain';
			break;

		case 'Ливень' :
			return 'groza';
			break;

		case 'Снег':
			return 'snow';
			break;

		case 'Небольшой снег':
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

			$newVal = $tmp+2;

			$substr = $substr . " " . $sign . $newVal . "°";

		}

		if ($sign == '−') {

			$newVal = $tmp+2;

			$substr =  $sign . $newVal . "°" . " " . $substr;

		}

	}

	$substr = preg_replace('/ /', ' ... ', $substr);

	return $substr;
}

?>
