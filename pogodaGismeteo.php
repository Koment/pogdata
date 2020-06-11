<?php

// namespace pogoda;

class pogodaGismeteo extends pogoda{

  private $date;

  function __construct($date) {

    $this->site = "Gismeteo.ru";

    $this->date = $this->proceedDate($date['gis']);

    $this->getValues();

  }

  private function getValues(){

    $dp=[];

  	// foreach ($this->cityes as $key => $val) {

    foreach (array_keys($this->cityes) as $key => $val) {

      $data = file_get_html('https://www.gismeteo.ru/'. $this->giscode[$val] .'/3-days/');


  		foreach ($this->days as $day) {

        // echo "day = " . $day . "<br><br>";
        //
        // echo "header0 = " . $this->errs[0] = $data->find('div.header_item', 0)->plaintext . "<br><br>";
        //
        // echo "header1 = " . $this->errs[1] = $data->find('div.header_item', 1)->plaintext . "<br><br>";
        //
        // echo "header2 = " . $this->errs[2] = $data->find('div.header_item', 2)->plaintext . "<br><br>";
        //
        // echo "header3 = " . $this->errs[3] = $data->find('div.header_item', 3)->plaintext . "<br><br>";



        if (explode(' ', $data->find('div.header_item', 1)->plaintext)[1] == $day){

          $dp = [0,2,4,6];

        }

        if (explode(' ', $data->find('div.header_item', 2)->plaintext)[1] == $day){

          $dp = [4,6,8,10];

        }

        $this->errs['dp'] = $dp;



        // for ($i = 1; $i > 3; $i++) {
        //
        //   echo "for inPoint!!!!!!!!";
        //
        //   echo "header = " . $data->find('div.header_item', $i)->plaintext . "<br><br>";
        //
        //   if (explode(' ', $data->find('div.header_item', $i)->plaintext)[1] == $day){
        //
        //     if($i == 0){
        //
        //       $dp = [0,2,4,6];
        //
        //       break;
        //
        //     } elseif ($i == 1) {
        //
        //       $dp = [4,6,8,10];
        //
        //       break;
        //
        //     } elseif ($i == 2) {
        //
        //       $dp = [8,10,12,14];
        //
        //       break;
        //     }
        //
        //     $this->errs[$day][$i] = $dp;
        //
        //   }
        //
        // }
        //
        // echo "after for... <br><br>";

        $s = 'data-text';

        $wd = $data->find('div.widget__row_wind', 0);
        $pr = $data->find('div.widget__row_pressure', 0);

        $c = $key+1;

        $this->valsData[$day][$c."city"] = $this->cityes[$val];
        $this->valsData[$day][$c."TempDayT"] = trim($data->find('span.unit_temperature_c', $dp[1])->plaintext) . "°";
        $this->valsData[$day][$c."TempNightT"] = trim($data->find('span.unit_temperature_c', $dp[0])->plaintext) . "°";
        $this->valsData[$day][$c."TempDayAT"] = trim($data->find('span.unit_temperature_c', $dp[3])->plaintext) . "°";
        $this->valsData[$day][$c."TempNightAT"] = trim($data->find('span.unit_temperature_c', $dp[2])->plaintext) . "°";

        $this->valsData[$day][$c."Graf"] = "800, 509, 509, 0";

        $this->valsData[$day][$c."CondDayT"] =  trim(strip_tags($data->find('span.tooltip', $dp[1])->$s));
        $this->valsData[$day][$c."CondNightT"] =  trim(strip_tags($data->find('span.tooltip', $dp[0])->$s));
        $this->valsData[$day][$c."CondDayAT"] =  trim(strip_tags($data->find('span.tooltip', $dp[3])->$s));
        $this->valsData[$day][$c."CondNightAT"] =  trim(strip_tags($data->find('span.tooltip', $dp[2])->$s));

        $this->valsData[$day][$c."IconDayT"] =  $this->transCond($data->find('span.tooltip', $dp[1])->$s);
        $this->valsData[$day][$c."IconNightT"] =  $this->transCondN($data->find('span.tooltip', $dp[0])->$s);
        $this->valsData[$day][$c."IconDayAT"] =  $this->transCond($data->find('span.tooltip', $dp[3])->$s);
        $this->valsData[$day][$c."IconNightAT"] =  $this->transCondN($data->find('span.tooltip', $dp[2])->$s);

        $this->valsData[$day][$c."WindDayT"] = "ветер " . trim($wd->find('div.w_wind__direction', $dp[1])->plaintext);
        $this->valsData[$day][$c."WindNightT"] = "ветер " . trim($wd->find('div.w_wind__direction', $dp[0])->plaintext);
        $this->valsData[$day][$c."WindDayAT"] = "ветер " . trim($wd->find('div.w_wind__direction', $dp[3])->plaintext);
        $this->valsData[$day][$c."WindNightAT"] = "ветер " . trim($wd->find('div.w_wind__direction', $dp[2])->plaintext);

        $this->valsData[$day][$c."ForceDayT"] = trim($wd->find('span.unit_wind_m_s', $dp[1])->plaintext) . " м/с";
        $this->valsData[$day][$c."ForceNightT"] = trim($wd->find('span.unit_wind_m_s', $dp[0])->plaintext) . " м/с";
        $this->valsData[$day][$c."ForceDayAT"] = trim($wd->find('span.unit_wind_m_s', $dp[3])->plaintext) . " м/с";
        $this->valsData[$day][$c."ForceNightAT"] = trim($wd->find('span.unit_wind_m_s', $dp[2])->plaintext) . " м/с";

        $this->valsData[$day][$c."PressureDayT"] = trim($pr->find('span.unit_pressure_mm_hg_atm', $dp[1])->plaintext) . " мм";
        $this->valsData[$day][$c."PressureNightT"] = trim($pr->find('span.unit_pressure_mm_hg_atm', $dp[0])->plaintext) . " мм";
        $this->valsData[$day][$c."PressureDayAT"] = trim($pr->find('span.unit_pressure_mm_hg_atm', $dp[3])->plaintext) . " мм";
        $this->valsData[$day][$c."PressureNightAT"] = trim($pr->find('span.unit_pressure_mm_hg_atm', $dp[2])->plaintext) . " мм";

  		}

  	}

  }

}


?>
