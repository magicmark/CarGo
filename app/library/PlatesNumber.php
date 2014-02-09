<?php

use Phalcon\Mvc\User\Component;

class PlatesNumber extends Component
{
  public $plateNumber;
  public $image;

  public function getPlateNumbers( $image = null )
  {
    exec("/Public/openalpr/src/alpr ". $image ." -r /Public/openalpr/runtime_data/", $output);
    $plateNumberTemp = array();
    for( $i = 0; $i < count($output); $i++)
      preg_match("/^[ ]*\- ([A-za-z0-9]*)/", $output[$i], $plateNumberTemp[$i-1] );

    for( $i = 0; $i < count($plateNumberTemp); $i++)
      if( isset($plateNumberTemp[$i][1]))
        $this->plateNumber[] = $plateNumberTemp[$i][1];

  	return $this->plateNumber;
  }

}

?>
