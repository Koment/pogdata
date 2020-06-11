<?php

// namespace factory;
//
// use factory;
// use pogoda;

function __autoload($class_name){
  require ($class_name . ".php");
}

$pogodafactory = new pogodaFactory();

$pogoda = $pogodafactory->getPog($_POST);

// print("<pre>".print_r($pogoda,true)."</pre>");

// print_r($pogoda);
// die();

// $txtData = $pogoda->txtData;
//
// $valsData = $pogoda->valsData;

// foreach ($pogoda->days as $day) {
//   # code...
//
//   $jsonData[] = array_merge($pogoda->txtData[$day], $pogoda->valsData[$day]);
//
//   if (file_put_contents('MeteoData-'.$day.'.json', json_encode($jsonData, JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT))){
//
//     echo "<br><br>json file created succesfuly!<br><br>";
//   }
//   else {
//
//     echo "<br><br>Some errore ocure =(...";
//   }
//
// }

// $jsonData = array_merge($pogoda->txtData, $pogoda->valsData[]);

// echo 'errs = <br><br>';
// print_r($pogoda->errs);
//
// echo "<br><br>";
//
// echo 'txtData = <br><br>';
// print_r($pogoda->txtData);
//
// echo "<br><br>";
//
// echo 'valsData = <br><br>';
// print_r($pogoda->valsData);
//
// echo "<br><br>";
//
// echo 'jsonData = <br><br>';
// print_r($jsonData);
//
// echo "<br><br>";

$makeScript = new makeScript();

$makeScript->makeScript($pogoda->valsData, $pogoda->txtData, $pogoda->days, $pogoda->site, $pogoda->month, $pogoda->cityes);
