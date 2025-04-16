<?PHP

session_start();

$mysqli = new mysqli("localhost", "root", "mysql", "montanarouteplanner");

// Add the one admin user to the users database
if(mysqli_fetch_array($mysqli -> query("SELECT COUNT(*) FROM `users`;"))[0] == 0) // If no users in the table
{
	$pass = hash("sha256", "admin");
	$mysqli -> query("INSERT INTO users (username, password) VALUES ('admin', '$pass');");
}


// If routeOverlays is empty, populate routeOverlays with locations and their corresponding highlighting picture filepath
$result = mysqli_fetch_array($mysqli -> query("SELECT COUNT(*) FROM `montanarouteplanner`.`routeOverlays`;"));

if($result[0] == "0")
{
	$mysqli -> query("INSERT INTO `montanarouteplanner`.`routeOverlays` (location1, location2, filepath) VALUES ('Belgrade', 'Bozeman', 'media/overlays/BelgradeBozeman.png'), ('Big Timber', 'Columbus', 'media/overlays/BigTimberColumbus.png'), ('Billings', 'Forsyth', 'media/overlays/BillingsForsyth.png'), ('Billings', 'Hardin', 'media/overlays/BillingsHardin.png'), ('Boulder', 'Helena', 'media/overlays/BoulderHelena.png'), ('Bozeman', 'Bozeman Pass', 'media/overlays/BozemanBozemanPass.png'), ('Bozeman Pass', 'Livingston', 'media/overlays/BozemanPassLivingston.png'), ('Butte', 'Boulder', 'media/overlays/ButteBoulder.png'), ('Butte', 'Divide', 'media/overlays/ButteDivide.png'), ('Butte', 'Homestake Pass', 'media/overlays/ButteHomestakePass.png'), ('Cardwell', 'Three Forks', 'media/overlays/CardwellThreeForks.png'), ('Columbus', 'Laurel', 'media/overlays/ColumbusLaurel.png'), ('Crow Agency', 'Lodge Grass', 'media/overlays/CrowAgencyLodgeGrass.png'), ('Dillon', 'Monida', 'media/overlays/DillonMonida.png'), ('Divide', 'Dillon', 'media/overlays/DivideDillon.png'), ('Drummond', 'Garrison', 'media/overlays/DrummondGarrison.png'), ('Forsyth', 'Miles City', 'media/overlays/ForsythMilesCity.png'), ('Garrison', 'Butte', 'media/overlays/GarrisonButte.png'), ('Glendive', 'Wibaux', 'media/overlays/GlendiveWibaux.png'), ('Great Falls', 'Shelby', 'media/overlays/GreatFallsShelby.png'), ('Hardin', 'Crow Agency', 'media/overlays/HardinCrowAgency.png'), ('Helena', 'Great Falls', 'media/overlays/HelenaGreatFalls.png'), ('Homestake Pass', 'Whitehall', 'media/overlays/HomestakePassWhitehall.png'), ('Laurel', 'Billings', 'media/overlays/LaurelBillings.png'), ('Livingston', 'Big Timber', 'media/overlays/LivingstonBigTimber.png'), ('Lookout Pass', 'St. Regis', 'media/overlays/LookoutPassStRegis.png'), ('Manhattan', 'Belgrade', 'media/overlays/ManhattanBelgrade.png'), ('Miles City', 'Glendive', 'media/overlays/MilesCityGlendive.png'), ('Missoula', 'Drummond', 'media/overlays/MissoulaDrummond.png'), ('St. Regis', 'Missoula', 'media/overlays/StRegisMissoula.png'), ('Three Forks', 'Manhattan', 'media/overlays/ThreeForksManhattan.png'), ('Whitehall', 'Cardwell', 'media/overlays/WhitehallCardwell.png');");
}

// If mostselectedlocations is empty, populate with city list
$result = mysqli_fetch_array($mysqli -> query("SELECT COUNT(*) FROM `montanarouteplanner`.`mostselectedlocations`;"));

if($result[0] == "0")
{
	$mysqli -> query("INSERT INTO `montanarouteplanner`.`mostselectedlocations` (location) VALUES ('Lookout Pass'), ('St. Regis'), ('Missoula'), ('Drummond'), ('Garrison'), ('Butte'), ('Homestake Pass'), ('Whitehall'), ('Cardwell'), ('Three Forks'), ('Manhattan'), ('Belgrade'), ('Bozeman'), ('Bozeman Pass'), ('Livingston'), ('Big Timber'), ('Columbus'), ('Laurel'), ('Billings'), ('Forsyth'), ('Miles City'), ('Glendive'), ('Wibaux'), ('Hardin'), ('Crow Agency'), ('Lodge Grass'), ('Divide'), ('Dillon'), ('Monida'), ('Boulder'), ('Helena'), ('Great Falls'), ('Shelby');");
}

// If cityinformation is empty, populate with lat/long data
$result = mysqli_fetch_array($mysqli -> query("SELECT COUNT(*) FROM `montanarouteplanner`.`cityinformation`;"));

if($result[0] == "0")
{
	$mysqli -> query("INSERT INTO `montanarouteplanner`.`cityinformation` (city, latitude, longitude) VALUES ('Lookout Pass', '47.4538', '-115.6945'), ('St. Regis', '47.2966', '-115.1002'), ('Missoula', '46.8705', '-113.9815'), ('Drummond', '46.6707', '-113.1464'), ('Garrison', '46.5229', '-112.8098'), ('Butte', '45.9926', '-112.5378'), ('Homestake Pass', '45.9198', '-112.41266'), ('Whitehall', '45.8779', '-112.1019'), ('Cardwell', '45.8697', '-111.9545'), ('Three Forks', '45.9015', '-111.5344'), ('Manhattan', '45.8496', '-111.3381'), ('Belgrade', '45.7683', '-111.1853'), ('Bozeman', '45.6971', '-111.0462'), ('Bozeman Pass', '45.6674', '-110.8076'), ('Livingston', '45.6446', '-110.5719'), ('Big Timber', '45.8251', '-109.9728'), ('Columbus', '45.6469', '-109.2478'), ('Laurel', '45.6631', '-108.7683'), ('Billings', '45.7678', '-108.4874'), ('Forsyth', '46.2569', '-106.6937'), ('Miles City', '46.3948', '-105.8224'), ('Glendive', '47.1151', '-104.7362'), ('Wibaux', '46.9941', '-104.1941'), ('Hardin', '45.7466', '-107.6122'), ('Crow Agency', '45.6011', '-107.4628'), ('Lodge Grass', '45.3146', '-107.3442'), ('Divide', '45.7529', '-112.7316'), ('Dillon', '45.2178', '-112.6464'), ('Monida', '44.5592', '-112.3183'), ('Boulder', '46.2467', '-112.1191'), ('Helena', '46.5915', '-111.9987'), ('Great Falls', '47.5074', '-111.3434'), ('Shelby', '48.5156', '-111.8766');");
}

echo $mysqli->error;

$mysqli -> close();

/****************************************** PROCESS DATA RETURNED FROM GENERATE.PHP *******************************************/

// Split city list on commas, put first and last items into variables to repopulate
if(isset($_POST['cities']))
{
	$cityList = stripslashes(strip_tags(htmlentities($_POST['cities'])));
	$cityList = substr($cityList, 0, strlen($cityList)-1); // Strip trailing comma
	$cityList = explode(',', $cityList);
	
	$startLocation = $cityList[0];
	$endLocation = $cityList[count($cityList)-1];
}


?>

<!----------------------------------- MAIN BODY HTML ------------------------------------------>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Montana Route Planner | Home</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<!-- HEADER -->
	<ul class="navigationMenu">
		<li class="navItem"><a style="background-color: #2964b3;" href="index.php">Home</a></li>
		
		<?php

		if(!isset($_SESSION['username']))
		{
			echo "<li class='navItem'><a href='login.html'>Log In</a></li>";
		}

		?>

		<?php

		if(isset($_SESSION['username']))
		{
			echo "<li class='navItem'><a href='logout.php'>Log Out</a></li>";
		}

		?>

		
		<li class="navItem"><a href="admin.php">Admin</a></li>
	</ul>

	<div>
		<h1 style="text-align: center;">Montana Route Planner</h2>
	</div>


	<div style="display: flex;">
		<!-- LEFT PANELS -->
		<div style="width: 60%; text-align: center; margin-right: 5px;">
			<!-- LOCATION PICKER -->
			<div>
				<form method="POST" action="generate.php">
					<label for="origin">Start Point:</label>
					<select name="originDropdown" id="origin">
						<option value="">--Please pick a start point--</option>
						<option value="Lookout Pass">Lookout Pass</option>
						<option value="St. Regis">St. Regis</option>
						<option value="Missoula">Missoula</option>
						<option value="Drummond">Drummond</option>
						<option value="Garrison">Garrison</option>
						<option value="Butte">Butte</option>
						<option value="Homestake Pass">Homestake Pass</option>
						<option value="Whitehall">Whitehall</option>
						<option value="Cardwell">Cardwell</option>
						<option value="Three Forks">Three Forks</option>
						<option value="Manhattan">Manhattan</option>
						<option value="Belgrade">Belgrade</option>
						<option value="Bozeman">Bozeman</option>
						<option value="Bozeman Pass">Bozeman Pass</option>
						<option value="Livingston">Livingston</option>
						<option value="Big Timber">Big Timber</option>
						<option value="Columbus">Columbus</option>
						<option value="Laurel">Laurel</option>
						<option value="Billings">Billings</option>
						<option value="Forsyth">Forsyth</option>
						<option value="Miles City">Miles City</option>
						<option value="Glendive">Glendive</option>
						<option value="Wibaux">Wibaux</option>
						<option value="Hardin">Hardin</option>
						<option value="Crow Agency">Crow Agency</option>
						<option value="Lodge Grass">Lodge Grass</option>
						<option value="Divide">Divide</option>
						<option value="Dillon">Dillon</option>
						<option value="Monida">Monida</option>
						<option value="Boulder">Boulder</option>
						<option value="Helena">Helena</option>
						<option value="Great Falls">Great Falls</option>
						<option value="Shelby">Shelby</option>
					</select>
					<br/>
					<br/>
					<br/>
					<label for="destination">End Point:</label>
					<select name="endDropdown" id="end">
						<option value="">--Please pick an end point--</option>
						<option value="Lookout Pass">Lookout Pass</option>
						<option value="St. Regis">St. Regis</option>
						<option value="Missoula">Missoula</option>
						<option value="Drummond">Drummond</option>
						<option value="Garrison">Garrison</option>
						<option value="Butte">Butte</option>
						<option value="Homestake Pass">Homestake Pass</option>
						<option value="Whitehall">Whitehall</option>
						<option value="Cardwell">Cardwell</option>
						<option value="Three Forks">Three Forks</option>
						<option value="Manhattan">Manhattan</option>
						<option value="Belgrade">Belgrade</option>
						<option value="Bozeman">Bozeman</option>
						<option value="Bozeman Pass">Bozeman Pass</option>
						<option value="Livingston">Livingston</option>
						<option value="Big Timber">Big Timber</option>
						<option value="Columbus">Columbus</option>
						<option value="Laurel">Laurel</option>
						<option value="Billings">Billings</option>
						<option value="Forsyth">Forsyth</option>
						<option value="Miles City">Miles City</option>
						<option value="Glendive">Glendive</option>
						<option value="Wibaux">Wibaux</option>
						<option value="Hardin">Hardin</option>
						<option value="Crow Agency">Crow Agency</option>
						<option value="Lodge Grass">Lodge Grass</option>
						<option value="Divide">Divide</option>
						<option value="Dillon">Dillon</option>
						<option value="Monida">Monida</option>
						<option value="Boulder">Boulder</option>
						<option value="Helena">Helena</option>
						<option value="Great Falls">Great Falls</option>
						<option value="Shelby">Shelby</option>
					</select>
					<br/>
					<br/>
					<br/>
					<input style="border: 2px solid black; height: 40px; width: 125px; background-color: #77A1A6; cursor: pointer;" type="submit" value="Generate">
				</form>
			</div>

			<br/>
			<br/>
			<br/>

			<!-- WEATHER CONDITIONS -->

			<?php if(isset($_POST['cities']))
			{

				echo "<h1 style='text-align: center;'>Weather Conditions</h1>";

				echo "<div style='padding: 5px; overflow-y: auto; max-height: 400px; background-color: #dddddd; border: 2px solid black; border-radius: 0px;'>";
				
				$mysqli = new mysqli("localhost", "root", "mysql", "montanarouteplanner");

				// Retrieve weather information for each city passed through
				for($i = 0; $i < count($cityList); $i++)
				{
					usleep(200); // Sleep briefy between each request. If you don't, the NWS API gets overloaded and sometimes skips cities with an internal server error
									// This only seems to happen when getting a fresh forecast - if the forecast for the city requested is the same forecast as the last
										// time the program was run, it seems to be cached somwhere and not mess up. However, the next day, even using the same cities,
										// it'll miss some cities if the program isn't given some time to rest between each request.

					echo "<h3 class='forecastCityName' id='cityName'>$cityList[$i]</h3>";

					echo "<div style='display: flex;'>";

					echo "<div style='width: 20%; margin: 10px;'>";
					echo "<h5 class='forecastPeriod' id='forecastPeriodToday{$i}'></h5>";
					echo "<img id='iconToday{$i}' src=''>";
					echo "<p class='forecastText' id='forecastTextToday{$i}'></p>";
					echo "</div>";

					echo "<div style='width: 20%; margin: 10px;'>";
					echo "<h5 class='forecastPeriod' id='forecastPeriodTonight{$i}'></h5>";
					echo "<img id='iconTonight{$i}' src=''>";
					echo "<p class='forecastText' id='forecastTextTonight{$i}'></p>";
					echo "</div>";

					echo "<div style='width: 20%; margin: 10px;'>";
					echo "<h5 class='forecastPeriod' id='forecastPeriodTomorrow{$i}'></h5>";
					echo "<img id='iconTomorrow{$i}' src=''>";
					echo "<p class='forecastText' id='forecastTextTomorrow{$i}'></p>";
					echo "</div>";

					echo "<div style='width: 20%; margin: 10px;'>";
					echo "<h5 class='forecastPeriod' id='forecastPeriodTomorrowNight{$i}'></h5>";
					echo "<img id='iconTomorrowNight{$i}' src=''>";
					echo "<p class='forecastText' id='forecastTextTomorrowNight{$i}'></p>";
					echo "</div>";

					echo "</div>";


					echo "</br></br>";

					$result = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`cityinformation` WHERE city='$cityList[$i]';");
					$result = $result -> fetch_assoc();
					$lat = $result['latitude'];
					$long = $result['longitude'];

					// Using the NWS API, first make a call to api.weather.gov/points/lat,long
					// In this response, retrieve the forecast office and gridpoints
					// From these, construct another API call to api.weather.gov/gridpoints/office/gridX,gridY/forecast
					// This is the actual forecast API call
					echo "<script type='text/javascript'>
						fetch('https://api.weather.gov/points/$lat,$long').then(response => {
						if(!response.ok)
						{
							throw new Error('Unknown error fetching weather data.');
						}
						return response.json();
					})
					.then(data => {
						const forecastOffice = data.properties.gridId;
						const gridx = data.properties.gridX;
						const gridy = data.properties.gridY;
						let forecasturl = 'https://api.weather.gov/gridpoints/' + forecastOffice + '/' + gridx + ',' + gridy + '/forecast';

					fetch(forecasturl).then(response => {
					if(!response.ok)
					{
						throw new Error('Unknonwn error fetching weather data.');
					}
					return response.json();
				})
				.then(data => {
					let name = data.properties.periods[0].name;
					let forecast = data.properties.periods[0].detailedForecast;
					let icon = data.properties.periods[0].icon;

					document.getElementById('forecastPeriodToday{$i}').innerHTML = name;
					document.getElementById('forecastTextToday{$i}').innerHTML = forecast;
					document.getElementById('iconToday{$i}').src = icon;



					let name1 = data.properties.periods[1].name;
					let forecast1 = data.properties.periods[1].detailedForecast;
					let icon1 = data.properties.periods[1].icon;

					document.getElementById('forecastPeriodTonight{$i}').innerHTML = name1;
					document.getElementById('forecastTextTonight{$i}').innerHTML = forecast1;
					document.getElementById('iconTonight{$i}').src = icon1;



					let name2 = data.properties.periods[2].name;
					let forecast2 = data.properties.periods[2].detailedForecast;
					let icon2 = data.properties.periods[2].icon;

					document.getElementById('forecastPeriodTomorrow{$i}').innerHTML = name2;
					document.getElementById('forecastTextTomorrow{$i}').innerHTML = forecast2;
					document.getElementById('iconTomorrow{$i}').src = icon2;




					let name3 = data.properties.periods[3].name;
					let forecast3 = data.properties.periods[3].detailedForecast;
					let icon3 = data.properties.periods[3].icon;

					document.getElementById('forecastPeriodTomorrowNight{$i}').innerHTML = name3;
					document.getElementById('forecastTextTomorrowNight{$i}').innerHTML = forecast3;
					document.getElementById('iconTomorrowNight{$i}').src = icon3;
				})
				.catch(error => console.error('Error:', error));
			})
			.catch(error => console.error('Error:', error));

			
			</script>";
					
				}
				echo "</div>";
			}
			else
			{
				echo "<div style='overflow-y: auto; max-height: 300px;'></div>";
			}

		?>
		
		</div>


		<!-- MAP/RIGHT PANEL -->
		<div class="map" style="width: 40%; height: 100%; display: flex;">
			<div style="position: relative; top: 0; left: 0;">
				<img class="map" src="media/baseMap.png" style="position: relative; top: 0; left: 0; width: 100%;">

				<?php

				if(isset($_POST['cities']))
				{
					$mysqli = new mysqli("localhost", "root", "mysql");

					// For each potential city pair in the routeOverlays table, if both cities are in $cityList, echo a new <img> with the
					// transparent image that will highlight that section on the map
					$result = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`routeOverlays`;");
	
					while($row = $result->fetch_assoc())
					{
						if(in_array($row['location1'], 	$cityList) && in_array($row['location2'], $cityList))
						{
						echo "<img class='map' src='{$row['filepath']}' style='position: absolute; top: 0; left: 0; width: 100%;'>";
						}
					}
	
					$mysqli -> close();
				}

				?>
			</div>
		</div>
	</div>

	<?php

	// If the start and end variables passed from generate.php are populated, use JS to set the dropdowns accordingly
	if(isset($startLocation) && isset($endLocation))
	{
		echo "<script>
			document.getElementById('origin').value='$startLocation';
			document.getElementById('end').value='$endLocation';
		</script>";
	}

	?>

</body>
</html>