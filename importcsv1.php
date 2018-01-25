<?php
ob_start();

require_once('db.php');


if (($handle = fopen("ACLData.csv", "r")) !== FALSE)
{

	//get header
	$header = fgetcsv($handle);

	if(count($header) == "3")
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
						
				$latitude = $csv_data['StartLat'];						
				$longitude = $csv_data['StartLon'];	
		    	$daytime = $csv_data['created_date'];	
				$daytime1=explode(" ",$daytime);

				
				$day = $daytime1[0];
				$time = $daytime1[1];
				$time = $time.':00';
				$value.= "('$latitude', '$longitude', '$day', '$time'),";
				 
				if($k == 1)
				{
					if($value!='')
					{
					
	                        $value= rtrim($value,',');
	                        
						    $query = "INSERT INTO heatmap3 (latitude, longitude, day, timing) VALUES ".$value;
						echo $query;
						    $sql = mysqli_query($con, $query);
												
						    file_put_contents($log_file, $query, FILE_APPEND);	
						
	                  
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
