<?php

// namespace pogodafactory\pogoda;

class pogodaYandex extends pogoda {

  private $date;

  function __construct($date) {

    $this->site = "Yandex Погода";

    $this->date = $this->proceedDate($date['ya']);

    $this->getValues();

  }

  private function getValues(){

    // foreach ($this->cityes as $key => $val) {

    foreach (array_keys($this->cityes) as $key => $val) {

  		$data = file_get_html('https://yandex.ru/pogoda/'. $val .'/details');

  		foreach ($this->days as $day) {
  			# code...

        for ($i = 0; $i < 5; $i++){

        	if (trim($data->find('strong.forecast-details__day-number', $i)->plaintext) == $day) {

            $curvals = $data->find('table.weather-table', $i);

            $nextDay = $data->find('table.weather-table', $i+1);

            $s = 'text';

            $c = $key+1;

            $this->valsData[$day][$c."city"] = $this->cityes[$val];

            // $this->valsData[$day][$c."TempDayT"] = $this->dropHellip($curvals->find('div.weather-table__temp', 1)->plaintext);
            // $this->valsData[$day][$c."TempNightT"] = $this->dropHellip($curvals->find('div.weather-table__temp', 3)->plaintext);
            // $this->valsData[$day][$c."TempDayAT"] = $this->dropHellip($nextDay->find('div.weather-table__temp', 1)->plaintext);
            // $this->valsData[$day][$c."TempNightAT"] = $this->dropHellip($nextDay->find('div.weather-table__temp', 3)->plaintext);

            $this->valsData[$day][$c."TempDayT"] = $this->dropHellip($curvals->find('div.weather-table__temp', 1)->plaintext);
            $this->valsData[$day][$c."TempNightT"] = $this->dropHellip($curvals->find('div.weather-table__temp', 3)->plaintext);
            $this->valsData[$day][$c."TempDayAT"] = $this->dropHellip($nextDay->find('div.weather-table__temp', 1)->plaintext);
            $this->valsData[$day][$c."TempNightAT"] = $this->dropHellip($nextDay->find('div.weather-table__temp', 3)->plaintext);

            $this->valsData[$day][$c."Graf"] = "800, 509, 509, 0";

            $this->valsData[$day][$c."CondDayT"] =  $curvals->find('td.weather-table__body-cell_type_condition', 1)->plaintext;
            $this->valsData[$day][$c."CondNightT"] =  $curvals->find('td.weather-table__body-cell_type_condition', 3)->plaintext;
            $this->valsData[$day][$c."CondDayAT"] =  $nextDay->find('td.weather-table__body-cell_type_condition', 1)->plaintext;
            $this->valsData[$day][$c."CondNightAT"] =  $nextDay->find('td.weather-table__body-cell_type_condition', 3)->plaintext;

            $this->valsData[$day][$c."IconDayT"] =  $this->transCond($curvals->find('td.weather-table__body-cell_type_condition', 1)->plaintext);
            $this->valsData[$day][$c."IconNightT"] =  $this->transCondN($curvals->find('td.weather-table__body-cell_type_condition', 3)->plaintext);
            $this->valsData[$day][$c."IconDayAT"] =  $this->transCond($nextDay->find('td.weather-table__body-cell_type_condition', 1)->plaintext);
            $this->valsData[$day][$c."IconNightAT"] =  $this->transCondN($nextDay->find('td.weather-table__body-cell_type_condition', 3)->plaintext);

            $this->valsData[$day][$c."WindDayT"] = "ветер " . $curvals->find('abbr.icon-abbr', 1)->plaintext;
            $this->valsData[$day][$c."WindNightT"] = "ветер " . $curvals->find('abbr.icon-abbr', 3)->plaintext;
            $this->valsData[$day][$c."WindDayAT"] = "ветер " . $nextDay->find('abbr.icon-abbr', 1)->plaintext;
            $this->valsData[$day][$c."WindNightAT"] = "ветер " . $nextDay->find('abbr.icon-abbr', 3)->plaintext;

            $this->valsData[$day][$c."ForceDayT"] = ($curvals->find('span.wind-speed', 1)->plaintext == '') ? 'штиль' : $curvals->find('span.wind-speed', 1)->plaintext . " м/с";

            $this->valsData[$day][$c."ForceNightT"] = ($curvals->find('span.wind-speed', 3)->plaintext == '') ? 'штиль' : $curvals->find('span.wind-speed', 3)->plaintext . " м/с";

            $this->valsData[$day][$c."ForceDayAT"] = ($nextDay->find('span.wind-speed', 1)->plaintext == '') ? 'штиль' : $nextDay->find('span.wind-speed', 1)->plaintext . " м/с";

            $this->valsData[$day][$c."ForceNightAT"] = ($nextDay->find('span.wind-speed', 3)->plaintext == '') ? 'штиль' :$nextDay->find('span.wind-speed', 3)->plaintext . " м/с";

            $this->valsData[$day][$c."PressureDayT"] = trim($curvals->find('td.weather-table__body-cell_type_air-pressure', 1)->plaintext) . " мм";
            $this->valsData[$day][$c."PressureNightT"] = trim($curvals->find('td.weather-table__body-cell_type_air-pressure', 3)->plaintext) . " мм";
            $this->valsData[$day][$c."PressureDayAT"] = trim($nextDay->find('td.weather-table__body-cell_type_air-pressure', 1)->plaintext) . " мм";
            $this->valsData[$day][$c."PressureNightAT"] = trim($nextDay->find('td.weather-table__body-cell_type_air-pressure', 3)->plaintext) . " мм";

  					break;

  					}
  				}
  			}
  		}
    }


}
