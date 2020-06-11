<?php

/**
 *
 */
class makeScript
{

  function __construct()
  {
    # code...
  }

  public function makeScript($cityes, $textVals, $days, $site, $month, $cityList){

  	foreach ($days as $day) {
  		# code...

      $jsonData = [];

    	$monthStr = date('M', mktime(0, 0, 0, (int)$month[$day], $day));

    	$season = '0';

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


      $jsonData[] = array_merge($textVals[$day], $cityes[$day]);

      if (file_put_contents('MeteoData-' . mb_convert_encoding($site, "windows-1251") . ' - ' . $monthStr . $day . '.json', json_encode($jsonData, JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT))){

        echo "<br><br>json file MeteoData-" . $site . " - " . $monthStr . $day . " created succesfuly!<br><br>";
      }
      else {

        echo "<br><br>Some errore ocure =(...";
      }


        $wallData = 'По информации ' . $site . "\r\n" .

    		"\r\n" .

    		'Погода на ' . $textVals[$day]["1ddmmmT"]  . "\r\n" .

    		"\r\n";

        for($i=1; $i<count($cityList)+1; $i++){

          $wallData .= $cityes[$day][$i."city"] . "\r\n" .

          "день - " . $cityes[$day][$i."TempDayT"] . "\r\n" .
          "ночь - " . $cityes[$day][$i."TempNightT"] . "\r\n" .

          "день - " . $cityes[$day][$i."CondDayT"] . "\r\n" .
          "ночь - " . $cityes[$day][$i."CondNightT"] . "\r\n" .

          "день - " . $cityes[$day][$i."WindDayT"] . ", " . $cityes[$day][$i."ForceDayT"] . "\r\n" .
          "ночь - " . $cityes[$day][$i."WindNightT"] . ", " . $cityes[$day][$i."ForceNightT"] . "\r\n" .

          "\r\n";

        }

    		$text = 'По информации ' . $site . "\r\n" .

    		"\r\n" .

    		'Погода на ' . $textVals[$day]["1ddmmmT"]  . "\r\n" .

    		"\r\n";

        $text .= 'В Крыму ожидается ' . $cityes[$day]["1CondDayT"] . '.' . "\r\n" .
                  'На западном побережье полуострова ' . $cityes[$day]["2CondDayT"] . ', температура ' . $cityes[$day]["2TempDayT"] . ' градусов, Ветер '. $cityes[$day]["2WindDayT"] . ', ' . $cityes[$day]["2ForceDayT"] . '.' . "\r\n" .
                  'На Востоке Крыма ' . $cityes[$day]["5CondDayT"] . ', температура ' . $cityes[$day]["5TempDayT"] . ' градусов, Ветер '. $cityes[$day]["5WindDayT"] . ', ' . $cityes[$day]["5ForceDayT"] . '.' . "\r\n" .
                  'На Севере полуострова ' . $cityes[$day]["9CondDayT"] . ', температура ' . $cityes[$day]["9TempDayT"] . ' градусов, Ветер '. $cityes[$day]["9WindDayT"] . ', ' . $cityes[$day]["9ForceDayT"] . '.' . "\r\n" .
                  'На Южном побережье Крыма '. $cityes[$day]["11CondDayT"] . ', температура ' . $cityes[$day]["11TempDayT"] . ' градусов, Ветер '. $cityes[$day]["11WindDayT"] . ', ' . $cityes[$day]["11ForceDayT"] . '.' . "\r\n" .
                  'В Центральной части и в Симферополе ' . $cityes[$day]["1CondDayT"] . ', температура ' . $cityes[$day]["1TempDayT"] . ' градусов днем, ' . $cityes[$day]["1TempNightT"] . ' ночью. Ветер '. $cityes[$day]["1WindDayT"] . ', ' . $cityes[$day]["1ForceDayT"] . '.' . "\r\n";


  			$text_success = file_put_contents(mb_convert_encoding($site, "windows-1251") . '_pogodaTxt-'.$monthStr.$day.'.txt', $text);

  				if ($text_success){
  					echo 'text '. $site .' pogodaTxt-' . $monthStr.$day . '.txt - write success!!!' . "<br />";
  				}
  				else {
  					echo 'text '. $site .' pogodaTxt-' . $monthStr.$day . '.txt - 4eta ne tak....' . "<br />";
  				}

        $wall_success = file_put_contents(mb_convert_encoding($site, "windows-1251") . '_pogodaWallDigits-'.$monthStr.$day.'.txt', $wallData);

  				if ($wall_success){
  					echo 'text '. $site .' pogodaWallDigits-' . $monthStr.$day . '.txt - write success!!!' . "<br />";
  				}
  				else {
  					echo 'text '. $site .' pogodaWallDigits-' . $monthStr.$day . '.txt - 4eta ne tak....' . "<br />";
  				}

  	 }

  }

  public function makeText($city, $value){

  	// switch($city) {
    //
  	// 	case 'simferopol' :
  	// 		return 'В центральной части и Симферополе ' . $value["pog"] . "\r\n" .
  	// 						'дневная температура  воздуха '. $value["tempDay"] . ' градусов ' . "\r\n" .
  	// 						'Ночью ' . $value["tempNight"] . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'sevastopol' :
  	// 		return 'В Севастополе ' . $value["pog"] . "\r\n" .
  	// 						'днем ' . $value["tempDay"] . ' градусов' . "\r\n" .
  	// 						'ночью ' . $value["tempNight"] . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'yalta' :
  	// 		return 'В Ялте ' . $value["pog"]. "\r\n" .
  	// 						'Днем столбики термометров покажут ' . $value["tempDay"] . ' градусов тепла' . "\r\n" .
  	// 						$value["tempNight"] . ' ночью' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
    //   case 'alushta' :
    //     return 'В Алуште ' . $value["pog"]. "\r\n" .
    //             'Днем столбики термометров покажут ' . $value["tempDay"] . ' градусов тепла' . "\r\n" .
    //             $value["tempNight"] . ' ночью' . "\r\n" .
    //             $value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'kerch' :
  	// 		return 'В Керчи ' . $value["pog"] . "\r\n" .
  	// 						'Воздух днем прогреется  до ' . $value["tempDay"] . ' градуса тепла' . "\r\n" .
  	// 						'ночью до ' . $value["tempNight"] . ' с плюсом' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'feodosia' :
  	// 		return 'В Феодосии ' . $value["pog"] . "\r\n" .
  	// 						'температура воздуха днем ' . $value["tempDay"] . "\r\n" .
  	// 						'ночью ' . $value["tempNight"] . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'sudak' :
  	// 		return 'В Судаке ' . $value["pog"] . "\r\n" .
  	// 						'температура воздуха днем ' . $value["tempDay"] . "\r\n" .
  	// 						'ночью ' . $value["tempNight"] . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'evpatoria' :
  	// 		return 'В Евпатории ' . $value["pog"] . "\r\n" .
  	// 						$value["tempDay"] . ' градусов  днем' . "\r\n" .
  	// 						$value["tempNight"] . ' градусов  ночью' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'chernomorskoe' :
  	// 		return 'В Черноморском ' . $value["pog"] . "\r\n" .
  	// 						$value["tempDay"] . ' градусов  днем' . "\r\n" .
  	// 						$value["tempNight"] . ' градусов  ночью' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'jankoy' :
  	// 		return 'В Джанкое ' . $value["pog"] .  "\r\n" .
  	// 						$value["tempDay"] . ' градусов днем ' . "\r\n" .
  	// 						'До '.$value["tempNight"].' тепла в ночное время суток' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'krasnoperekopsk' :
  	// 		return 'В Красноперекопске ' . $value["pog"] .  "\r\n" .
  	// 						$value["tempDay"] . ' градусов днем ' . "\r\n" .
  	// 						'До '.$value["tempNight"].' тепла в ночное время суток' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	case 'armyansk' :
  	// 		return 'В Армянске ' . $value["pog"] .  "\r\n" .
  	// 						$value["tempDay"] . ' градусов днем ' . "\r\n" .
  	// 						'До '.$value["tempNight"].' тепла в ночное время суток' . "\r\n" .
  	// 						$value["wind"] . "\r\n" . "\r\n";
    //
  	// 	default :
  	// 		return 'default!';
    //
  	// }

  }


}//end class
