<?php

  if (isset($_POST['test'])){

    print_r($_POST);

    $text = mb_strtolower($_POST['test'], 'UTF-8');

    echo "текст = " . $text . "<br>";

    $text = explode(" ", $text);

    foreach ($text as $key => $value) {
      # code...

      echo "value = " . $value . "<br>";

      switch ($value) {
        case 'ясно':
        $text[$key] = "iconSun.mov";
          # code...
          break;

        case 'дождь':
          $text[$key] = "iconRainLight.mov";
          break;

        default:
          $text[$key] = 'default <br>';
          break;
      }
    }

    print_r($text);


  }


?>
