<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Heatmap</title>
    <style type="text/css">
    	#map {
		  height: 100%;
		}
		html, body {
		  height: 100%;
		  margin: 0;
		  padding: 0;
		}

		#floating-panel {
		  position: absolute;
		  top: 80px;
		  left: 25%;
		  z-index: 5;
		  background-color: #fff;
		  padding: 5px;
		  border: 1px solid #999;
		  text-align: center;
		  font-family: 'Roboto','sans-serif';
		  line-height: 30px;
		  padding-left: 10px;
		}

		#filters
		{
			margin:20px 10px;
		}

		.filter_labels
		{
			font-size:18px;
			font-weight: 700;
			margin-right:4px;
		}

		.filter_dropdowns
		{
			font-size: 16px;
    		padding: 2px 5px;
    		margin-right:12px;
		}

		.filter_btn 
		{
			padding: 4px 15px;
		    margin-right: 10px;
		    font-size: 16px;
		    display:none;
		}
    </style>
 </head>
 <body>

 	<div id="base_url" style="display:none;">https://w2t.austinconversionoptimization.como/heatmap/</div>

 	<div id="filters">
 		<?php
 		$datetime = date("Y-m-d H:i:s", strtotime('-3 hours'));

 		$weekday = date('w', strtotime($datetime));
 		$hour = date('H', strtotime($datetime));
 		$minutes = date('i', strtotime($datetime)); 		
 		?>

 		<button type="button" id="current_time_btn" class="filter_btn">Current Time</button>
 		<button type="button" id="increment_time_btn" class="filter_btn">Increment Time</button>
		
		<label for="weekday" class="filter_labels">Day:</label>		
		<select id="weekday" class="filter_dropdowns" onchange = "initMap();">
			<?php 
			for($i=0;$i<7;$i++)
			{				
				$m = '0'.$i;  						
			?>
				<option value="<?=$m?>" <?php if($i==$weekday) echo 'selected="selected"'; ?>><?=$i?></option>
			<?php
			}
			?>
		</select>

		<label for="hour" class="filter_labels">Hour:</label>
		<select id="hour" class="filter_dropdowns" onchange = "initMap();">
			<?php 
			for($j=0;$j<24;$j++)
			{
				if(strlen($j) == "1") {$j = '0'.$j;}
			?>
				<option value="<?=$j?>" <?php if($j==$hour) echo 'selected="selected"'; ?> ><?=$j?></option>
			<?php
			}
			?>
		</select>

		<label for="minutes" class="filter_labels">Minute:</label>		
		<select id="minutes" class="filter_dropdowns" onchange = "initMap();">
			<?php 
			for($k=0;$k<60;$k++)
			{
				if(strlen($k) == "1") {$k = '0'.$k;}
			?>
				<option value="<?=$k?>" <?php if($k==$minutes) echo 'selected="selected"'; ?> ><?=$k?></option>
			<?php
			}
			?>
		</select>

		<label for="minutes" class="filter_labels">Radius:</label>

		<select id="radius" class="filter_dropdowns" onchange = "changeRadius()">
	  	    <?php 
			for($u=0;$u<500;$u++)
			{
			?>
				<option value="<?=$u?>" <?php if($u==10) echo 'selected="selected"'; ?> ><?=$u?></option>
			<?php
			}
			?>
	    </select>

	</div>


	<div id="floating-panel">
	  <button onclick="toggleHeatmap()">Toggle Heatmap</button>
	  <button onclick="changeGradient()">Change gradient</button> 
	  <button onclick="changeOpacity()">Change opacity</button>
	</div>

	<div id="map"></div>

	<script type="text/javascript" src="js/jquery.min.js"></script>

	<script type="text/javascript">
		
		var map, heatmap;

		function initMap() 
		{			
		    var map_radius = $('#radius').val();
		    map = new google.maps.Map(document.getElementById('map'), {
			    zoom: 10,
			    radius: parseInt(map_radius),
			    center: {lat: 30.264, lng: -97.764},
			    mapTypeId: 'roadmap'
			});

			heatmap = new google.maps.visualization.HeatmapLayer({
			    data: getPoints(),
			    map: map
			});
		}


		function toggleHeatmap() {
		  heatmap.setMap(heatmap.getMap() ? null : map);
		}

		function changeGradient() {
		  var gradient = [
		    'rgba(0, 255, 255, 0)',
		    'rgba(0, 255, 255, 1)',
		    'rgba(0, 191, 255, 1)',
		    'rgba(0, 127, 255, 1)',
		    'rgba(0, 63, 255, 1)',
		    'rgba(0, 0, 255, 1)',
		    'rgba(0, 0, 223, 1)',
		    'rgba(0, 0, 191, 1)',
		    'rgba(0, 0, 159, 1)',
		    'rgba(0, 0, 127, 1)',
		    'rgba(63, 0, 91, 1)',
		    'rgba(127, 0, 63, 1)',
		    'rgba(191, 0, 31, 1)',
		    'rgba(255, 0, 0, 1)'
		  ]
		  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
		}

		function changeRadius() {
		  var map_radius = $('#radius').val();
		  heatmap.set('radius', parseInt(map_radius));
		  //heatmap.set('radius', heatmap.get('radius') ? null : radius);
		}

		function changeOpacity() {
		  heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
		}

		function getPoints()
		{
			var result;

			var base_url = ''; /*$('#base_url').html();*/

			var get_url = base_url+'getlatlang.php';

	        var weekday = $("#weekday").val();
	        var hour = $("#hour").val();
	        var minutes = $("#minutes").val();

	        var getdata = {'weekday':weekday,'hour':hour,'minutes':minutes};

	        console.log(getdata);

			$.ajax({

				"_method": "post",	   

				url: get_url,

				async: false,

				data: getdata,

				success: function (res) 
				{
					var json = $.parseJSON(res);

	                var latLng = [];

	                if(json.length > 0)
         			{
         				for(i=0;i<json.length;i++)
              			{              				
              				var jsonres = json[i];

              				var latitude = jsonres.latitude;
              				var longitude = jsonres.longitude;
              				var weight = jsonres.weight;

              				//latLng.push(new google.maps.LatLng(latitude,longitude));
              				//{location: new google.maps.LatLng(37.785, -122.441), weight: 0.5}
                            latLng.push({{location: new google.maps.LatLng(latitude,longitude)}, weight: weight});

                         /*

                          var citymap = {
                          chicago: {
                          center: {lat: 41.878, lng: -87.629},
                          population: 2714856
                          }

                           var cityCircle = new google.maps.Circle({
                            strokeWeight: 2,
                            center: citymap[city].center,
                            radius: Math.sqrt(citymap[city].population) * 100
                          }) */

              			}
         			}

					result = latLng;
				}
			});

		    return result;
		}
	</script>
	
	<script async defer 
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAI_G3YdEyYmkkDOYfEaBA8TVfPos6OX0&libraries=visualization&callback=initMap">
	</script>
 </body>
 </html>

