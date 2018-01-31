<?php
require_once('db.php');
   date_default_timezone_set('US/Eastern');

$date = $_REQUEST['date'];
$weekday = $_REQUEST['weekday'];
$hour = $_REQUEST['hour'];
$minutes = $_REQUEST['minutes'];

$result = array();

if(!empty($weekday) && !empty($hour) && !empty($minutes) )
{
	$weekday = substr($weekday, 1);

	$f_hour = substr($hour, 0, 1);

	if($f_hour == '0')
	{
		$hour = substr($hour, 1);
	}

	if( ($hour == '23') && ($minutes >=29))
	{
		$s_weekday = $weekday;
		$e_weekday = $weekday+1;

		if($weekday == '6')
		{
			$e_weekday = '0';
		}			

		$s_hour = '23';
		$e_hour = '0';

		$s_minute = $minutes;

	    	$e_minute = ($minutes+30)-60;

	
	}
	else if( ($hour == '0'))
	{		
		$s_weekday = $weekday;
		$e_weekday = $weekday;

	
		
		$s_hour = '0';
		$e_hour = '0';

		$s_minute = $minutes;

		   if($minutes>=29)
    	{ 
	        $e_hour = $hour+1;
	    	$e_minute = ($minutes+30)-60;
	}
	else{
		$e_minute = $minutes+30;
	}
	}
	else
	{
		$s_weekday = $weekday;
		$e_weekday = $weekday;
		
		$s_hour = $hour;
		$e_hour = $hour;

		$s_minute = $minutes;
		  if($minutes>=29)
    	{ 
	        $e_hour = $hour+1;
	    	$e_minute = ($minutes+30)-60;
	}
	else{
		$e_minute = $minutes+30;
	}


	}

	if(strlen($s_hour) == "1") { $s_hour = '0'.$s_hour; }
	if(strlen($e_hour) == "1") { $e_hour = '0'.$e_hour; }
	if(strlen($s_minute) == "1") { $s_minute = '0'.$s_minute; }
	if(strlen($e_minute) == "1") { $e_minute = '0'.$e_minute; }

	$seconds = '00';

	$start_timing = $s_hour.':'.$s_minute.':'.$seconds;
	$end_timing = $e_hour.':'.$e_minute.':'.$seconds;

	if($s_weekday == $e_weekday)
	{
		$sql = "SELECT * from 2016primary_table where (day = '".$s_weekday."' and time between '".$start_timing."' and '".$end_timing."') order by time asc";		
	}
	else
	{
		if( ($hour == '23') )
		{
			if($minutes == "29")
			{
				$s_timing = '23:29:00';
				$e_timing = '23:59:00';

				$se_timing = '23:59:00';

				$sql = "SELECT * from 2016primary_table where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time = '".$se_timing."') ) order by time desc";
			}

			else if($minutes == "30")
			{
				$s_timing = '23:30:00';
			$e_timing = '23:59:00';

                 $se_timing1 = '00:00:00';
				$se_timing2 = '00:00:00';

				$sql = "SELECT * from 2016primary_table where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time between '".$se_timing1."' and '".$se_timing2."') ) order by time desc";
			}

			else if($minutes >= "31")
			{
			    $timing = '23:'.$minutes.':00';
				$s_timing = $timing;
		
	    	$e_minute = ($minutes+30)-60;

				$e_timing = '23:59:00';

                 $se_timing1 = '00:00:00';
				$se_timing2 = '00:'.$e_minute.':00';

				$sql = "SELECT * from 2016primary_table where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time between '".$se_timing1."' and '".$se_timing2."') ) order by time desc";
			}

			else if($minutes < "29")
			{
			   
			       $timing = '23:'.$minutes.':00';
		           $e_minute = $minutes+30;
		 				$s_timing = $timing;

			$e_timing = '23:59:00';

                 $se_timing1 = '00:00:00';
				$se_timing2 = '00:'.$e_minute.':00';

				$sql = "SELECT * from 2016primary_table where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time between '".$se_timing1."' and '".$se_timing2."') ) order by time desc";
			}


		}
		
		}
	
	
	
	$query = mysqli_query($con, $sql);
	$count = mysqli_num_rows($query);

	if ($count > 0) 
	{	
		while($row = mysqli_fetch_assoc($query)) 
		{
			//$result[] = array('['.$row['latitude'],$row['longitude'].']');
			
			$result[] = array('latitude'=>floatval($row['startlat']),'longitude'=>floatval($row['startlon']) );
		}
	}
}
//echo $sql;

//echo json_encode($result);


 $weekday1=explode("-",$date);

$result3 = array();
//echo 'start_date'.$date;



if(!empty($date)  && !empty($minutes) )
{
    $weekday11 = $weekday1[2];
   	$weekday = $weekday;
    
	$f_hour = substr($hour, 0, 1);

	if($f_hour == '0')
	{
		$hour = substr($hour, 1);
	}

	$f_minute = substr($minutes, 0, 1);

	if($f_minute == '0')
	{
		$minutes = substr($minutes, 1);
	}

	if( ($hour == '23') && ($minutes >=29))
	{
		$s_weekday = $weekday;
		$e_weekday = $weekday+1;

	/*	if($weekday == '6')
		{
			$e_weekday = '0';
		}	*/		

		$s_hour = '23';
		$e_hour = '0';

		$s_minute = $minutes;

	    	$e_minute = ($minutes+30)-60;

	
	}
	else if( ($hour == '0'))
	{		
		$s_weekday = $weekday;
		$e_weekday = $weekday;

	
		
		$s_hour = '0';
		$e_hour = '0';

		$s_minute = $minutes;

		   if($minutes>=29)
    	{ 
	        $e_hour = $hour+1;
	    	$e_minute = ($minutes+30)-60;
	}
	else{
		$e_minute = $minutes+30;
	}
	}
	else
	{
		$s_weekday = $weekday;
		$e_weekday = $weekday;
		
		$s_hour = $hour;
		$e_hour = $hour;

		$s_minute = $minutes;
		  if($minutes>=29)
    	{ 
	        $e_hour = $hour+1;
	    	$e_minute = ($minutes+30)-60;
	}
	else{
		$e_minute = $minutes+30;
	}


	}


	if(strlen($s_hour) == "1") { $s_hour = '0'.$s_hour; }
	if(strlen($e_hour) == "1") { $e_hour = '0'.$e_hour; }
	if(strlen($s_minute) == "1") { $s_minute = '0'.$s_minute; }
	if(strlen($e_minute) == "1") { $e_minute = '0'.$e_minute; }

	$seconds = '00';

	$start_timing = $s_hour.':'.$s_minute.':'.$seconds;
	$end_timing = $e_hour.':'.$e_minute.':'.$seconds;
	$aweekday=$weekday1[0]."-".$weekday1[1]."-".$weekday11;
	
$sql_fest="SELECT * from fest_names where ('".$aweekday."' >=new_start_date  and  '".$aweekday."'<=new_end_date)";
//echo $sql_fest;
$query_fest = mysqli_query($con, $sql_fest);
$result1= $query_fest->fetch_assoc();
//echo $result1['festivel_name'];

	$count = mysqli_num_rows($query_fest);

	if($count>0)
	{	   //echo $s_weekday.$e_weekday;


	if($s_weekday == $e_weekday)
	{
		$sql1 = "SELECT * from ".$result1['festivel_name']." where (day = '".$s_weekday."' and time between '".$start_timing."' and '".$end_timing."') order by time asc";		
	}
	else
	{
		if( ($hour == '23') )
		{
			if($minutes == "29")
			{
				$s_timing = '23:29:00';
				$e_timing = '23:59:00';

				$se_timing = '23:59:00';

				$sql1 = "SELECT * from ".$result1['festivel_name']." where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time = '".$se_timing."') ) order by time desc";
			}

			else if($minutes == "30")
			{
				$s_timing = '23:30:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:00:00';

				$sql1 = "SELECT * from ".$result1['festivel_name']." where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time between '".$se_timing1."' and '".$se_timing2."') ) order by time desc";
			}

			else if($minutes >= "31")
			{
			    $timing = '23:'.$minutes.':00';
				$s_timing = $timing;
		
	    	$e_minute = ($minutes+30)-60;

					$e_timing = '23:59:00';

                 $se_timing1 = '00:00:00';
                $se_timing2 = '00:'.$e_minute.':00';

				$sql1 = "SELECT * from ".$result1['festivel_name']." where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time between '".$se_timing1."' and '".$se_timing2."') ) order by time desc";
			}

			else if($minutes < "29")
			{
			   
			       $timing = '23:'.$minutes.':00';
		           $e_minute = $minutes+30;
		 				$s_timing = $timing;

			$e_timing = '23:59:00';

                 $se_timing1 = '00:00:00';
				$se_timing2 = '00:'.$e_minute.':00';

				$sql1 = "SELECT * from ".$result1['festivel_name']." where ( (day = '".$s_weekday."' and time between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and time between '".$se_timing1."' and '".$se_timing2."') ) order by time desc";
			}


		}
		
		}
	}  
 //echo $sql1;
	$query1 = mysqli_query($con, $sql1);
	
	$count1 = mysqli_num_rows($query1);

	if ($count1 > 0) 
	{	
		while($row = mysqli_fetch_assoc($query1)) 
		{
			//$result[] = array('['.$row['latitude'],$row['longitude'].']');
			//ho $row['start_location_lat'].'viji';
			$result3[] = array('latitude'=>$row['startlat'],'longitude'=>$row['startlon']);
		}
	}
}
$datetime=date("Y-m-d H:i:s");
$date=explode(" ",$datetime);
//echo $date[1];
$result4['heatmap']=array_merge($result3,$result);

$select_frequency="SELECT * FROM `frequency`";
     	$query_frequency = mysqli_query($con, $select_frequency);
	$row=mysqli_fetch_assoc($query_frequency);

//$select_query="SELECT * FROM `user_locations` WHERE (ground='foreground' and created_date='$date[0]' and time(time_to_sec(timediff('$date[1]',time ))  )<='3600') OR (created_date='$date[0]' and (time_to_sec(timediff('$date[1]',time ))  )<='".$row['frequency_value']."')";

$select_query="SELECT * FROM `user_locations` WHERE (ground='foreground' and created_date='$date[0]') OR (created_date='$date[0]' and (time_to_sec(timediff('$date[1]',time ))  )<='3600')";
//echo $select_query;
	$query2 = mysqli_query($con, $select_query);
	
	$count2 = mysqli_num_rows($query2);

	if ($count2 > 0) 
	{	
		while($row2 = mysqli_fetch_assoc($query2)) 
		{
			//$result[] = array('['.$row['latitude'],$row['longitude'].']');			
		$result5[] = array('latitude'=>$row2['startlat'],'longitude'=>$row2['startlon']);
		}
        
	}
	else
	{
	    $result5[] = array(
        'status' =>  'Fail',
        'message' => 'No user locations found'
        );
	}
	$result4['user_locations']=$result5;
echo json_encode($result4);
?>
