<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the News View</b> (RSS feed link: <a href='http://shop.scifivault.com/stock2/newsRSS.php'>here</a>)";
	
	$strRSSQuery = "SELECT * FROM tbl_News order by colDate DESC LIMIT 10";
	
	$strRSSResult = mysql_query($strRSSQuery) or die ("Query Failed :" . mysql_error());
	
	while ($line2 = mysql_fetch_array($strRSSResult, MYSQL_ASSOC))
	{

		echo "<a name='" . $line2["colUniqueID"] . "'></a>";
		echo "<p><br><table width='450'><tr><td class='titleRow2'>&nbsp;<a href='" . $line2 ["colLink"] . "'>" . $line2["colTitle"] . " </a></td><td class='titleRow2' width='150'>" . date ("D jS, H:i", strtotime ($line2["colDate"])) . "</td></tr>";
		echo "<tr><th colspan='2' align='left'> " . $line2["colDescription"] . " </th></tr>";
		echo "</table>";

	}
	
	
	
	
?>
