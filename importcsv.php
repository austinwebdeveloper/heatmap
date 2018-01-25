<?php
ob_start();

require_once('db.php');


if (($handle = fopen("EosMapsData.csv", "r")) !== FALSE)
{
	//get header
	$header = fgetcsv($handle);

	if(count($header) == "5")
	{
		$log_file = 'importcsv_log.txt';

		file_put_contents($log_file, "");

		$i = 1;	
		
		$k = 0;
		
		$value = '';

		$startval = 1;

		//$endval = $startval + 1000;		
			
		//get content	   
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{	
			if($i >= $startval) 			
			{
				//combine header and content
				$csv_data = array_combine($header, $data);	

				$unique_id = $csv_data['uniqueid'];						
				$latitude = $csv_data['startlat'];						
				$longitude = $csv_data['startlon'];						
				$day = $csv_data['day'];
				$time = $csv_data['time'];
				
				$time = $time.':00';
						
				$value.= "('$unique_id', '$latitude', '$longitude', '$day', '$time'),";
				 
				if($k == 1)
				{
					if($value!='')
					{
						$new_sql = "SELECT * FROM heatmap where uniqueid = '".$unique_id."'  ";

                    	$new_result = mysqli_query($con, $new_sql);

                        if (mysqli_num_rows($new_result) == 0) 
	                    {
	                        $value= rtrim($value,',');
	                        
						    $query = "INSERT INTO heatmap (uniqueid, latitude, longitude, day, timing) VALUES ".$value;
						
						    $sql = mysqli_query($con, $query);
												
						    file_put_contents($log_file, $query, FILE_APPEND);	
						
	                    }
					}

					$k = 0;
						
					$value = '';					
				}
				else
				{
					$k++;
				}				
			}

			$i++;
		}
	}
}
else
{
	echo '<br/><br/>unable to read file<br/><b/>';
}

fclose($handle);

?>

<?php
ob_flush();
?>
