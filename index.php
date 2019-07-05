<!DOCTYPE HTML>
<!--
Author(s)		: Lukas Mirow
Date of creation	: 6/13/2019
-->
<html style=width:100%;height:100%;margin:0px>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>PHP - Pretty Happy Ponies</title>
		<link rel=stylesheet href=global.css>
		<link rel="shortcut icon" href=favicon.ico>
		<?php

			if (!isset($_GET["from_date"]))
			{
				$_GET["from_date"] = date('Y-m-j');
			}
			if (!isset($_GET["to_date"]))
			{
				$_GET["to_date"] = date('Y-m-j');
			}
			require_once("frontend.php");
		?>
	</head>
	<body style=width:100%;height:100%;margin:0px;font-family:Arial;>
		<form style=text-align:center;height:100%>
			<table class=frame style=height:100%>
				<tr class=frame id=header>
					<td class=frame id=header>
						<table style=width:100%><tr>
							<td>
								<img id=logo src=logo.jpg>
							</td>
							<td style=padding:20px;width:auto>
								<b>Pretty Happy Ponies Traffic Information Interface</b>
							</td>
							<td style=padding:20px;width:60px>
								Heatmap: <input type=checkbox name=heatmap value=yes onclick="form.submit()" <?php if (isset($_GET["heatmap"])) {echo "checked";} ?>>
							</td>
						</tr></table>
					</td>
				</tr>
				<tr class=frame id=main>
					<td class=frame id=main>
						<table class=content>
							<tr class=content id=map>
								<td class=content id=map>
									<div id="gmap"></div>
									<script>
										// Initialize and add the map
										function initMap()
										{
											// The location of Berlin
											var berlin = {lat: 52.520015, lng: 13.404805};
											// The map, centered at Berlin
											var map = new google.maps.Map( document.getElementById('gmap'), {zoom: 10, center: berlin});
											var infoWindow = new google.maps.InfoWindow;
											// The marker, positioned at Berlin
											//var marker = new google.maps.Marker({position: berlin, map: map});
											<?php create_markers(); ?>
										}

									</script>
									<!--Load the API from the specified URL
									* The async attribute allows the browser to render the page while the API loads
									* The key parameter will contain your own API key (which is not needed for this tutorial)
									* The callback parameter executes the initMap() function
									-->
									<script async defer src="https://maps.googleapis.com/maps/api/js?key=your_google_api_key_here&libraries=visualization&callback=initMap"></script>
								</td>
							</tr>
							<tr class=content id=filter>
								<td class=content id=filter>
									<p>
										Von: <input name=from_date type=date <?php if (!empty($_GET["from_date"])) {echo  "value=" . $_GET["from_date"];} ?>><br>
										<br>
										Bis: <input name=to_date type=date <?php if (!empty($_GET["to_date"])) {echo  "value=" . $_GET["to_date"];} ?>><br>
										<br>
										<input type=submit value=Filtern!>
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
