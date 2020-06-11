<?php

// namespace pogodafactory\pogoda;

include 'simple_html_dom.php';

abstract class pogoda {

  public $cityes = ["simferopol" => "Симферополь",

                    "saky" => "Саки",
                    "evpatoria" => "Евпатория",
                    "chernomorskoe" => "Черноморское",

                    "kerch" => "Керчь",
                    "feodosia" => "Феодосия",
                    "sudak" => "Судак",

                    "krasnoperekopsk" => "Красноперекопск",
                    "jankoy" => "Джанкой",
                    "armyansk" => "Армянск",

                    "yalta" => "Ялта",
                    "alushta" => "Алушта",
                    "sevastopol" => "Севастополь",

                    "bahchisaraj" => "Бахчисарай",

                  ];

  // public $cityes = ["simferopol" => ""];

  protected $giscode = [
    "simferopol" => "weather-simferopol-4995",
    "yalta" => "weather-yalta-5002",
    "alushta" => "weather-alushta-4996",
    "kerch" => "weather-kerch-5001",
    "feodosia" => "weather-feodosiya-4999",
    "sudak" => "weather-sudak-4998",
    "evpatoria" => "weather-evpatoriya-4992",
    "chernomorskoe" => "weather-chernomorskoe-4991",
    "jankoy" => "weather-dzhankoy-4994",
    "krasnoperekopsk" => "weather-krasnoperekopsk-11351",
    "armyansk" => "weather-armyansk-11366",
    "sevastopol" => "weather-sevastopol-5003",
    "saky" => "weather-saki-4993",
    "bahchisaraj" => "weather-bakhchisaray-11364",
  ];

  protected $sincode = [
    "simferopol" => "симферополь",
    "yalta" => "ялта",
    "alushta" => "алушта",
    "kerch" => "керчь",
    "feodosia" => "феодосия",
    "sudak" => "судак",
    "evpatoria" => "евпатория",
    "chernomorskoe" => "черноморское",
    "jankoy" => "джанкой",
    "krasnoperekopsk" => "красноперекопск",
    "armyansk" => "армянск",
    "sevastopol" => "севастополь",
  ];


  public $days = [];

  public $month = [];

  public $site;

  public $txtData = [

    // "1TxtMulticity" => "Погода в Крыму",
    // "1TxtCapital" => "Погода в Симферополе",
    // "1TxtSuorce" => "По информации с сайта ",
    //
    // "1TxtDataT" => "Прогноз на ",
    // "1TxtDataAT" => "Прогноз на ",
    // "1ddmmmT" => "2 апреля",
    // "1ddmmmAT" => "3 апреля",
    // "1ddmmmTxtT" => "2 апреля. Четверг",
    // "1ddmmmTxtAT" => "3 апреля. Пятница",
    // "1DayDdMmT" => "День, 2.04",
    // "1NightDdMmT" => "Ночь, 2.04",
    // "1DayDdMmAT" => "День, 3.04",
    // "1NightDdMmAT" => "Ночь, 3.04",
    // "1TxtTxtData" => "Прогноз на четверг и пятницу",

  ];

  public $valsData = [];

  protected $weekDaysIm = [
            1 => "Понедельник",
            2 => "Вторник",
            3 => "Среда",
            4 => "Четверг",
            5 => "Пятница",
            6 => "Суббота",
            7 => "Воскресенье",
        ];

  protected $weekDaysVin = [
            1 => "Понедельник",
            2 => "Вторник",
            3 => "Среду",
            4 => "Четверг",
            5 => "Пятницу",
            6 => "Субботу",
            7 => "Воскресенье",
        ];

  protected $monthesS = [
        'нулябрь',
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
      ];


  public $errs = [];


  protected function proceedDate($date){

    foreach($date as $key => $day){

      $tDate = date('j-n-Y-N', $day/1000);

      // $atDate = date('j-n-N', $day/1000)->modify('+1 day');

      $at = new DateTime($tDate);

      $at->modify('+1 day');

      $atDate = $at->format('j-n-Y-N');

      $expTDay = explode('-', $tDate);

      $expATDay = explode('-', $atDate);

  		// $this->month[explode('-', $day)[0]] = explode('-', $day)[1];
      //
  		// $this->days[$key] = explode('-', $day)[0];

      $this->month[$expTDay[0]] = $expTDay[1];

  		$this->days[$key] = $expTDay[0];

      $this->txtData[$expTDay[0]]["1TxtSuorce"] = "По информации " . $this->site;

      $this->txtData[$expTDay[0]]["1TxtDataT"] = "Прогноз на " . $this->weekDaysVin[$expTDay[3]];

      $this->txtData[$expTDay[0]]["1TxtDataAT"] = "Прогноз на " . $this->weekDaysVin[$expATDay[3]];

      $this->txtData[$expTDay[0]]["1ddmmmT"] = $expTDay[0] . " " . $this->monthesS[$expTDay[1]];

      $this->txtData[$expTDay[0]]["1ddmmmAT"] = $expATDay[0] . " " . $this->monthesS[$expATDay[1]];

      $this->txtData[$expTDay[0]]["1ddmmmTxtT"] = $expTDay[0] . " " . $this->monthesS[$expTDay[1]] . ". " . $this->weekDaysIm[$expTDay[3]];  //"2 апреля. Четверг",

      $this->txtData[$expTDay[0]]["1ddmmmTxtAT"] = $expATDay[0] . " " . $this->monthesS[$expATDay[1]] . ". " . $this->weekDaysIm[$expATDay[3]]; //"3 апреля. Пятница",

      $this->txtData[$expTDay[0]]["1DayDdMmT"] = "День, " .  date('j.m', strtotime($tDate));  //"День, 2.04",

      $this->txtData[$expTDay[0]]["1NightDdMmT"] = "Ночь, " . date('j.m', strtotime($tDate));  //"Ночь, 2.04"

      $this->txtData[$expTDay[0]]["1DayDdMmAT"] = "День, " . date('j.m', strtotime($atDate));  //"День, 3.04"

      $this->txtData[$expTDay[0]]["1NightDdMmAT"] = "Ночь, " . date('j.m', strtotime($atDate));  //"Ночь, 3.04"

      $this->txtData[$expTDay[0]]["1TxtTxtData"] = "Прогноз на " . $this->weekDaysVin[$expTDay[3]] . " и " . $this->weekDaysVin[$expATDay[3]]; //"Прогноз на четверг и пятницу"

  	}
  }

  public function transCond ($condition){

  	$condition = explode(', ', $condition);

  	if(count($condition) > 1) {

  		$cond = $condition[count($condition)-1];

  	}	else {

  		$cond = $condition[0];
  	}

  	// $cond = mb_convert_case($cond, MB_CASE_LOWER, "UTF-8");

    $cond = strip_tags($cond);

    $cond = trim (mb_strtolower($cond));

  	switch ($cond) {
  		case "ясно":
  			return 'iconSun.mov';
  			break;

  		case "пасмурно":
  			return 'iconClouds.mov';
  			break;

      case 'облачно':
  			return 'iconClouds.mov';
  			break;

  		case 'облачно с прояснениями':
  			return 'iconCloudSun.mov';
  			break;

  		case 'малооблачно':
  			return 'iconCloudSun.mov';
  			break;

  		case 'переменная облачность':
  			return 'iconCloudSun.mov';
  			break;

  		case 'небольшой дождь':
  			return 'iconRainLight.mov';
  			break;

      case 'небольшой':
  			return 'iconRainLight.mov';
  			break;

  		case 'дождь':
  			return 'iconRainMedium.mov';
  			break;

      case 'осадки':
  			return 'iconRainMedium.mov';
  			break;

  		case 'сильный дождь':
  			return 'iconRainHeavy.mov';
  			break;

  		case 'гроза':
  			return 'iconStorm.mov';
  			break;

  		case 'дождь со снегом':
  			return 'iconSnowRain.mov';
  			break;

      case 'снег с дождём':
  			return 'iconSnowRain.mov';
  			break;

  		case 'ливень':
  			return 'iconRainHeavy.mov';
  			break;

  		case 'снег':
  			return 'iconSnowMedium.mov';
  			break;

      case 'мокрый снег':
  			return 'iconSnowMedium.mov';
  			break;

      case 'мокрый снег':
  			return 'iconSnowMedium.mov';
  			break;

  		case 'небольшой снег':
  			return 'iconSnowLight.mov';
  			break;

  		default:
  			return 'значение не задано или не корректно!!!';
  			break;
  	}

    // return $cond;
  }


  public function transCondN ($condition){

  	$condition = explode(', ', $condition);

  	if(count($condition) > 1) {

  		$cond = $condition[count($condition)-1];

  	}	else {

  		$cond = $condition[0];
  	}

  	// return $cond = trim(mb_convert_case($cond, MB_CASE_LOWER, "UTF-8"));

    $cond = strip_tags($cond);

    $cond = trim(mb_strtolower($cond));

  	switch ($cond) {
  		case 'ясно':
  			return 'iconMoon.mov';
  			break;

  		case 'пасмурно':
  			return 'iconClouds.mov';
  			break;

      case 'облачно':
  			return 'iconClouds.mov';
  			break;

  		case 'облачно с прояснениями':
  			return 'iconCloudMoon.mov';
  			break;

  		case 'малооблачно':
  			return 'iconCloudMoon.mov';
  			break;

  		case 'переменная облачность':
  			return 'iconCloudMoon.mov';
  			break;

  		case 'небольшой дождь':
  			return 'iconRainLight.mov';
  			break;

      case 'небольшой':
  			return 'iconRainLight.mov';
  			break;

  		case 'дождь':
  			return 'iconRainMedium.mov';
  			break;

      case 'осадки':
  			return 'iconRainMedium.mov';
  			break;

  		case 'сильный дождь':
  			return 'iconRainHeavy.mov';
  			break;

  		case 'гроза':
  			return 'iconStorm.mov';
  			break;

  		case 'дождь со снегом':
  			return 'iconSnowRain.mov';
  			break;

      case 'снег с дождём':
  			return 'iconSnowRain.mov';
  			break;

  		case 'ливень' :
  			return 'iconRainHeavy.mov';
  			break;

  		case 'снег':
  			return 'iconSnowMedium.mov';
  			break;

      case 'мокрый снег':
  			return 'iconSnowMedium.mov';
  			break;

      case 'мокрый снег':
  			return 'iconSnowMedium.mov';
  			break;

  		case 'небольшой снег':
  			return 'iconSnowLight.mov';
  			break;

  		default:
  			return 'значение не задано или не корректно!!!';
  			break;
  	}
  }



  public function transWind ($wind){

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

  	// return 'Ветер ' . $wind[2] . ' ' . $wind[0] . ' м/с';
    return $wind[2] . ' ' . $wind[0];

  }

  public function gisTransWind ($wind){

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


  public function dropHellip ($str){

  	$substr = trim(preg_replace('/[^0-9\°\+\-\−]+/', ' ', preg_replace('/\ /', '', $str)));

  	// if (strlen($substr) < 7){
    //
  	// 	$sign = mb_substr($substr, 0, 1);
    //
  	// 	$tmp = (int)preg_replace('/[^\d\+\-]+/', '', $substr);

  		// if ($sign == '+') {
      //
  		// 	$newVal = $tmp-2;
      //
  		// 	$substr = $sign . $newVal . "°" . " " . $substr . "°";
      //
  		// }
      //
  		// if ($sign == '−') {
      //
  		// 	$newVal = $tmp+2;
      //
  		// 	$substr =  $sign . $newVal . "°" . " " . $substr . "°";
      //
  		// }

  	// }

  	// $substr = explode(' ', $substr)[0] . ' ... ' . explode(' ', $substr)[1];

    // return $substr;

    $temp = explode(' ', $substr);

    $this->errs[] = $temp;

    if (count($temp)>1){

      return $temp[1];

    }

    else {

      return $temp[0];

    }

  }


}
