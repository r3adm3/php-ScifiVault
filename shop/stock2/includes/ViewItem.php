<?php

			include ('includes/SharedFunctionsStrict.php');
			include ('includes/Link.php');
			
			
			$strStockID = funcSanitize($_GET["stockID"]);

			echo "<b>This is the View Item View (" . $strStockID . ")</b><p>";
			
			//run query to see if result is returned

			//$strStockID = funcSanitize ($_POST["stockID"]);
			$strQuery = "SELECT * FROM tblItem where stockID = '" . $strStockID . "'";

			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

			$conNumberofRows = mysql_num_rows($strResult);
			//$row = mysql_fetch_array ($strResult);

			//if there are no rows in the table with the same ID, error then redirect within 5 seconds to add page
	if ($conNumberofRows != 1 )
	{
		echo "<b>ERROR! StockID ". $strStockID . "Doesn't exist in the database or there is more than one result<br>\n";
		echo "Redirecting you to the 'update' section of website</b><br>\n";

		echo "<meta http-equiv='REFRESH' content='5;default.php?Action=AddItem'>";
	}	
	else
	{

	}

	while ($row = mysql_fetch_array ($strResult))
			{

				$strSubject = $row["Subject"];
				$strCategory = $row["Category"];
				$strStockID = $row["stockID"];
				$strDescription = $row["Description"];
				$strSmallPicture = $row["smallPicture"];
				$strLargePicture = $row["bigPicture"];
				$strShortDescription = $row["ShortDescription"];
				$strName = $row["Name"];
				$strCost = $row["Cost"];
				$strRRP = $row ["RRP"];
				$strSaleRRP = $row["SaleRRP"];
				$strWeight = $row["Weight"];
				$strBarcode = $row["Barcode"];
				$strFeatures = $row ["Features"];
				$strVersion = $row ["Version"];
				$strSize = $row ["Size"];
				$strPercentDiscount =  $row["PercentDiscount"];
				$strWholeSalePrice = $row["WholesalePrice"];
	  			$strSupplier = $row["Supplier"];
				$strAvailability = $row["Availability"];
				$strNoOfItems = $row["NoOfItems"];
				$strSubjectTag = $row["SubjectTag"];
				$strCategoryTag = $row["CategoryTag"];
				$strVersionTag = $row["VersionTag"];

				if ($row["DisplayonFrontPage"] == "1")
				{$strFrontPage = 'checked';}else{$strFrontPage = '';}

				
				
				if ($row["DisplayonSubCatPage"] == "1")
				{$strSubCatPage = 'checked';}else{$strSubCatPage = '';}

				
			}


?>
      
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign='top'>
	  <?php
		echo "<table width='350'>

			<tr><td bgcolor='#FFFFCC'>Subject:</td><td>" . $strSubject . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Version:	</td><td>" . $strVersion . "</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Category:	</td><td>" . $strCategory . "</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>stockID:</td><td>" . $strStockID . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Barcode:	</td><td>" . $strBarcode . "</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Name:	</td><td>" . $strName . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>shortDescription:</td><td>" . $strShortDescription . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Features:	</td><td>" . $strFeatures . "</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Size:		</td><td>" . $strSize . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Weight:	</td><td>" . $strWeight . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Cost:	</td><td>" . $strCost . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>RRP:	</td><td>" . $strRRP . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>SaleRRP:</td><td>" . $strSaleRRP . "</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>% Discount:	</td><td>" . $strPercentDiscount. "</td></tr>
			<tr><td bgcolor='#FFFFCC'>WholeSale Price:</td><td>" . $strWholeSalePrice . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Supplier:	</td><td>" . $strSupplier . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Availaibility:	  </td><td>" . $strAvailability . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>CategoryTag:	  </td><td>".$strCategoryTag."</td></tr>
			<tr><td bgcolor='#FFFFCC'>SubjectTag:	  </td><td>".$strSubjectTag."</td></tr>
			<tr><td bgcolor='#FFFFCC'>VersionTag:	  </td><td>".$strVersionTag."</td></tr>
			
			</table>
			";
?>
        <p> <br>

    </td>
    <td width="375" valign="top">
      <?php


echo "	<table>
<tr>
			<td bgcolor='#FFFFCC'>Stock Count: </td>
			<td>" . $strNoOfItems . "</td>
		</tr>
		<tr>
			<td bgcolor='#FFFFCC'>Small Picture:  </td>
			<td><img src='/" . $strSmallPicture . "'></td>

		</tr>

		<tr>
			<td bgcolor='#FFFFCC'>Large Picture: </td>
			<td><img src='/" . $strLargePicture . "'></td>
		</tr>
		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>Description:  </td>
			<td>" . $strDescription . "</td>

		</tr>

		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>On the Front Page?:  </td>
			<td>";
			
			if ($strFrontPage == "checked") 
			{
				echo "Yes";
			}
			else	
			{
				echo "No";
			}			
			
		echo "</td>

		</tr>

		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>Featured on subCategory:  </td>
			<td>";
			if ($strSubCatPage == "checked") {echo "Yes";}else{echo "No";} 
		
		echo"</td>

		</tr>

		
		<tr><td> <form method='POST' action='default.php?Action=AmendItem&stockID=". $strStockID . "'><input class='listitems' type='submit' value='Amend'></form></td></tr>



	</table>
";
?>
      <br>


</td>
  </tr>
</table>
<p>&nbsp;</p>

</body>

</html>
<?php





?>


