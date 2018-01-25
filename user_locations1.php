<?php
require_once('db.php');
   date_default_timezone_set('US/Eastern');

$startlat=$_REQUEST['startlat'];
$startLon=$_REQUEST['startlon'];
$device_udid=$_REQUEST['device_udid'];
$device_type=$_REQUEST['device_type'];
$ground=$_REQUEST['ground'];
$datetime=date("Y-m-d H:i:s");
$date=explode(" ",$datetime);
//echo $date[0];
if(!empty($startlat) && !empty($startLon) && !empty($device_udid) && !empty($ground) )
{
    $select_query="SELECT * FROM `user_locations` WHERE `device_udid`='".$device_udid."'";
    //echo $select_query;
	$distance='0'; 
    $query1 = mysqli_query($con, $select_query);
   
	while($row = mysqli_fetch_assoc($query1)) 
		{
	
$EarthRadius = 6371000; // radius in meters
$phi1 = deg2rad($startlat);
$phi2 = deg2rad($row['startlat']);
$startlat1=round($startlat);
$startLon1=round($startLon);
$startlat2=round($row['startlat']);
$startLon2=round($row['startLon']);
if($startlat1<$startlat2)
{
$deltaLat = deg2rad($row['startlat'] - $startlat);
}
else
{
    $deltaLat = deg2rad($startlat - $row['startlat']);

}
if($startLon1<$startLon2)
{
$deltaLon = deg2rad($row['startLon'] - $startLon);
}
else
{
    $deltaLon = deg2rad($startLon - $row['startLon']);

}


$a = sin($deltaLat/2) * sin($deltaLat/2) + cos($phi1) * cos($phi2) * sin($deltaLon / 2) * sin($deltaLon / 2);
$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

$tempdistance = $distance;
 $distance = $EarthRadius * $c;

if($tempdistance>$distance)
{
  $distance=$tempdistance;
}
else
{
  $distance=$distance;
}
echo 'viji'.$distance.'v-s';

}
echo 'viji'.$distance;

	$count1 = mysqli_num_rows($query1);

	if ($count1 > 0) 
	{ 
	    
	$Update_query = "UPDATE `user_locations` SET startlat='".$startlat."', startlon='".$startLon."', ground='".$ground."',created_date='".$date[0]."', time='$date[1]' WHERE `device_udid`='".$device_udid."' AND startlat='".$startlat."' AND startlon='".$startLon."'";
    //echo $Update_query;

         if (mysqli_query($con, $Update_query)) {
             $response = array(
             'status' => true,
             'message' => 'Updated Successfully'
             );
          } 
          else
          {
              $response = array(
              'status' =>  'Fail',
              'message' => 'Error updating record:',
              'data' => mysqli_error($con)
             );
          }

   
	}
	else
    {
	   $sql = "INSERT INTO `user_locations` (`startlat`, `startlon`, `device_udid`, `device_type`, `ground`, `created_date`, `time`) VALUES ('$startlat', '$startLon', '$device_udid', '$device_type', '$ground', '$date[0]','$date[1]')";				
	//$query1 = mysqli_query($con, $sql1);
		
     if ($con->query($sql) === TRUE) {
      $response = array(
        'status' => true,
        'message' => 'New record created successfully');
     } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
}
else
{
 $response = array(
        'status' => 'Fail',
        'message' => 'Send all results'    );
    
}

echo json_encode($response);


?>
