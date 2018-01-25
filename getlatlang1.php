<?php
require_once('db.php');

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

	$f_minute = substr($minutes, 0, 1);

	if($f_minute == '0')
	{
		$minutes = substr($minutes, 1);
	}

	if( ($hour == '23') && ($minutes == '55' ||  $minutes == '56'  ||  $minutes == '57' ||  $minutes == '58' ||  $minutes == '59') )
	{
		$s_weekday = $weekday;
		$e_weekday = $weekday+1;

		if($weekday == '6')
		{
			$e_weekday = '0';
		}			

		$s_hour = '23';
		$e_hour = '0';

		$s_minute = $minutes-5;
		$e_minute = ($minutes + 5)- 60;
	}
	else if( ($hour == '0') && ($minutes == '0' ||  $minutes == '1'  ||  $minutes == '2' ||  $minutes == '3' ||  $minutes == '4') )
	{		
		$s_weekday = $weekday-1;
		$e_weekday = $weekday;

		if($weekday == '0')
		{
			$s_weekday = '6';
		}
		
		$s_hour = '23';
		$e_hour = '0';

		$s_minute = ($minutes+60)-5;

		$e_minute = $minutes+5;
	}
	else
	{
		$s_weekday = $weekday;
		$e_weekday = $weekday;
		
		$s_hour = $hour;
		$e_hour = $hour;

		$s_minute = $minutes-5;
		$e_minute = $minutes+5;

		if ($minutes == '0' ||  $minutes == '1'  ||  $minutes == '2' ||  $minutes == '3' ||  $minutes == '4')
		{
			$s_hour = $hour-1;
			$s_minute = ($minutes+60)-5;
		}

		if ($minutes == '55' ||  $minutes == '56'  ||  $minutes == '57' ||  $minutes == '58' ||  $minutes == '59')
		{
			$e_hour = $hour+1;
			$e_minute = ($minutes + 5)- 60;
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
		$sql = "SELECT * from heatmap where (day = '".$s_weekday."' and timing between '".$start_timing."' and '".$end_timing."') order by timing asc";		
	}
	else
	{
		if( ($hour == '23') )
		{
			if($minutes == "55")
			{
				$s_timing = '23:50:00';
				$e_timing = '23:59:00';

				$se_timing = '00:00:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing = '".$se_timing."') ) order by timing desc";
			}

			else if($minutes == "56")
			{
				$s_timing = '23:51:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:01:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "57")
			{
				$s_timing = '23:52:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:02:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "58")
			{
				$s_timing = '23:53:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:03:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "59")
			{
				$s_timing = '23:54:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:04:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}
		}
		else if( ($hour == '0') )
		{
			if($minutes == "0")
			{
				$s_timing = '23:55:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:05:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "1")
			{
				$s_timing = '23:56:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:06:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "2")
			{
				$s_timing = '23:57:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:07:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "3")
			{
				$s_timing = '23:58:00';
				$e_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:08:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing between '".$s_timing."' and '".$e_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}

			else if($minutes == "4")
			{
				$s_timing = '23:59:00';

				$se_timing1 = '00:00:00';
				$se_timing2 = '00:09:00';

				$sql = "SELECT * from heatmap where ( (day = '".$s_weekday."' and timing = '".$s_timing."') or (day = '".$e_weekday."' and timing between '".$se_timing1."' and '".$se_timing2."') ) order by timing desc";
			}
		}
	}

	
	$query = mysqli_query($con, $sql);
	$count = mysqli_num_rows($query);

	if ($count > 0) 
	{	
		while($row = mysqli_fetch_assoc($query)) 
		{
			$result[] = array('latitude'=>$row['latitude'],'longitude'=>$row['longitude']);
		}
	}
}
echo json_encode($result);
?>