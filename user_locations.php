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
    	$query1 = mysqli_query($con, $select_query);
	
	$count1 = mysqli_num_rows($query1);

	if ($count1 > 0) 
	{ 
	    
	$Update_query = "UPDATE `user_locations` SET startlat='".$startlat."', startlon='".$startLon."', ground='".$ground."',created_date='".$date[0]."', time='$date[1]' WHERE `device_udid`='".$device_udid."'";
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
