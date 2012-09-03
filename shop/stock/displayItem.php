<html>

<head>

<title>The Vault StoreRoom - View</title>
	<?php $gblnDebug = true; ?>
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

		 #centerleftcontent, #leftcontent {
			border:0px solid #000;
			}

		p,h1,pre {
			margin:px 10px 10px 10px;
			}
		td {
			vertical-align: top;
			font-family:tahoma;
			font-size:11px;
			}

		#centerrightcontent p { font-size:10px}

	</style>

</head>

<body>
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
<p>
</p>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="375" valign="top"> 
      <?php
			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");

			//run query to see if result is returned

			$strStockID = $_GET['stockID'];

			funcDebug ("stockID: " . $strStockID);

			$strQuery = "SELECT * FROM tblItem where stockID LIKE '" . $strStockID . "'";
			funcDebug ("strQuery: " . $strQuery);
			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

			$conNumberofRows = mysql_num_rows($strResult);
			//$row = mysql_fetch_array ($strResult);

	//if there are no rows in the table with the same ID, error then redirect within 5 seconds to add page
	if ($conNumberofRows != 1 )
		{
			echo "<b>ERROR! StockID ". $strStockID . "Doesn't exist in the database or there is more than one result<br>\n";
			echo "Redirecting you to the 'add' section of website</b><br>\n";

			echo "<meta http-equiv='REFRESH' content='5; URL=http://172.16.1.3/prototype3.htm'>";
		}
	else
		{
			funcDebug ("stockID submitted: " . $_POST["stockID"]);

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

echo "<table >

			<tr><td bgcolor='#FFFFCC'>Subject:</td><td>&nbsp;&nbsp;&nbsp;</td><td>". $strSubject ."</td></tr>
			<tr><td bgcolor='#FFFFCC'>Version:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strVersion."</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Category:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strCategory."</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>stockID:</td><td>&nbsp;&nbsp;&nbsp;</td><td>". $strStockID ."</td></tr>
			<tr><td bgcolor='#FFFFCC'>Barcode:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strBarcode."</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Name:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>". $strName."</td></tr>
			<tr><td bgcolor='#FFFFCC'>shortDescription:</td><td>&nbsp;&nbsp;&nbsp;</td><td>" . $strShortDescription . "</td></tr>
			<tr><td bgcolor='#FFFFCC'>Features:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strFeatures."</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>Size:		</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strSize."</td></tr>
			<tr><td bgcolor='#FFFFCC'>Weight:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strWeight."</td></tr>
			<tr><td bgcolor='#FFFFCC'>Cost:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strCost."</td></tr>
			<tr><td bgcolor='#FFFFCC'>RRP:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strRRP."</td></tr>
			<tr><td bgcolor='#FFFFCC'>SaleRRP:</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strSaleRRP."</td>	</tr>
			<tr><td bgcolor='#FFFFCC'>% Discount:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strPercentDiscount."</td></tr>
			<tr><td bgcolor='#FFFFCC'>WholeSale Price:</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strWholeSalePrice."</td></tr>
			<tr><td bgcolor='#FFFFCC'>Supplier:	</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strSupplier."</td></tr>
			<tr><td bgcolor='#FFFFCC'>Availability:	  </td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strAvailability."</td></tr>
			<tr><td bgcolor='#FFFFCC'>CategoryTag:	  </td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strCategoryTag."</td></tr>
			<tr><td bgcolor='#FFFFCC'>SubjectTag:	  </td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strSubjectTag."</td></tr>
			<tr><td bgcolor='#FFFFCC'>VersionTag:	  </td><td>&nbsp;&nbsp;&nbsp;</td><td>".$strVersionTag."</td></tr>
		</table>";

?>
    </td>
    <td width="375" valign="top"> 
      <table>
        <tr> 
        <tr>
          <td bgcolor="#FFFFCC">Stock Count: </td>
          <td> 
            <?php echo $strNoOfItems; ?>
          </td>
        </tr>
        <td  bgcolor="#FFFFCC" valign='top'>Description: </td>
        <td> 
          <?php echo $strDescription; ?>
        </td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFCC">Small Picture: </td>
          <?php echo "<td><img src='../" . $strSmallPicture . "' width=90></td>"; ?>
        </tr>
        <tr> 
          <td bgcolor="#FFFFCC">Large Picture: </td>
          <?php echo "<td><img src='../" . $strLargePicture . "' width=300></td>"; ?>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>
  <?php

			//close connection to database
			funcDebug ("Closing link to db");
			mysql_close ($link);
		?>
</p>

</body>

<?php
	// ******************************************************************
	//
	//  Name	: funcDebug
	//  Author	: Adrian Farnell
	//  Notes	: funcDebug displays debugging info whilst page
	//		  is processing. To stop messages set $blnDebug
	//		  to false
	//
	// ******************************************************************
	function funcDebug ($strMsg)
		{
		//allow this function to "see" the global boolean set at the
		//top of the page
		global $gblnDebug;

		//only display text if $gblnDebug is set to true
		if ($gblnDebug == true)
			{

			//format now time and put into a string
			$strToday = date("H:i:s");

			//display the message with a time stamp
			echo "<!-- " .$strToday . " Debug: " . $strMsg . "-->\n";

			//return a value if needed
			return $retval;

			//end if statement
			}

		//end function
		}
?>

</html>

