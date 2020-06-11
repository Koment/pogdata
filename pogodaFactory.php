<?php

// namespace pogodafactory\factory;

// use pogoda;

class pogodaFactory {

  public $data = NULL;

  function __construct(){

  }

  function getPog($param) {

    switch ($param) {
      case isset($param['ya']):
        $this->data = new pogodaYandex($param);
        break;

      case isset($param['gis']):
        $this->data = new pogodaGismeteo($param);
        break;

      default:
        $this->$data = "wrong pogoda type!";
        break;
    }

    return $this->data;

  }

}
