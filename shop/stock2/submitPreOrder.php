	<?php

		//connect to server
		include ('includes/Link.php');
		include ('includes/SharedFunctions.php');

		$ip = getenv("REMOTE_ADDR");
		$httpref = getenv ("HTTP_REFERER");
		$httpagent = getenv ("HTTP_USER_AGENT");
		
		$strNow = date ('Y-m-j G:i:s');

		$strOrder = $_POST["combineorder"];
		
		//extract email address and check through each pre-order that it is the same

		$i = 0 ;

		foreach ($strOrder as $o)
		{
			$arrPreOrder = split ("#", $o);
			
			if ($i == 0)
			{
				$strEmailAddress = $arrPreOrder[2];
			}
			
			if ($strEmailAddress == $arrPreOrder[2])
			{
				//echo "<br>MATCH! " . $o . "*";
			}
			else
			{
				//echo "<br>NO MATCH!" .$o . "*";
				//echo "Order can not be merged due to differing accounts";
				funcLogToDebug ("submitPreOrder.php: Pre-Order Merge Failed, different accounts");
				exit();
			}
			
			
			
			//echo "\n<br>" . $arrPreOrder[0];
			//echo "\n<br>" . $arrPreOrder[1];
			//echo "\n<br>" . $arrPreOrder[2];
			
			$i = $i + 1;
			
		}
		
		//pull out user details out of tblUsers

		$strQuery = "SELECT * from tbl_UserLogin where UserID = '" . $strEmailAddress . "'";
		
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());
		
		$conNumberofRows = mysql_num_rows($strResult);

		if ($conNumberofRows = 1)
		{

			while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
			{
	
				if ($line["FirstName"] <> "")
				{
				$strFirstName = trim (funcDecrypt (hex2bin ( $line["FirstName"])));
				}
				if ($line["SurName"] <> "")
				{
				$strSurName = trim (funcDecrypt (hex2bin ( $line["SurName"])));
				}
				if ($line["AddressLine1"] <> "")
				{
				$strAddressLine1 = trim (funcDecrypt (hex2bin ( $line["AddressLine1"])));
				}
				if ($line["AddressLine2"] <> "")
				{
				$strAddressLine2 = trim (funcDecrypt (hex2bin ( $line["AddressLine2"])));
				}
				if ($line["Town"] <> "")
				{
				$strTown = trim (funcDecrypt (hex2bin ( $line["Town"])));
				}
				if ($line["County"] <> "")
				{
				$strCounty = trim (funcDecrypt (hex2bin ( $line["County"])));
				}
				if ($line["Country"] <> "")
				{
				$strCountry = trim (funcDecrypt (hex2bin ( $line["Country"])));
				}
				if ($line["PostCode"] <> "")
				{
				$strPostCode = trim (funcDecrypt (hex2bin ( $line["PostCode"])));
				}
				if ($line["DaytimeNo"] <> "")
				{
				$strDayTimeNo = trim (funcDecrypt (hex2bin ( $line["DaytimeNo"])));
				}
				if ($line["Mobile"] <> "")
				{
				$strMobile = trim (funcDecrypt (hex2bin ( $line["Mobile"])));
				}
				if ($line["MailUser"] == "1")
				{$strMailUser = 'checked';}else{$strMailUser = '';}
				$strEmailAddress = $line["emailAddress"];
			}		
		}
		else
		{
				funcLogtoDebug ("submitPreOrder.php: More than one user with emailaddress (or none?)");
		}	
	
		//prepare entry of order into tblOrders
		$strAddressLine = $strPostCode . "," . $strAddressLine1 . "," . $strAddressLine2 . "," . $strTown . "," . $strCountry;
		$strName = $strSurName . ", " . $strFirstName;

		//lets get a txn number....

		$strInsertQuery = "INSERT INTO tbl_Orders (Cookie, DateTme,Address,emailaddress, Name, Phone,Status) VALUES ('PreOrder','" . $strNow . "','" . $strAddressLine . "','" . $strEmailAddress . "','" . $strName . "','" . $strDayTimeNo . "','INITIAL')";

		$strResult = mysql_query($strInsertQuery) or die ("Query Failed :" . mysql_error());

		$strGetTXNQuery = "SELECT OrderNo from tbl_Orders where DateTme = '" . $strNow . "' and emailaddress = '" . $strEmailAddress . "'";

		$strTXNResult = mysql_query($strGetTXNQuery) or die ("Query Failed:" . mysql_error());

		//make sure we only got back one result from the last query.

		$conNumberofRows = mysql_num_rows($strTXNResult);

		if ($conNumberofRows <> 1)
		{
			echo "A Serious Error has occured. Please contact the helpdesk with the following details";
			echo "\n<br> Transaction ID: " . $strSessionID . "(" . $strAuthCookie . ")";
			echo "\n<br> Email Address : " . $strEmailAddress;
			exit;
		}

		while ($line = mysql_fetch_array($strTXNResult, MYSQL_ASSOC))
		{
			$txNumber = $line["OrderNo"];
			//echo "\n<br /><b>" . $txNumber . "</b>";
		}
		
		foreach ($strOrder as $o)
		{
			$arrPreOrder2 = split ("#", $o);
			
			$strItem = $arrPreOrder2[0];
			$strQty = $arrPreOrder2[1];
			
			$strStockQuery = "SELECT * FROM tblItem where stockID = '" . $strItem . "'";
			
			$strStockResult = mysql_query($strStockQuery) or die ("Query Failed:" . mysql_error());
			
			while ($lineStock = mysql_fetch_array($strStockResult, MYSQL_ASSOC))
			{
			
				if ($lineStock["RRP"] == $lineStock["SaleRRP"] or $lineStock["SaleRRP"]==0.00)
				{
					$strItemPrice = $lineStock["RRP"];
				}
				else
				{
					$strItemPrice = $lineStock["SaleRRP"];
				}
				
				$strWeight = $lineStock["Weight"];
				
			}

			$strOrder2 = $strOrder2 . $strItem . "(" . $strItemPrice . ")x" . $strQty . ";";
			
			$strTotal = $strTotal + ( $strItemPrice * $strQty );
			$totalWeight = $totalWeight + ($strWeight * $strQty);

			//first figure out which *zone* to send it to
			$strZoneQuery = "SELECT * FROM tbl_PostageZones WHERE Country = '" . $strCountry . "'";
			$strZoneResult = mysql_query($strZoneQuery) or die ("Query Failed :" . mysql_error());

				while ($lineZone = mysql_fetch_array($strZoneResult, MYSQL_ASSOC))
				{
					$strZone = $lineZone["Zones"];

					switch ($strZone) {

						case "Local":
							$strClass = "JamesClass";
						break;
						case "Europe":
							$strClass = "Europe";
						break;
						case "World Zone 1":
							$strClass = "Zone1";
						break;
						case "World Zone 2":
							$strClass = "Zone2";
						break;

					}

				}

			//now work out the insurance....

			if ($totalWeight < 4000)
			{

				if ($total > 30 and $total < 100)
				{
					$strInsurance = "0.00";
				}
				elseif ($total > 100 and $total < 250)
				{
					$strInsurance = "2.50";
				}
				elseif ($total > 250)
				{
					$strInsurance = "3.50";
				}
				else
				{
					$strInsurance = "0.00";
				}

			}
			else
			{

					if ($total > 150 and $total < 500)
					{
						$strInsurance = "10.00";
					}
					elseif ($total > 500 and $total < 1000)
					{
						$strInsurance = "20.00";
					}
					elseif ($total > 1000 and $total < 1500)
					{
						$strInsurance = "30.00";
					}
					elseif ($total > 1500 and $total < 2000)
					{
						$strInsurance = "40.00";
					}
					elseif ($total > 2000)
					{
						$strInsurance = "50.00";
					}
					else
					{
						$strInsurance = "0.00";
				}

			}

			$strDeliveryQuery = "SELECT * FROM tbl_Postage where DeliveryClass = '" . $strClass . "' and maxweight > " . $totalWeight . " order by MaxWeight limit 1";

			$strDeliveryResult = mysql_query($strDeliveryQuery) or die ("Query Failed :" . mysql_error());

			$conNumberofRows = mysql_num_rows($strDeliveryResult);

				while ($line3 = mysql_fetch_array($strDeliveryResult, MYSQL_ASSOC))
				{
					$str1stClassCost = $line3["Cost"];
				}

				$strShippingNote = "Postage + Insurance";

				$strShipping = $str1stClassCost + $strInsurance;

				//echo "*" . $strShipping;

	
		}
		
			//$strShipping = "0.00";

			//squirt order into database
			$strUpdateOrder = "UPDATE tbl_Orders SET items = '" . $strOrder2 . "', cost = '" . $strTotal . "', Shipping = '" . $strShipping . "' where DateTme = '" . $strNow . "' and emailAddress = '" . $strEmailAddress . "'";
			$strUpdateResult = mysql_query($strUpdateOrder) or die ("Query Failed:" . mysql_error());

			//log it.
			funcLogToDebug ("submitPreOrder.php: New Order created - " . $strOrder2 . ", Shipping - " . $strShipping  );
		

			//delete entries from pre-order table.
			foreach ($strOrder as $o)
			{

				$arrPreOrder = split ("#", $o);

				$strDeletePreOrderQry = "DELETE FROM tbl_PreOrder where uid = '" . $arrPreOrder[3] . "'";
			
				$strDeletePreOrderResult = mysql_query($strDeletePreOrderQry) or die ("Query Failed:" . mysql_error());
				
				funcLogToDebug ("submitPreOrder.php: Deleted preOrder ". $arrPreOrder[3] . ", (" . $arrPreOrder[0] . "x" . $arrPreOrder[1] .")");
				
			}			

		
		
		

			
		redirect( "default.php?Action=OutstandingOrders" , 0, "" );
		
?>




<?php


   // Redirects to another Page using HTTP-META Tag
   function redirect( $url, $delay = 0, $message = "" )
   {
      /* redirects to a new URL using meta tags */
      echo "<meta http-equiv='Refresh' content='".$delay."; url=".$url."'>";
      die( "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center> ".$message." </div>" );
   }


?>












