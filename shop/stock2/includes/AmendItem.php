<?php

			include ('includes/SharedFunctionsStrict.php');
			include ('includes/Link.php');
			
			echo "<b>This is the Amend Item View</b><p>";
			
			$strStockID = funcSanitize($_GET["stockID"]);

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
      <form method="POST" action="submitUpdate.php">
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <tr><td>
	  <?php
		echo "<table >

			<tr><td bgcolor='#FFFFCC'>Subject:</td><td><input type='text' name='Subject' size='20' value='" . $strSubject . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Version:	</td><td><input type='text' name='Version' size='20' value='" . $strVersion . "'></td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Category:	</td><td><input type='text' name='Category' size='20' value='" . $strCategory . "'></td>	</tr>
			<tr><td bgcolor='#FFFFCC'>stockID:</td><td><input type='text' name='stockID' size='20' readonly='readonly' value='" . $strStockID . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Barcode:	</td><td><input type='text' name='Barcode' size='20' value='" . $strBarcode . "'></td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Name:	</td><td>	<input type='text' name='Name' size='20' value='" . $strName . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>shortDescription:</td><td>	<input type='text' name='shortDescription' size='20' value='" . $strShortDescription . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Features:	</td><td><input type='text' name='Features' size='20' value='" . $strFeatures . "'></td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Size:		</td><td><input type='text' name='Size' size='20' value='" . $strSize . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Weight:	</td><td>	<input type='text' name='Weight' size='20' value='" . $strWeight . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Cost:	</td><td><input type='text' name='Cost' size='20' value=' " . $strCost . " '>	</td></tr>
			<tr><td bgcolor='#FFFFCC'>RRP:	</td><td>	<input type='text' name='RRP' size='20' value='" . $strRRP . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>SaleRRP:</td><td>	<input type='text' name='SaleRRP' size='20' value='" . $strSaleRRP . "'></td>	</tr>
			<tr><td bgcolor='#FFFFCC'>% Discount:	</td><td>	<input type='text' name='percentDiscount' size='20' value='" . $strPercentDiscount. "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>WholeSale Price:</td><td>	<input type='text' name='WholeSalePrice' size='20' value='" . $strWholeSalePrice . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Supplier:	</td><td>	<input type='text' name='Supplier' size='20' value='" . $strSupplier . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>Availaibility:	  </td><td>	<input type='text' name='Availability' size='20' value='" . $strAvailability . "'></td></tr>
			<tr><td bgcolor='#FFFFCC'>CategoryTag:	  </td><td><input type='text' name='CategoryTag' size='20' value='".$strCategoryTag."'></td></tr>
			<tr><td bgcolor='#FFFFCC'>SubjectTag:	  </td><td><input type='text' name='SubjectTag' size='20' value='".$strSubjectTag."'></td></tr>
			<tr><td bgcolor='#FFFFCC'>VersionTag:	  </td><td><input type='text' name='VersionTag' size='20' value='".$strVersionTag."'></td></tr>
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
			<td><input type='text' name='NoOfItems' size='25' value='" . $strNoOfItems . "'></td>
		</tr>
		<tr>
			<td bgcolor='#FFFFCC'>Small Picture:  </td>
			<td><input type='text' name='smallPicture' size='25' value='" . $strSmallPicture . "'></td>

		</tr>

		<tr>
			<td bgcolor='#FFFFCC'>Large Picture: </td>
			<td><input type='text' name='bigPicture' size='25' value='" . $strLargePicture . "'></td>
		</tr>
		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>Description:  </td>
			<td><textarea name='Description' cols='50' rows='16'>" . $strDescription . "</textarea> </td>

		</tr>

		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>On the Front Page?:  </td>
			<td><input type='checkbox' name='FrontPage' ";

			
			
			if ($strFrontPage == "checked") 
			{
				echo "checked='" . $strFrontPage . "'";
			} 
			
		echo "></td>

		</tr>

		<tr>

			<td  bgcolor='#FFFFCC' valign='top'>Featured on subCategory:  </td>
			<td><input type='checkbox' name='SubCatPage'";
			if ($strSubCatPage == "checked") {echo "checked='" . $strSubCatPage . "'";} 
		
		echo"></td>

		</tr>

	</table>
";
?>
      <br>
      <center>
        <input type="submit" value="Submit" name="B1">
        <input type="reset" value="Reset" name="B2">
      </center>

</form>

</td>
  </tr>
</table>
<p>&nbsp;</p>

</body>

</html>
<?php





?>


