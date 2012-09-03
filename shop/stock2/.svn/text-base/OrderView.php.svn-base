<?php

//print_r($_COOKIE);
include ('includes/SharedFunctionsStrict.php');



?>
<HTML>
	<HEAD>
		<TITLE>Welcome to SciFi Vault!</TITLE>

<link rel="stylesheet" href="stylesheets/mainstylesheet.css" type="text/css">
</HEAD>


<BODY bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<table  border="0" cellspacing="0" cellpadding="5" width="900" align="center">
  <tr> 
    <td width="489"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="http://shop.scifivault.com/index3.php"><img src="../images/scifi-small-best.jpg" width="403" height="62" border="0"></a> 
      </font> 
      <div align="right"> </div>
    </td>
    <td width="391" valign="top"> 
      <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="6"><b>Invoice</b></font></div>
    </td>
  </tr>
</table>
<br>
<font face="Verdana, Arial, Helvetica, sans-serif"><table  border="1" cellspacing="0" cellpadding="5" width="900" align="center"> 
</font><font face="Verdana, Arial, Helvetica, sans-serif"><tr></font>
<font face="Verdana, Arial, Helvetica, sans-serif"><td></font>
<font face="Verdana, Arial, Helvetica, sans-serif">
<?php

//connect to database
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );

//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");

$strOrderNo = funcSanitize ($_GET['strOrder']);

//query to get all baskets
$strQuery = "SELECT * FROM tbl_Orders where OrderNo = '" . $strOrderNo . "'";

//execute query
$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());



while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
{

	$strOrderNo= $line["OrderNo"];
	$strOrderSubmitted = $line["DateTme"];
	$strCookie = $line["Cookie"];
	$strItems = $line["Items"];
	$strShipping = $line["Shipping"];
	$strCost = $line["Cost"];
	$strAddress = strtoupper($line["Address"]);
	$strEmailAddress = $line["emailaddress"];
	$strName = strtoupper($line["Name"]);
	$strPhone = $line["Phone"];
	$strIPNSubmitted = $line["IPNDateTime"];
	$strPaypalTXN = $line["PaypalTXN"];
	$strStatus = $line["Status"];




	
	//echo "</tr></td>";


	echo "<table>";
	echo "<form method='post' action='updateOrder.php'>";


	echo "<input type='hidden' name='orderno' value='". $strOrderNo ."'>";

	echo "<tr><td><font face='Verdana' size=+2>" . $strName . "</font></td><td></td></tr>";

	$arrAddress = split (",", $strAddress);

	echo "<!-- ";
	
	/*for ( $i=0 ; $i <7 ; $i++)
	{
		echo "\narrAddress(" . $i . ") = " . $arrAddress[$i];
	}
	
	echo "-->";*/
	
	echo "<tr><td><font face='Verdana' size=+2>" . $arrAddress[1] . " ";

	if (strLen($arrAddress[1]) < 5)
	{
		if (trim ($arrAddress[2])<>""){echo  $arrAddress[2];}
		if (trim ($arrAddress[3])<>""){echo "<br>" . $arrAddress[3]; }
		if (trim ($arrAddress[4])<>""){echo "<br>" . $arrAddress[4]; }
		if (trim ($arrAddress[0])<>""){echo "<br>" . $arrAddress[0]; }
		if (trim ($arrAddress[5])<>""){echo "<br>" . $arrAddress[5]; }
	}
	else
	{
		if (trim ($arrAddress[2])<>""){echo "<br>" . $arrAddress[2];}
		if (trim ($arrAddress[5])<>""){echo "<br>" . $arrAddress[5];}
		if (trim ($arrAddress[3])<>""){echo "<br>" . $arrAddress[3]; }
		if (trim ($arrAddress[0])<>""){echo "<br>" . $arrAddress[0]; }
		if (trim ($arrAddress[4])<>""){echo "<br>" . $arrAddress[4]; }
		
	}
	
	
	

	
	//echo "<br>" . $arrAddress[5] . "<br>" . $arrAddress[3] . "<br>" .$arrAddress[0] ."<br>" .$arrAddress[4] ."</font><br><br>";

	echo "<br><br><br><br>";
	echo "Order No:" . $strOrderNo ."<br><br>";
	echo "<tr><td>Date Ordered:</td><td>" . date ("D jS M Y - G:i", strtotime($strOrderSubmitted)) . "</td></tr>";
	echo "<tr><td>Payment Recieved:</td><td>" . date ("D jS M Y - G:i", strtotime($strIPNSubmitted)) . "</td></tr>";

	//echo "<tr><td><br>Status:</td><td><br>" . $strStatus . "</td>";

	switch ($strStatus)
	{
		case "PAID":
			echo "<tr><td>Status:</td><td><select name='STATUS'><option value='CANCELLED'>CANCELLED</option><option value='REFUNDED'>REFUNDED</option><option value='ON HOLD'>ON HOLD</option><option value='PAID' selected='selected'>PAID</option><option value='PACKING'>PACKING</option><option value='SENT'>SENT</option></select><input type='submit' value='Submit'></td></tr>";
			break;
		case "CANCELLED":
			echo "<tr><td>Status:</td><td>CANCELLED</td></tr>";
			break;
		
		case "INITIAL":
			echo "<tr><td>Status:</td><td><select name='STATUS'><option value='CANCELLED'>CANCELLED</option><option value='REFUNDED'>REFUNDED</option><option value='ON HOLD'>ON HOLD</option><option value='INITIAL' selected='selected'>INITIAL</option><option value='PAID'>PAID</option><option value='PACKING'>PACKING</option><option value='SENT'>SENT</option><input type='submit' value='Submit'></select></td></tr>";
			break;
		case "PACKING":
			echo "<tr><td>Status:</td><td><select name='STATUS'><option value='CANCELLED'>CANCELLED</option><option value='REFUNDED'>REFUNDED</option><option value='ON HOLD'>ON HOLD</option><option value='PAID'>PAID</option><option value='PACKING'  selected='selected'>PACKING</option><option value='SENT'>SENT</option></select><input type='submit' value='Submit'></td></tr>";
			break;
		case "SENT":
 			echo "<tr><td>Status:</td><td><select name='STATUS'><option value='REFUNDED'>REFUNDED</option><option value='SENT' selected='selected'>SENT</option></select><input type='submit' value='Submit'></td></tr>";
 			break;
		case "ON HOLD":
			echo "<tr><td>Status:</td><td><select name='STATUS'><option value='CANCELLED'>CANCELLED</option><option value='REFUNDED'>REFUNDED</option><option value='ON HOLD' selected='selected'>ON HOLD</option><option value='PAID'>PAID</option><option value='PACKING'>PACKING</option><option value='SENT'>SENT</option></select><input type='submit' value='Submit'></td></tr>";
			break;
		case "REFUNDED":
			echo "<tr><td>Status:</td><td><select name='STATUS'><option value='CANCELLED'>CANCELLED</option><option value='REFUNDED' selected='selected'>REFUNDED</option><option value='ON HOLD'>ON HOLD</option><option value='PAID'>PAID</option><option value='PACKING'>PACKING</option><option value='SENT'>SENT</option></select><input type='submit' value='Submit'></td></tr>";
			break;
		default:
			break;


	}



echo "</tr></form></table>";

?>
</font>
<p> </p>
<table border="1" width='100%'>
  <tr> 
    <td width="50"><font face="Verdana, Arial, Helvetica, sans-serif">Qty</font></td>
    <td width="85"><font face="Verdana, Arial, Helvetica, sans-serif">Item Code</font></td>
    <td width="69"><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></td>
    <td width="60"><font face="Verdana, Arial, Helvetica, sans-serif">Cost/Item</font></td>
    <td width="192"><font face="Verdana, Arial, Helvetica, sans-serif">Cost</font></td>
  </tr>
  <?php

	$arrItems=split(';', $strItems);

	foreach ($arrItems as $item)
	{
		//echo "Value: " . substr($item, 0, strpos($item, "(" )) . "<br />" ;

		$strItemQuery = "SELECT Name from tblItem where stockID = '" . substr($item, 0, strpos($item, "(" )) . "'";
		$strItemResult = mysql_query($strItemQuery) or die ("Query Failed :" . mysql_error());

		$strStockID = substr($item, 0, strpos($item, "(" ));

		while ($lineItem = mysql_fetch_array($strItemResult, MYSQL_ASSOC))
		{
			$strNamedItem = $lineItem["Name"];
			$strPrice = substr($item, strpos($item,"(" )+1 , strrpos($item,")")- strpos($item,"(" )-1);
			$strQty = substr($item, strpos($item, "x")+1);

			echo "<tr><td>" . $strQty . "</td><td><a href='/displayItem.php?Item=" . $strStockID . "'>" . $strStockID . "</a></td><td><a href='/displayItem.php?Item=" . $strStockID . "'>" . $strNamedItem . "</a></td><td align='right'>&pound;" . $strPrice ."</td><td align='right'>&pound;" . $strPrice * $strQty. "</td></tr><br />";
		}

	}
	echo "<tr><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>";
	echo "<tr><td></td><td></td><td align='right'><b>Shipping</b></td><td></td><td align='right'>&pound;" . sprintf ("%01.2f",$strShipping) . "</td></tr>";
	echo "<tr><td></td><td></td><td align='right'><b>Total</b></td><td></td><td align='right'>&pound;" . sprintf ("%01.2f",$strShipping+$strCost) . "</td></tr>";
	echo "</table>";





}


?>
  <div align="left"></div>
  <font face="Verdana, Arial, Helvetica, sans-serif"></td></font>
  <font face="Verdana, Arial, Helvetica, sans-serif"></tr></font>
</table>
<p><font face="Verdana, Arial, Helvetica, sans-serif"><br>
  </font></p>
<tr> 
  <p align="center"><font size="4" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank 
    you for shopping with Sci-Fi Vault<br>
    </b></font>
  <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><br>
    </font>
  <table width="900" border="0" align="center">
    <tr> 
      <td> 
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Sci-Fi 
          Vault Ltd &copy; 2006<br>
          www.scifivault.com</font></div>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div align="center"></div>

</HTML>
