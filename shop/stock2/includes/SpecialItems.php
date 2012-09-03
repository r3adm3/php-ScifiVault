<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	echo "<b>This is the Special Items View</b>";
	
	$strUserID = funcSanitize($_POST["UserID"]);
	
	//query to get all baskets
	$strQuery = "SELECT stockID, Name, NoOfItems, RRP FROM tblItem where DisplayOnFrontPage";
	
	//execute query
	$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

	echo "<p><b>Front Page Items:</b>";
	if (mysql_num_rows($strResult)<>0)
	{
		echo "<form action='submitSpecialItemsFP.php' method='post'>";
	
		echo "<p><table><tr><td class='titleRow'>stockID</td><td class='titleRow'>Name</td><td class='titleRow'>NoOfItems</td><td class='titleRow'>RRP</td></tr>";
		
		$i=0;
		
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

		
			$i=$i+1;
		
			echo "\n<tr>";

			echo "\n<td><input type='text' name='SPitem" . $i . "' size='20' value='" . $line["stockID"] . "'></td><td><a href='default.php?Action=ViewItem&stockID=" . $line["stockID"] . "'>" . $line["Name"] . "</a></td><td>" . $line["NoOfItems"] . "</td><td>" . $line["RRP"] . "</td>";

			echo "\n</tr>";

		}
		
			
		echo "</table>";
		echo "<tr><td><input type='submit' value='Update' name='Update'></td><td></td></tr>";
		echo "</form>";


	}
	else
	{
		echo "<p>No Items to display!";
	}

	
	
	
	//query to get all baskets
	$strSubCatQuery = "SELECT Subject, Version, Category, SubjectTag, CategoryTag,VersionTag, count(*) as Num FROM `tblItem` where DisplayOnSubCatPage = '1' group by Subject, Version, Category";
	
	//execute query
	$strSubCatResult = mysql_query($strSubCatQuery) or die ("Query Failed :" . mysql_error());	
	
	if (mysql_num_rows($strSubCatResult)<>0)
	{
	
		while ($line2 = mysql_fetch_array($strSubCatResult, MYSQL_ASSOC))
		{
		
			echo "<p><b>Category: " . $line2["Subject"] . " / " . $line2["Version"] . " / " . $line2["Category"] . "</b>";
			
			$strQuery2 = "SELECT * FROM tblItem where DisplayOnSubCatPage = '1' and Subject = '" . $line2["Subject"] . "' and Version = '" . $line2["Version"] . "' and Category ='" . $line2["Category"] . "'";
			
			$strResult2 = mysql_query($strQuery2) or die ("Query Failed :" . mysql_error());

			echo "<p><form action='submitSpecialItems.php' method='post'><table><tr><td class='titleRow'>stockID</td><td class='titleRow'>Name</td><td class='titleRow'>NoOfItems</td><td class='titleRow'>RRP</td></tr>";

			echo "<input type='hidden' name='SubjectTag' value='" . $line2["SubjectTag"] . "#" . $line2["CategoryTag"]. "#" . $line2["VersionTag"] . "'>";
			
			$j = 0;
			
			while ($line3 = mysql_fetch_array($strResult2, MYSQL_ASSOC))
			{
				
				$j=$j+1;
				
				echo "\n<tr>";
	
				echo "\n<td><input type='text' name='item" . $j. "' value='" . $line3["stockID"] . "'></a></td><td><a href='default.php?Action=ViewItem&stockID=" . $line3["stockID"] . "'>" . $line3["Name"] . "</a></td><td>" . $line3["NoOfItems"] . "</td><td>" . $line3["RRP"] . "</td>";

				echo "\n</tr>";

			}
		
			echo "<tr><td><input type='submit' value='Update' name='Update'></td><td></td></tr>";
			
			echo "</table>";			
			
			echo "</form>";
			
		}
		
		echo "<p><b>Special Items to be cleared from: </b>";
		
		echo "<p><form action='submitSpecialItems.php' method='post'>";
		
		$strQuery3 = "SELECT DISTINCT SubjectTag, CategoryTag, VersionTag FROM tblItem order by SubjectTag, VersionTag";
		
		$strResult3 = mysql_query($strQuery3) or die ("Query Failed :" . mysql_error());
		
		echo "Category: ";
		
		echo "<select name='SubjectTag'>";
		
		while ($line4 = mysql_fetch_array($strResult3, MYSQL_ASSOC))
		{
		
			echo "<OPTION VALUE='" . $line4["SubjectTag"] . "#" . $line4["CategoryTag"]. "#" . $line4["VersionTag"] . "'>" . $line4["SubjectTag"] . " / " . $line4["VersionTag"] . " / " . $line4["CategoryTag"] . "</OPTION>";	
		
		}
		
		echo "</select>";
		
	
		echo "&nbsp; <input type='submit' value='Remove' name='b2'></form>";
		
		echo "<p><b>Display Items on SubCategory pages</b>";
		
		echo "<table><form action='submitSpecialItems.php' method='post'>";
		
		echo "<tr><td>Item 1:</td><td><input type='text' name='item1' size='20'></td></tr>";
		echo "<tr><td>Item 2:</td><td><input type='text' name='item2' size='20'></td></tr>";
		echo "<tr><td>Item 3:</td><td><input type='text' name='item3' size='20'></td></tr>";
		echo "<tr><td></td><td><input type='submit' value='submit' name='b1'></td></tr>";
		
		echo "</table></form>";
		
		

	}	
	
	
?>
