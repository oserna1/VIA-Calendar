<!DOCTYPE html>
<html>
<head>
</head>

<body>
<h1>Hello World</h1>

<?php

$origin = '8801 Cinnamon Creek dr, San Antonio, TX, 78240';
$destination = '8233 Potranco Road';
$apiKey='AIzaSyAHkOp4TdEBDVIV6H9192SghZ-h4idguAU';

function urlBuilder($origin, $destination, $apiKey)
{
    $stringBase='https://maps.googleapis.com/maps/api/directions/json?mode=transit&transit_mode=bus&';

    $origin = str_replace(' ','+', $origin);
    $destination = str_replace(' ','+', $destination);


    $final = $stringBase.'origin='.$origin.'&destination='.$destination.'&key='.$apiKey;

    return $final;

        }

$request = urlBuilder($origin,$destination,$apiKey);

$jsontmp = file_get_contents($request);

$fare=0;//cost of trip
$length=0;//length of trip in meters
$distance=0;//length of trip in seconds
$numHops=0;
$json = json_decode($jsontmp, TRUE);
foreach($json['routes'][0] as $key=>$val)//first route associative array
{
  if($key == 'legs')
  {
    foreach($val as $val2)//iterate through leg array
    {
      $numHops++;
      foreach($val2 as $key3=>$val3)//associative array in each leg array member
      {
        if($key3 == 'duration')
        {
          $length += $val3['value'];
          echo $length;
          echo "<br>";
        }

        if($key3 == 'distance')
        {
          $distance += $val3['value'];
          echo $distance;
          echo "<br>";
        }
      }
    }
  }
  if($key == 'fare')
  {
    $fare = $val['text'];
    echo $fare;
    echo "<br>";
  }
}

echo "echo $numHops";
echo "<br>";

$mile = $distance/1609.34;
$hours = floor($length / 3600);
$minutes =  ($length / 60) - ($hours * 60); 

printf("Final time : %d:%d\n", $hours, $minutes); 
echo "<br>";

printf("Final Length : %.2f miles", $mile);
echo "<br>";

$mapURLBase="https://www.google.com/maps/dir/?api=1&travelmode=transit&";
$origin = str_replace(' ','+', $origin);
$destination = str_replace(' ','+', $destination);


echo "$mapURLBase&orgin=$origin&destination=$destination";



?>
</body>
</html>
