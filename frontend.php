<?php

	define("INCIDENTS_FILE", "incidents");

	require_once("VmzIncident.php");

	function read_incidents($fname)
	{
		return file_get_contents($fname);
	}

	function create_markers()
	{
		ini_set('memory_limit','500M');
		$incidents = unserialize(read_incidents(INCIDENTS_FILE));
		if (isset($_GET["from_date"]) and !empty($_GET["from_date"]))
		{
			$from = VmzIncident::conv_time($_GET["from_date"]);
		}
		if (isset($_GET["to_date"]) and !empty($_GET["to_date"]))
		{
			$to = VmzIncident::conv_time($_GET["to_date"]);
		}
		$counter = 0;
		if (isset($_GET["heatmap"]))
		{
			echo "heatmapData = [";
		}
		foreach ($incidents as $incident)
		{
			if (!empty($from) and $incident->valid_to < $from)
			{
				continue;
			}
			if (!empty($to) and $incident->valid_from > $to)
			{
				continue;
			}
			if (isset($_GET["heatmap"]))
			{
				echo "new google.maps.LatLng($incident->latitude, $incident->longitude),";
			}
			else
			{
				echo "marker$counter = new google.maps.Marker({position: {lat: $incident->latitude, lng: $incident->longitude}, map: map});\n";
				echo str_replace('"', '\"', "marker$counter.addListener('click', function() {infoWindow.setContent('" . $incident->street_names[0] . "<br>$incident->section<br><br>$incident->description<br><br>Gültig von " . date("c", $incident->valid_from) . " bis " . date("c", $incident->valid_to) . "');infoWindow.open(map, marker$counter);});\n");
			}
			$counter++;
		}
		if (isset($_GET["heatmap"]))
		{
			echo "];";
			echo "heatmap = new google.maps.visualization.HeatmapLayer({data: heatmapData});";
			echo "heatmap.setMap(map);";
		}
	}

?>
