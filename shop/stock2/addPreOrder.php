<?php 

		include ('includes/Link.php');
		include ('includes/SharedFunctionsStrict.php');
		
		$strUserOrdertoAdd = funcSanitize($_POST["email"]);
		
		funcDebug ("AddPreOrder.php: AddPreOrder.php fired " . $strUserOrdertoAdd);
		
		$strSessionID = "PreOrder";
		$strAuthCookie = "PreOrder";
		
		$strNow = date ('Y-m-j H:i:s');

	     foreach($_POST as $key => $val){

				$arrItem = split ("#", $key);
				$strUserID = $arrItem[0];
				echo $key;
				exit();

		}
		
		
		
$strAddressQuery = "SELECT * from tbl_UserLogin where UserID = '" . $strUserID . "'";

$strAddressResult = mysql_query($strAddressQuery) or die ("Query Failed :" . mysql_error());

$conNumberofRows = mysql_num_rows($strAddressResult);

if ($conNumberofRows == 0)
{
	echo "You've not got a delivery address";
	echo "<br><br> Click <a href='UserDetails.php?strUserID=" . $strUserID . "'>here</a> to go back to shop";
	exit;
}

	while ($line2 = mysql_fetch_array($strAddressResult, MYSQL_ASSOC))
	{

		if ($line2["FirstName"] <> "")
		{
		$strFirstName = trim (funcDecrypt (hex2bin ( $line2["FirstName"])));
		}
		if ($line2["SurName"] <> "")
		{
		$strSurName = trim (funcDecrypt (hex2bin ( $line2["SurName"])));
		}
		if ($line2["AddressLine1"] <> "")
		{
		$strAddressLine1 = trim (funcDecrypt (hex2bin ( $line2["AddressLine1"])));
		}
		if ($line2["AddressLine2"] <> "")
		{
		$strAddressLine2 = trim (funcDecrypt (hex2bin ( $line2["AddressLine2"])));
		}
		if ($line2["Town"] <> "")
		{
		$strTown = trim (funcDecrypt (hex2bin ( $line2["Town"])));
		}
		if ($line2["County"] <> "")
		{
		$strCounty = trim (funcDecrypt (hex2bin ( $line2["County"])));
		}
		if ($line2["Country"] <> "")
		{
		$strCountry = trim (funcDecrypt (hex2bin ( $line2["Country"])));
		}
		if ($line2["PostCode"] <> "")
		{
		$strPostCode = trim (funcDecrypt (hex2bin ( $line2["PostCode"])));
		}
		if ($line2["DaytimeNo"] <> "")
		{
		$strDayTimeNo = trim (funcDecrypt (hex2bin ( $line2["DaytimeNo"])));
		}
		if ($line2["Mobile"] <> "")
		{
		$strMobile = trim (funcDecrypt (hex2bin ( $line2["Mobile"])));
		}
		$strEmailAddress = $line2["emailAddress"];
	}
		
		$strAddressLine = $strPostCode . ", " . $strAddressLine1 . ", " . $strAddressLine2 . ", " . $strTown;
		
		
		//$strName
		//$strDayTimeNo
		
		//$total
		//$strPostageCost 
		
		//lets get a txn number....
	
		$strInsertQuery = "INSERT INTO tbl_Orders (Cookie, DateTme,Shipping,Cost,Address,emailaddress, Name, Phone,Status) VALUES ('" . $strSessionID . "(" . $strAuthCookie . ")','" . $strNow . "','" . $strPostageCost . "','" . $total . "','" . $strAddressLine . "','" . $strEmailAddress . "','" . $strName . "','" . $strDayTimeNo . "','INITIAL')";

		$strResult = mysql_query($strInsertQuery) or die ("Query Failed :" . mysql_error());

		$strGetTXNQuery = "SELECT OrderNo from tbl_Orders where Cookie = '" . $strSessionID . "(" .	 $strAuthCookie . ")' and Cost = '" . $total . "'";

		$strTXNResult = mysql_query($strGetTXNQuery) or die ("Query Failed:" . mysql_error());

		
		
		
		


		

?>
