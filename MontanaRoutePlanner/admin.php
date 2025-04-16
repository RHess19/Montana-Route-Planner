<?php

session_start();

if(!isset($_SESSION['username']))
{
	echo "<script>alert('Please log in.'); window.location.href = 'login.html';</script>";
}

if(isset($_SESSION['username']))
{
	$user = $_SESSION['username'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Montana Route Planner | Admin</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<ul class="navigationMenu">
		<li class="navItem"><a href="index.php">Home</a></li>
		<li class="navItem"><a href="logout.php">Log Out</a></li>
		<li class="navItem"><a style="background-color: #2964b3;" href="admin.php">Admin</a></li>
	</ul>

	<div>
		<h1 style="text-align: center;">Montana Route Planner - Admin</h2>
	</div>

	<div style="display: flex;">
		<!-- LEFT ADMIN PANEL -->
		<div style="width: 50%; position: relative; border-right: 1px solid black;">
			<h1 style="text-align: center;">Most Selected Locations</h1>

			<div style="width: 50%; float: left;">
				<h3 style="text-align: center;">Location</h3>

				<!-- Send DB query for the contents of mostselectedlocations.
					Display all of the locations under the "Location" heading. -->
				<?php

				$mysqli = new mysqli("localhost", "root", "mysql");

				$results = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`mostselectedlocations`;");

				if($results->num_rows > 0)
				{
					while($row = $results -> fetch_assoc())
					{
					echo "<p style='text-align: center;'> {$row['location']}</p>";
    				}
				}

    			$mysqli -> close();

				?>


			</div>
			<div style="width: 50%; float: right;">
				<h3 style="text-align: center;">Frequency</h3>

				<!-- Send DB query for the contents of mostselectedlocations.
					Display all of the frequencies under the "Frequency" heading. -->
				<?php

				$mysqli = new mysqli("localhost", "root", "mysql");

				$results = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`mostselectedlocations`;");

				if($results->num_rows > 0)
				{
					while($row = $results -> fetch_assoc())
					{
						echo "<p style='text-align: center;'> {$row['frequency']}</p>";
    				}
				}

    			$mysqli -> close();

				?>
			</div>
		</div>

		<!-- MIDDLE ADMIN PANEL -->
		<div style="width: 50%; position: relative; border-right: 1px solid black;">
			
			<h1 style="text-align: center;">Most Selected Routes</h1>

			<div style="width: 50%; float: left;">
				<h3 style="text-align: center;">Route</h3>

				<!-- Send DB query for the contents of mostselectedroutes.
					Display all of the locations under the "Location" heading. -->
				<?php

				$mysqli = new mysqli("localhost", "root", "mysql");

				$results = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`mostselectedroutes`;");

				if($results->num_rows > 0)
				{
					while($row = $results -> fetch_assoc())
					{
						echo "<p style='text-align: center;'> {$row['location1']} -> {$row['location2']}</p>";
    				}
				}
				else
				{
					echo "<p style='text-align: center;'> Error retrieving data from database, or no data is available yet. </p>";
				}

    			$mysqli -> close();

				?>

			</div>
			<div style="width: 50%; float: right;">
				<h3 style="text-align: center;">Frequency</h3>

				<!-- Send DB query for the contents of mostselectedroutes.
					Display all of the frequencies under the "Frequency" heading. -->
				<?php

				$mysqli = new mysqli("localhost", "root", "mysql");

				$results = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`mostselectedroutes`;");

				if($results->num_rows > 0)
				{
					while($row = $results -> fetch_assoc())
					{
						echo "<p style='text-align: center;'> {$row['frequency']}</p>";
    				}
				}
				else
				{
					echo "<p style='text-align: center;'> Error retrieving data from database, or no data is available yet. </p>";
				}

    			$mysqli -> close();

				?>

			</div>
		</div>

		<!----------- RIGHT ADMIN PANEL -------------->
		<div style="width: 40%; position: relative;">
			<h1 style="text-align: center;">Access Logs</h1>
			<p style="text-align: center;">Times are in Mountain Time</p>
			<div style="overflow-y: auto; max-height: 500px; border: 1px solid black; margin: 5px; background-color: #dddddd;">

				<!-- Send DB query for the contents of the logs.
					Display all of the logs under the "Access logs" heading. -->
				<?php

					$mysqli = new mysqli("localhost", "root", "mysql");

					$results = $mysqli -> query("SELECT * FROM `montanarouteplanner`.`logs`;");

					if($results->num_rows > 0)
					{
						while($row = $results -> fetch_assoc())
						{
							echo "<p style='text-align: center;'> {$row['datetime']} {$row['ip']} {$row['route']}</p>";
						}
					}
					else
					{
						echo "<p style='text-align: center;'> Error retrieving logs from database, or no logs are available yet. </p>";
					}

				?>
			</div>
		</div>
	</div>	

</body>
</html>