<?php

	include ('includes/Link.php');
	include ('includes/SharedFunctions.php');
	
	echo "<b>This is the User Details View</b>";
	
	$strUserID = trim (funcSanitize($_POST["UserID"]));

	if ($strUserID =="")
	{
		$strUserID = trim (funcSanitize($_GET["UserID"]));
	}
	

	if ($strUserID =="")
	{
		echo "<p>No user Specified in search";
		exit();
	}	

	
	$strQuery = "SELECT * from tbl_UserLogin where UserID = '" . $strUserID . "'";
	
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


		echo "<p><table>";
?>
			<tr><td bgcolor="#FFFFCC">First Name:	  </td><td>	<input type="text" name="FirstName" size="20" value="<?php echo $strFirstName; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Last Name:	  </td><td>	<input type="text" name="SurName" size="20" value="<?php echo $strSurName; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Address Line 1:	  </td><td>	<input type="text" name="AddressLine1" size="20" value="<?php echo $strAddressLine1; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Address Line 2:	  </td><td>	<input type="text" name="AddressLine2" size="20" value="<?php echo $strAddressLine2; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Town/City:	  </td><td>	<input type="text" name="Town" size="20" value="<?php echo $strTown; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">County:	  </td><td>	<input type="text" name="County" size="20" value="<?php echo $strCounty; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Country:	  </td><td>	              <select name="Country" width="20" STYLE="width:150px">
			
		
              	<?php

				if ($strCountry <> "UK")
				{
				echo "\n\t<option value='" . $strCountry . "' selected='selected'>" . $strCountry . "</option>";
				echo "\n\t<option value='UK'>UK</option>";
				}
				else
				{echo "\n\t<option value='UK' selected='selected'>UK</option>";}

              	$strOptionQuery = "SELECT Country FROM tbl_PostageZones where Country <> 'UK'";

				$strOptionResult = mysql_query($strOptionQuery) or die ("Query Failed :" . mysql_error());

				while ($line = mysql_fetch_array($strOptionResult, MYSQL_ASSOC))
				{

					echo "\n\t<option value='" . $line["Country"] . "'>" . $line["Country"] . "</option>";

				}

              	?>

              </select><br></td></tr>
			<tr><td bgcolor="#FFFFCC">PostCode:	  </td><td>	<input type="text" name="PostCode" size="20" value="<?php echo $strPostCode; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Daytime Contact No:	  </td><td>	<input type="text" name="DayTimeNo" size="20" value="<?php echo $strDayTimeNo; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Mobile:	  </td><td>	<input type="text" name="Mobile" size="20" value="<?php echo $strMobile; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Email Address:	  </td><td>	<?php echo $strEmailAddress; ?><br></td></tr>
<tr><th colspan='2'> <input type='checkbox' name='emailUser' <?php if ($strMailUser == 'checked') {echo "checked='" . $strMailUser . "'";} ?>>Mails Allowed?<th></tr>			
		<?php
			
		echo "</table>";

		echo "<p><a href='default.php?Action=UserDetails&UserID=" . $strUserID . "'>Default View</a>";
		echo "<p><a href='default.php?Action=UserDetails&subAction=OO&UserID=" . $strUserID . "'>See more Outstanding Orders for this User</a>";
		echo "<p><a href='default.php?Action=UserDetails&subAction=CO&UserID=" . $strUserID . "'>See more Completed Orders for this User</a>";
		echo "<p><a href='default.php?Action=UserDetails&subAction=PO&UserID=" . $strUserID . "'>See more Pre Orders for this User</a>";
		
	
		echo "</div><div class='orders'>";
		
		echo "<b>Outstanding Orders</b> ";

		
		
		if (funcSanitize($_GET["subAction"])== "OO") 
			 { echo "(all)"; $strLimit = "";} else { echo "(last 5...)"; $strLimit = "LIMIT 5"; }
		
		$strOOQuery = "SELECT * FROM tbl_Orders where emailAddress = '" . $strUserID . "' and status <> 'SENT' order by IPNDateTime DESC Limit 5";;
		$strOOResults = mysql_query($strOOQuery) or die ("Query Failed :" . mysql_error());

		if (mysql_num_rows($strOOResults)<>0)
		{
		echo "<p>\n<table id='rightmenus'>";
		echo "<tr><td id='headings'>Order No</td><td id='headings'>Email Address</td><td id='headings'>Payment Received</td><td id='headings'>Cost</td><td id='headings'>Status</td></tr>";
				
		While ($line = mysql_fetch_array($strOOResults, MYSQL_ASSOC))
		{
			echo "<tr> <td> <a href='/stock2/OrderView.php?strOrder=" . $line["OrderNo"]. "'>" . $line["OrderNo"] . "</a></td><td>"  . $line["emailaddress"]. " </td><td> " . $line["IPNDateTime"] ."</td><td>&pound;" . sprintf ("%01.2f" , $line["Shipping"] + $line["Cost"]) ."</td> <td>" . $line["Status"] . "</td> </tr>";
		}
		
		echo "</table>";
		}
		else
		{
			
			echo "<p>No Outstanding Orders";
		
		}
		echo "<p><b>Completed Orders</b> ";

		if (funcSanitize($_GET["subAction"])== "CO") 
			{ echo "(all)"; $strLimit = "";} else { echo "(last 5...)"; $strLimit = "LIMIT 5"; } 
		
		$strCOQuery = "SELECT * FROM tbl_Orders where emailAddress = '" . $strUserID . "' and status = 'SENT' order by IPNDateTime DESC " . $strLimit;
		$strCOResults = mysql_query($strCOQuery) or die ("Query Failed :" . mysql_error());

		if (mysql_num_rows($strCOResults)<>0)
		{
		echo "<p>\n<table id='rightmenus'>";
		echo "<tr><td id='headings'>Order No</td><td id='headings'>Email Address</td><td id='headings'>Payment Received</td><td id='headings'>Cost</td><td id='headings'>Status</td></tr>";
				
		While ($line = mysql_fetch_array($strCOResults, MYSQL_ASSOC))
		{
			echo "<tr> <td> <a href='/stock2/OrderView.php?strOrder=" . $line["OrderNo"]. "'>" . $line["OrderNo"] . "</a></td><td>"  . $line["emailaddress"]. " </td><td> " . $line["IPNDateTime"] ."</td><td>&pound;" . sprintf ("%01.2f" , $line["Shipping"] + $line["Cost"]) ."</td> <td>" . $line["Status"] . "</td> </tr>";
		}
		
		echo "</table>";
		}
		else
		{
			
			echo "<p>No Completed Orders";
		
		}
		
		echo "<p><b>Pre Orders</b> ";

		if (funcSanitize($_GET["subAction"])== "PO") 
			{ echo "(all)"; $strLimit = "";} else { echo "(last 5...)"; $strLimit = "LIMIT 5"; } 		
		
		$strPOQuery = "SELECT * FROM tbl_PreOrder where emailaddress = '" . $strUserID . "' order by date DESC " . $strLimit;
		$strPOResults = mysql_query($strPOQuery) or die ("Query Failed :" . mysql_error());

		
		
		if (mysql_num_rows($strPOResults)<>0)
		{
			echo "<form action='submitPreOrder.php' method='POST'>";
		
			echo "<p>\n<table id='rightmenus'>";
			echo "<tr><td id='headings'>stockID</td><td id='headings'>Date Recieved</td><td id='headings'>Qty</td><td></td></tr>";
				
			While ($line = mysql_fetch_array($strPOResults, MYSQL_ASSOC))
			{
	
				echo "<tr> <td> " . $line["stockID"]. "</td><td>"  . $line["date"]. " </td><td> " . $line["qty"] ."</td><td> 
				<input type='checkbox' name='combineorder[]' value='" . $line["stockID"] .  "#" . $line["qty"] . "#" . $line["emailaddress"] . "#" . $line["uid"] . "'>
				</td> </tr>";
				//echo "<input type='hidden' name='qty' value='" . $line["qty"] ."'>";
				
			}
		
			echo "</table>";
		
		
		echo "<p /><input type='submit' name='submit' value='Add Order' />";
		
		echo "</form>";
		
		}
		else
		{
			
			echo "<p>No Pre Orders";
		
		}	
		
		
}
else
{
	echo "<p>No user of Username: <b>" . $strUserName . "</b>";
}
	
?>
