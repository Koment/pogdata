<?php

include 'simple_html_dom.php';

/*

var cityes = ['jankoy', 'feodosia', 'evpatoria', 'yalta', 'kerch', 'sevastopol', 'simferopol'];

'h2.location-title__place, strong.forecast-details__day-number, span.temp__value, td.weather-table__body-cell_type_condition'

*/

// $cityes = ['jankoy', 'feodosia', 'evpatoria', 'yalta', 'kerch', 'sevastopol', 'simferopol'];

$cityes = ['jankoy', 'feodosia'];

$times = 3;



foreach ($cityes as $city) {

	$data = file_get_html('https://yandex.ru/pogoda/'.$city.'/details');

	$data = $data->find('dd.forecast-details__day-info');

	// echo ($data[0]->plaintext);

	$i=0;

	$j=0;

	$date = new DateTime('tomorrow');

	foreach($data as $key => $day) {

		echo "key = " . $key . "<br/>";

		if($i >= 2 && $i < $times+2){

			${$city} = [

			'temp_day' => $day->find('div.weather-table__temp', 1)->plaintext,
			'temp_night' => $day->find('div.weather-table__temp', 3)->plaintext,
			'condition' => $day->find('td.weather-table__body-cell_type_condition', 1)->plaintext,
			];

			print_r(${$city});

			${$date->format('Md')}[] = ${$city};

			// $forecast['temp_day'] = $day->find('div.weather-table__temp', 1)->plaintext;
			// $forecast['temp_night'] = $day->find('div.weather-table__temp', 3)->plaintext;
			// $forecast['condition'] = $day->find('td.weather-table__body-cell_type_condition', 1)->plaintext;

			echo $date->format('Md') . "<br/>";

			// ${$date->format('d-m')}[] = $forecast;

			// echo $date->format('d/m') . "<br/>";

			$date->modify('+1 day');

			$j++;
		}

		$i++;
	}

// var_dump(${$date->format('Md')});


// print_r(${$date->format('d-m')});

}

echo ('$Oct01 = ');
var_dump($Oct01);
echo "<br/>";

echo ('$Oct02 = ');
var_dump($Oct02);
echo "<br/>";

echo ('$Oct03 = ');
var_dump($Oct03);
echo "<br/>";

echo ('$Oct04 = ');
var_dump($Oct04);
echo "<br/>";

echo ('$Oct05 = ');
var_dump($Oct05);
echo "<br/>";

echo ('$Oct06 = ');
var_dump($Oct06);
echo "<br/>";

echo ('$Oct07 = ');
var_dump($Oct07);
echo "<br/>";

// echo $Oct02[0]['temp_day'];
// echo $Oct02[1]['temp_day'];

// function makeArrs ($times){



// $list = [];

// for ($i=0; $i<=$times; $i++){

// ${$date->format('Md')} = [];
// $list[] = ${$date->format('Md')};
// $date->modify('+1 day');

// var_dump($list);
// }

// }

?>