<html>

<head>

<title>The Vault StoreRoom - Update</title>

	<style type="text/css">
		@import "all.css"; /* just some basic formatting, no layout stuff */

		body {
			margin:5px 0px 0px 5px;
			}

		#topmenu {

			position: absolute;
			top:100px;
			left:1%;
			height:17px;
			width:95%;
			background:#9999CC;
			font-family:Arial;
			font-size:12px;
			color:white;

		}

		#leftcontent {
			position: absolute;
			left:1%;
			width:13%;
			top:125px;
			background:#fff;
			}

		#centerleftcontent {
			position: absolute;
			left:20%;
			width:30%;
			top:125px;
			background:#fff;
			font-size:10px;
			font-family: tahoma;
			}

		#centerrightcontent {
			position: absolute;
			left:53%;
			width:25%;
			top:125px;
			background:#fff;
			}

		#rightcontent {
			position: absolute;
			left:94%;
			width:1%;
			top:125px;
			background:#fff;
			}

		#rightcontent, #centerrightcontent, #centerleftcontent, #leftcontent {
			border:0px solid #000;
			}

		p,h1,pre {
			margin:0px 10px 10px 10px;
			}
		td {
			font-family:tahoma;
			font-size:10px;
		}



		#centerrightcontent p { font-size:10px}

	</style>

</head>

<body>


<p align="center">&nbsp;
<?php
			include ('includes/SharedFunctionsStrict.php');

			$strStockID = funcSanitize($_GET["stockID"]);

			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");

			//run query to see if result is returned

			//$strStockID = funcSanitize ($_POST["stockID"]);
			$strQuery = "SELECT * FROM tblItem where stockID = '" . $strStockID . "'";
			funcDebug ("strQuery: " . $strQuery);
			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

			$conNumberofRows = mysql_num_rows($strResult);
			//$row = mysql_fetch_array ($strResult);

	//if there are no rows in the table with the same ID, error then redirect within 5 seconds to add page
	if ($conNumberofRows != 1 )
		{
			echo "<b>ERROR! StockID ". $strStockID . "Doesn't exist in the database or there is more than one result<br>\n";
			echo "Redirecting you to the 'update' section of website</b><br>\n";

			echo "<meta http-equiv='REFRESH' content='5;updateItem.htm'>";
		}
	else
		{
			funcDebug ("stockID submitted: " . $_GET["stockID"]);

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
			}


?>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
      <div align="center">
        <p><a href="index.htm"><img src="../images/scifi-small-best.jpg" width="403" height="62" border="0"></a><br>
          <font face="Verdana, Arial, Helvetica, sans-serif" size="3">T h e <b>S
          t o c k</b> R o o m</font></p>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <hr>
      <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="viewItem.htm">View</a>
        | <a href="updateItem.htm">Update</a> | <a href="addItem.htm">Add<br>
        </a></font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="DisplayBaskets.php">Display
        Baskets</a> | <a href="ListOrders.php">Current Orders</a> | <a href="CompletedOrders.php">
        Completed Orders</a> | <a href="lowStock.php">Low Stock</a><br>
        <a href="bugReport.htm">Submit a Bug</a> | <a href="displayBugs.php">View
        Open Bugs</a> | <a href="displayAllBugs.php">View All Bugs</a></font></p>
      <hr>
    </td>
  </tr>
</table>
<br>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="375" valign="top">
      <form method="POST" action="submitUpdate.php">
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


