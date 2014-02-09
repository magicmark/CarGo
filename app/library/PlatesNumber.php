<?php

use Phalcon\Mvc\User\Component;

class PlatesNumber extends Component
{
  public $plateNumber;
  public $image;

  private function swap( $input, $index )
  {
    for( $i = $index; $i < count($input); $i++ )
    {
      switch ($input[$i]) {
        case '0':
          $result1 = $this->swap($input, $i+1);
          $input[$i] = 'O';
          $result2 = $this->swap($input, $i+1);
          echo $result2 . ' ' . $result1
          return array_merge($result1, $result2);
          break;
        
        case 'O':
          $result1 = $this->swap($input, $i+1);
          $input[$i] = '0';
          $result2 = $this->swap($input, $i+1);
          return array_merge($result1, $result2);
          break;

        case '5':
          $result1 = $this->swap($input, $i+1);
          $input[$i] = 'S';
          $result2 = $this->swap($input, $i+1);
          return array_merge($result1, $result2);
          break;

        case 'S':
          $result1 = $this->swap($input, $i+1);
          $input[$i] = '5';
          $result2 = $this->swap($input, $i+1);
          return array_merge($result1, $result2);
          break;

        default:
          break;
      }
    }
    $result = array($input);
    $result[] = $input;
    return $result;
  }

  public function getPlateNumbers( $image = null )
  {
    exec("/home/steve/plateRecognition/openalpr/src/alpr ". $image ."  -r /home/steve/plateRecognition/openalpr/runtime_data/", $output1);
    exec("/home/steve/plateRecognition/openalpr/src/alpr ". $image ." -c eu -r /home/steve/plateRecognition/openalpr/runtime_data/", $output2);
    exec("/home/steve/plateRecognition/openalpr/src/alpr ". $image ." -c us -r /home/steve/plateRecognition/openalpr/runtime_data/", $output3);
    
    $output = array_merge($output1, $output2,$output3);

    /*$output = array();
    for( $i = 0; $i < count($outputPre); $i++)
      array_merge($output, $this->swap($outputPre[$i], 0));*/
    
    $plateNumberTemp = array();

    //var_dump($output);

    for( $i = 0; $i < count($output); $i++)
      preg_match("/^[ ]*\- ([A-za-z0-9]*)/", $output[$i], $plateNumberTemp[$i-1] );

    $this->plateNumber = array();
    for( $i = 0; $i < count($plateNumberTemp); $i++)
      if( isset($plateNumberTemp[$i][1]))
        // $this->plateNumber[] = $plateNumberTemp[$i][1];
        $this->plateNumber = array_merge( $this->plateNumber, $this->swap($plateNumberTemp[$i][1], 0));

  	return $this->plateNumber;
  }

}

?>
