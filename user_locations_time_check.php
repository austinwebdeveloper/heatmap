<?php
require_once('db.php');

$datetime=date("Y-m-d H:i:s");
$date=explode(" ",$datetime);

 $select_frequency="SELECT * FROM `frequency`";
     	$query_frequency = mysqli_query($con, $select_frequency);
	$row=mysqli_fetch_assoc($query_frequency);
if($row["frequency_duplicate"]==$row["frequency_value"] || $row["frequency_duplicate"]>0)
{
    $row["frequency_duplicate"]=$row["frequency_duplicate"]-1;
    
    $Update_query = "UPDATE `frequency` SET `frequency_duplicate`='".$row['frequency_duplicate']."' WHERE `id`='".$row['id']."'";
        //echo $Update_query;
    if (mysqli_query($con, $Update_query)) 
    {
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
 $row["frequency_duplicate"]=$row["frequency_value"];
    $Update_query = "UPDATE `frequency` SET `frequency_duplicate`='".$row['frequency_duplicate']."' WHERE `id`='".$row['id']."'";
    if (mysqli_query($con, $Update_query)) 
    {
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
 $select_query="SELECT * FROM `user_locations` WHERE `ground`='foreground' and `created_date`='$date[0]' and (time_to_sec(timediff('$date[1]',time ))  )>60";
     //echo $select_query;
    	$query1 = mysqli_query($con, $select_query);
    	

		$count1 = mysqli_num_rows($query1);

	if ($count1 > 0) 
	{ 
	   while($row1 = $query1->fetch_assoc())
     {
   $Update_query_users = "UPDATE `user_locations` SET ground='background' WHERE `device_udid`='".$row1['device_udid']."' ";
    //echo $Update_query;
     if (mysqli_query($con, $Update_query_users)) {
   $response = array(
        'status' => true,
        'message' => 'Updated Successfully'
    );
} 
   else {
     $response = array(
        'status' =>  'Fail',
        'message' => 'Error updating record:',
        'data' => mysqli_error($con)
    );
}

    
} 
	
	}
	
	else
	{
	   
     $response = array(
        'status' =>  'Fail',
        'message' => 'No records updated'
    );
	}

	
}
	
echo json_encode($response);
	
	
?>