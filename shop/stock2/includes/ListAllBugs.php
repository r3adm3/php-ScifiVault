<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the List All Bugs View</b>";
	
	//query to get all baskets
	$strQuery = "SELECT IssueNo,DateStamp,Issue,Priority FROM tblBugs order by Priority";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table width='700'><tr><td class='titleRow'>Issue No</td><td class='titleRow'>DateStamp</td><td class='titleRow'>Issue</td><td class='titleRow'>Priority</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		echo "<tr>";

		echo "\n<td>" . $line["IssueNo"] . "</td><td>" . $line["DateStamp"] . "</td><td>" . $line["Issue"] . "</td>";
		
		echo "<td>"  .$line["Priority"] . "</td>";
		
		echo "\n</tr>";

		}
		
			
		echo "</table><br>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
