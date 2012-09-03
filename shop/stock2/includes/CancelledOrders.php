<?php

	include ('includes/Link.php');

	echo "<b>This is the Cancelled Orders View</b>";
	

	
	//query to get all baskets
	//$strQuery = "SELECT * FROM tbl_Orders where status = 'SENT' or status = 'CANCELLED' order by DateTme DESC";
	$strQuery = "SELECT * FROM tbl_Orders where Status = 'CANCELLED' order by DateTme DESC";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


	if (mysql_num_rows($strResult)<>0)
	{
	
		echo "<p><table><tr><td class='titleRow'>OrderNo</td><td class='titleRow'>Date</td><td class='titleRow'>emailAddress</td><td class='titleRow'>Name</td><td class='titleRow'>Status</td></tr>";
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

			switch ($line["Status"])
			{
				case "CANCELLED":
					echo "\n<tr>";
					echo "\n<td><a href='OrderView.php?strOrder=" . $line["OrderNo"] . "'>" . $line["OrderNo"] . "</a></td><td>" . $line["DateTme"] . "</td><td><a href='default.php?Action=UserDetails&UserID=" . $line["emailaddress"] . "'>". $line["emailaddress"] ."</a></td><td>" . $line["Name"] . "</td><td>" . $line["Status"] . "</td>";
					echo "\n</tr>";
					break;
				case "REFUNDED":
					echo "\n<tr>";
					echo "\n<td><a href='OrderView.php?strOrder=" . $line["OrderNo"] . "'>" . $line["OrderNo"] . "</a></td><td>" . $line["DateTme"] . "</td><td><a href='default.php?Action=UserDetails&UserID=" . $line["emailaddress"] . "'>". $line["emailaddress"] ."</a></td><td>" . $line["Name"] . "</td><td>" . $line["Status"] . "</td>";
					echo "\n</tr>";
					break;
				case "SENT":
					echo "\n<tr>";
					echo "\n<td><a href='OrderView.php?strOrder=" . $line["OrderNo"] . "'>" . $line["OrderNo"] . "</a></td><td>" . $line["DateTme"] . "</td><td><a href='default.php?Action=UserDetails&UserID=" . $line["emailaddress"] . "'>". $line["emailaddress"] ."</a></td><td>" . $line["Name"] . "</td><td>" . $line["Status"] . "</td>";
					echo "\n</tr>";
					break;
				default:
					break;
			}

		}
		
			
		echo "</table>";
	}
	else
	{
		echo "<p>No Outstanding orders to display!";
	}
?>
