<?php
// Import POST variables
$startLocation = stripslashes(strip_tags(($_POST['originDropdown'])));
$endLocation = stripslashes(strip_tags(($_POST['endDropdown'])));

/******************************************* PATHFINDING ALGORITHM ******************************************/

function pathfind($map, $start, $end)
{
  // Combine map into a single structure for bi-directional search (west to east, east to west, etc.)
  $connections = [];
  foreach ($map as $from => $tos) {
    $connections[$from] = $tos;
    foreach ($tos as $to) {
      $connections[$to][] = $from;
    }
  }

  // Initialize empty stacks and visited location arrays
  $stack = [];
  $reverseStack = [];
  $visited = [];
  $reverseVisited = [];

  // DFS search. Our map isn't complex enough that DFS vs. BFS matters, so I arbitrarily chose DFS
  function dfs($stack, $visited, $current, $target, $connections, $reverseStack)
  {
    if (isset($visited[$current])) {
      return null; // Already explored from the other direction
    }

    $visited[$current] = true;
    $stack[] = $current;

    if ($current === $target) {
      // Path found, combine stacks and reverse the starting stack.
      return array_merge(array_reverse($stack), array_slice($reverseStack, 1));
    }

    foreach ($connections[$current] as $neighbor) {
      $result = dfs($stack, $visited, $neighbor, $target, $connections, $reverseStack);
      if ($result) {
        return $result;
      }
    }

    array_pop($stack);
    return null;
  }

  // Start DFS from both directions
  $startResult = dfs($stack, $visited, $start, $end, $connections, $reverseStack);
  $endResult = dfs($reverseStack, $reverseVisited, $end, $start, $connections, $reverseStack);

  // Return the first found path. If a result was found, return it. Otherwise, return $endResult
  return $startResult ? $startResult : $endResult;
}

// Array to hold a key for a location on the map, and a list of values that are the map locations reachable from the corresponding key
$map = [
	"Lookout Pass" => ["St. Regis"],
	"St. Regis" => ["Missoula", "Lookout Pass"],
	"Missoula" => ["Drummond", "St. Regis"],
	"Drummond" => ["Garrison", "Missoula"],
	"Garrison" => ["Butte", "Drummond"],
	"Butte" => ["Garrison", "Homestake Pass", "Boulder", "Divide"],
	"Boulder" => ["Butte", "Helena"],
	"Helena" => ["Boulder", "Great Falls"],
	"Great Falls" => ["Helena", "Shelby"],
	"Shelby" => ["Great Falls"],
	"Divide" => ["Butte", "Dillon"],
	"Dillon" => ["Divide", "Monida"],
	"Monida" => ["Dillon"],
	"Homestake Pass" => ["Butte", "Whitehall"],
	"Whitehall" => ["Homestake Pass", "Cardwell"],
	"Cardwell" => ["Whitehall", "Three Forks"],
	"Three Forks" => ["Cardwell", "Manhattan"],
	"Manhattan" => ["Three Forks", "Belgrade"],
	"Belgrade" => ["Manhattan", "Bozeman"],
	"Bozeman" => ["Belgrade", "Bozeman Pass"],
	"Livingston" => ["Bozeman Pass", "Big Timber"],
	"Bozeman Pass" => ["Livingston", "Bozeman"],
	"Big Timber" => ["Livingston", "Columbus"],
	"Columbus" => ["Big Timber", "Laurel"],
	"Laurel" => ["Columbus", "Billings"],
	"Billings" => ["Laurel", "Forsyth", "Hardin"],
	"Forsyth" => ["Billings", "Miles City"],
	"Miles City" => ["Forsyth", "Glendive"],
	"Glendive" => ["Miles City", "Wibaux"],
	"Wibaux" => ["Glendive"],
	"Hardin" => ["Billings", "Crow Agency"],
	"Crow Agency" => ["Hardin", "Lodge Grass"],
	"Lodge Grass" => ["Crow Agency"],
];


$path = pathfind($map, $startLocation, $endLocation);
$path = array_reverse($path);

/************************************* UPDATE DATABASE INFORMATION AND STATISTICS *******************************************/

$mysqli = new mysqli("localhost", "root", "mysql", "montanarouteplanner");

// If results are returned, an entry exists in mostselectedroutes. Increment that entry.
// If no results are returned, no entry exist. Create that entry with a frequency of 1.
if(($startLocation == NULL && $endLocation != NULL) OR ($endLocation == NULL && $startLocation != NULL))
{
	echo "<script>alert('Please select both a start and end location.'); window.location.href = 'index.php';</script>";
}

if(mysqli_fetch_array($mysqli -> query("SELECT COUNT(*) FROM `mostselectedroutes` WHERE `location1` = '$startLocation' AND `location2` = '$endLocation';"))[0] != 0)
{
	if($startLocation != NULL && $endLocation != NULL)
	{
		// Entry exists
		// Get the current value of 'frequency' for the route
		$result = mysqli_fetch_array($mysqli -> query("SELECT `frequency` FROM `mostselectedroutes` WHERE `location1` = '$startLocation' AND `location2` = '$endLocation';"));
		// Increment the frequency
		$currentFrequency = $result[0];
		$newFrequency = $currentFrequency + 1;

		// Update entry with new frequency
		$mysqli -> query("UPDATE `mostselectedroutes` SET `frequency`='$newFrequency' WHERE `location1` = '$startLocation' AND `location2` = '$endLocation';");

		// Update mostselectedlocations
		$result = mysqli_fetch_array($mysqli -> query("SELECT `frequency` FROM `mostselectedlocations` WHERE `location` = '$startLocation';"));
		$currentFrequency = $result[0];
		$newFrequency = $currentFrequency + 1;

		$mysqli -> query("UPDATE `mostselectedlocations` SET `frequency`='$newFrequency' WHERE `location` = '$startLocation';");

		$result = mysqli_fetch_array($mysqli -> query("SELECT `frequency` FROM `mostselectedlocations` WHERE `location` = '$endLocation';"));
		$currentFrequency = $result[0];
		$newFrequency = $currentFrequency + 1;

		$mysqli -> query("UPDATE `mostselectedlocations` SET `frequency`='$newFrequency' WHERE `location` = '$endLocation';");

		// Update server logs table
		$userIP = $_SERVER['REMOTE_ADDR'];
		$route = $startLocation . "->" . $endLocation;
		$mysqli -> query("INSERT INTO logs (ip, route) VALUES ('$userIP', '$route');");
	}
	
}
// Do the same operation as above for mostselectedlocations
else
{
	if($startLocation == $endLocation)
	{
		echo "<script>alert('Start and end location cannot be the same.'); window.location.href = 'index.php';</script>";
	}
	else if(($startLocation != NULL && $endLocation != NULL))
	{
		// No entry exists
		// Create new entry
		$mysqli -> query("INSERT INTO mostselectedroutes (location1, location2, frequency) VALUES ('$startLocation', '$endLocation', '1');");

		// Update mostselectedlocations
		$result = mysqli_fetch_array($mysqli -> query("SELECT `frequency` FROM `mostselectedlocations` WHERE `location` = '$startLocation';"));
		$currentFrequency = $result[0];
		$newFrequency = $currentFrequency + 1;

		$mysqli -> query("UPDATE `mostselectedlocations` SET `frequency`='$newFrequency' WHERE `location` = '$startLocation';");

		//echo $startLocation;
		//echo $endLocation;

		$result = mysqli_fetch_array($mysqli -> query("SELECT `frequency` FROM `mostselectedlocations` WHERE `location` = '$endLocation';"));
		$currentFrequency = $result[0];
		$newFrequency = $currentFrequency + 1;

		$mysqli -> query("UPDATE `mostselectedlocations` SET `frequency`='$newFrequency' WHERE `location` = '$endLocation';");

		// Update server logs table
		$userIP = $_SERVER['REMOTE_ADDR'];
		$route = $startLocation . "->" . $endLocation;
		$mysqli -> query("INSERT INTO logs (ip, route) VALUES ('$userIP', '$route');");
	}
	
}


// Compile the city list into a single string that's easy to split on a delimeter once back on index.php
$cityList = "";

foreach ($path as $city) {
	$cityList .= $city . ",";
}

// Create a hidden field to pass back the city list through POST to index.php
echo "<form action='index.php' name='returnForm' method='POST'>
<input type='hidden' name='cities' value='$cityList'>
</form>

<script>
	document.returnForm.submit();
</script>";

$mysqli -> close();
?>