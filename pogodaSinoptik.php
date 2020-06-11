<?php

// namespace pogoda;

class pogodaSinoptik extends pogoda{

  public $site = "SINOPTIK";

  private $date;



  function __construct($date) {

    $this->date = $this->proceedDate($date['gis']);

    $this->getValues();

  }

  private function getValues(){

  	foreach ($this->cityes as $key => $val) {

  		$data = file_get_html('https://sinoptik.ua/погода-' . $this->sincode[$key] . '/' . $date);

  		foreach ($this->days as $day) {
  			# code...

  			for ($i = 0; $i < 10; $i++){

  				$tmpDate = trim($data->find('span.w_date__date', $i)->plaintext);

  				$tmpDate = explode(' ', trim($tmpDate));

  				if ($tmpDate[0] == $day) {

  					$s = 'data-text';

  					$wd = $data->find('div.widget__container', 1);

  					$tmp = [

  						'pog' => $data->find('span.tooltip', $i)->$s,
              'pogCode' => $this->transCond($data->find('span.tooltip', $i)->$s),
  						'tempDay' => $this->dropHellip($data->find('div.maxt span.unit_temperature_c', $i)->plaintext),
  						'tempNight' => $this->dropHellip($data->find('div.mint span.unit_temperature_c', $i)->plaintext),
  						'wind' => 'Ветер ' . $this->gisTransWind(trim($wd->find('div.w_wind__direction', $i)->plaintext)) . ' ' . trim($wd->find('span.unit_wind_m_s', $i)->plaintext) . ' м/с',

  					];

  					$this->cityes[$key][$day] = $tmp;

  					break;
  				}

  			}

  		}

  	}

  }


}


?>
