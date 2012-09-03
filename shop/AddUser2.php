
<HTML>


<HEAD>
<link rel="stylesheet" href="stylesheets/mainstylesheet.css" type="text/css">
</HEAD>
<BODY>
<?php

	include ('includes/SharedFunctions.php');

	//Get data from AddUser2.htm
	$strUserName = $_POST['EmailAddress'];
	//$strUserName = $_POST['EmailAddress'];
	$strEmailAddress = $_POST['EmailAddress'];
	$strPassword1 = $_POST['Password'];
	$strPassword2 = $_POST['Password2'];

	$strFirstName = funcSanitize ($_POST["FirstName"]);
	$strSurName  = funcSanitize ($_POST["SurName"]);
	$strAddressLine1 = funcSanitize ($_POST["AddressLine1"]);
	$strAddressLine2  = funcSanitize ($_POST["AddressLine2"]);
	$strTown = funcSanitize ($_POST["Town"]);
	$strCounty = funcSanitize ($_POST["County"]);
	$strCountry = funcSanitize ($_POST["Country"]);
	$strPostCode = funcSanitize ($_POST["PostCode"]);
	$strDayTimeNo = funcSanitize ($_POST["DayTimeNo"]);
	$strMobile = funcSanitize ($_POST["Mobile"]);
	$strEmailAddress = funcSanitize ($_POST["EmailAddress"]);
	$strEmailUser = funcSanitize($_POST["emailUser"]);


	$strPassthroughDetails = "Name=" . $strFirstName . "#" . "Surname=" . $strSurName ."#" .
							"AddressLine1=" . $strAddressLine1 . "#" . "AddressLine2=" . $strAddressLine2 ."#" .
							"Town=" . $strTown . "#" . "County=" . $strCounty . "#Country=" . $strCountry ."#" .
							"Postcode=" . $strPostCode . "#Daytime=" . $strDayTimeNo . "#Mobile=" . $strMobile .
							"#Email=" . $strEmailAddress;

	$strEncPassthroughDetails = funcEncrypt ($strPassthroughDetails);

	$strEncFirstName = funcEncrypt ($strFirstName);
	$strEncSurName = funcEncrypt ($strSurName);
	$strEncAddressLine1 = funcEncrypt ($strAddressLine1);
	$strEncAddressLine2 = funcEncrypt ($strAddressLine2);
	$strEncTown = funcEncrypt ($strTown);
	$strEncCounty = funcEncrypt ($strCounty);
	$strEncCountry = funcEncrypt ($strCountry);
	$strEncPostCode = funcEncrypt ($strPostCode);
	$strEncDayTimeNo = funcEncrypt ($strDayTimeNo);
	$strEncMobile = funcEncrypt ($strMobile);




	//first check strUserName is alphanumeric
	$boolMatch = preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $strUserName);
	if ($boolMatch == 0 or $strUserName == "")
	{
		//UserName is invalid, forward back to register.php
		echo "<meta http-equiv='refresh' content='0;url=/ChooseDelivery2.php?EmailError=1'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " tried to register and failed strUserName didn't pass regular expression");
	}
	else
	{
		//UserName is valid, do nothing
	};

	//first check strEmailAdress conforms
	$boolMatch = preg_match ("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $strEmailAddress);
	if ($boolMatch == 0 or $strEmailAddress == "")
	{
		//email is invalid
		echo "<meta http-equiv='refresh' content='0;url=/register.php?EmailError=1&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " invalid email address");
		exit();
	}
	else
	{
		//email appears valid, do nothing
	}

	//we're going to set the password later on as this is a partial registration
	/*if ($strPassword1 == $strPassword2)
	{
		//we're going to set the password later on as this is a partial registration
		//$strMD5 = md5 ($strPassword1);
	}
	else
	{
		//passwords don't match. Error gracefully.
		echo "<meta http-equiv='refresh' content='0;url=/register.php?PasswordError=1&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " passwords didn't match");
		exit();
	}
	*/

	if ($strFirstName == "")
	{
		//FirstName is invalid
		echo "<meta http-equiv='refresh' content='0;url=/register.php?ReqdFieldError=1&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " first name invalid");
		exit();
	}
	else
	{
		//email appears valid, do nothing
	}

	if ($strSurName == "")
	{
		//FirstName is invalid
		echo "<meta http-equiv='refresh' content='0;url=/register.php?ReqdFieldError=2&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " surname is not valid");
		exit();
	}
	else
	{
		//email appears valid, do nothing
	}

	if ($strAddressLine1 == "")
	{
		//FirstName is invalid
		echo "<meta http-equiv='refresh' content='0;url=/register.php?ReqdFieldError=3&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " address line is not valid");
		exit();
	}
	else
	{
		//email appears valid, do nothing
	}

	if ($strPostCode == "")
	{
		//FirstName is invalid
		echo "<meta http-equiv='refresh' content='0;url=/register.php?ReqdFieldError=4&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " post code is not valid");
		exit();
	}
	else
	{
		//email appears valid, do nothing
	}
	if ($strEmailUser == "on")
	{
		$strEmailUser = '1';
	}
	else
	{
		$strEmailUser = '0';
	}
/*	if ($strDayTimeNo == "")
	{
		//FirstName is invalid
		echo "<meta http-equiv='refresh' content='0;url=/register.php?ReqdFieldError=5&Data=" . $strEncPassthroughDetails . "'>";
		funcLogtoDebug ("AddUser2.php: " . $strUserName . " daytime not invalid (it was blank)");
		exit();
	}
	else
	{
		//email appears valid, do nothing
	}
*/


	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");

	//Does User Exist

	$strUserQuery = "SELECT UserID,emailAddress FROM tbl_UserLogin where UserID = '" . $strUserName ."' and emailAddress = '" . $strEmailAddress . "'";
	$strUserResult = mysql_query ($strUserQuery) or die ("Query Failed:" . mysql_error());

	//User Exists, so Error gracefully, then forward the user on
	$conNumberofRows = mysql_num_rows($strUserResult);
	if ($conNumberofRows == 0)
	{

		//create random 14 digit verification key

		$length    = 16;
		$key_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$rand_max  = strlen($key_chars) - 1;

		for ($i = 0; $i < $length; $i++)
		{
		   $rand_pos  = rand(0, $rand_max);
		   $rand_key[] = $key_chars{$rand_pos};
		}

		$rand_pass = implode('', $rand_key);

		$length = 8;
		
		for ($j = 0; $j < $length; $j++)
		{
		   $rand_pos2  = rand(0, $rand_max);
		   $rand_key2[] = $key_chars{$rand_pos2};
		}

		$rand_pass2 = implode('', $rand_key2);		
		
		
		//echo $rand_pass;

		$strNow = date ('Y-m-j H:i:s');

		//User Doesn't exist so carry on Adding
		//$strAddUserQuery = "INSERT tbl_UserLogin values ('', '" . $strUserName . "', '" . $strEmailAddress. "','" . $strMD5 ."', '" . $rand_pass . " ', '" . $strNow . "', '', '" . $strFirstName . "','" . $strSurName . "','" . $strAddressLine1 . "','" . $strAddressLine2 . "','" . $strTown . "','" . $strCounty. "','". $strCountry . "','" . $strPostCode . "','" . $strDayTimeNo. "','".$strMobile."','','')";
		$strAddUserQuery = "INSERT tbl_UserLogin values ('', '" . $strUserName . "', '" . $strEmailAddress. "','" . md5($rand_pass2) ."', '" . $rand_pass . "', '" . $strNow . "', '', '" . $strEncFirstName . "','" . $strEncSurName . "','" . $strEncAddressLine1 . "','" . $strEncAddressLine2 . "','" . $strEncTown . "','" . $strEncCounty. "','". $strEncCountry . "','" . $strEncPostCode . "','" . $strEncDayTimeNo. "','".$strEncMobile."','','1','" . $strEmailUser . "')";

		$strAddUserResult = mysql_query ($strAddUserQuery) or die ("Query Failed:" . mysql_error());


		$strMailText = " \nWe've taken the time to register you with us at Sci-Fi Vault. \n
Your account login details are as follows:
\nUsername: " . $strUserName . "
Password: " . $rand_pass2 . "

If you would like to order with us in future, click on the verify link below to complete your registration:

http://shop.scifivault.com/verifyUser.php?UserID=" . $strUserName . "&VerifyKey=" . $rand_pass ."

You can change your details at any point by logging in to your account and navigating to the Add/Update User Details section.\n
If you have any queries in relation to your registration, please contact our Customer Service department at info@scifivault.com";


		mail($strEmailAddress, "ScifiVault.com Verification Process *" , $strMailText,
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\nBCC:webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
		     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());

		funcLogtoDebug ("AddUser2.php: " . $strUserName . " sent partial verification email");
		
		//now forward on to submitOrder...
		
		$strExpiry = time()+600;
		$value= funcEncrypt ($strUserName . "&" . $strExpiry);
		
		//echo "<meta http-equiv='refresh' content='0;url=/submitOrder2.php?strUserID=" . $strUserName. "&key=" . $value . "'>";
		echo "<meta http-equiv='refresh' content='0;url=/ChooseDelivery3.php?strUserID=" . $strUserName. "&key=" . $value . "'>";

	}
	else
	{
	//User Does exist so end
	 echo "<meta http-equiv='refresh' content='0;url=/ChooseDelivery2.php?UserExistsError=1'>";
	}





	//funcDebug ($strUserName);
	//funcLogtoDebug ("Authenticate.php: " . $strEmailAddress . " " . $strPassword1);
	funcLogtoDebug("AddUser2.php: " . $strEmailAddress . " " . funcEncrypt ($strPassword1));
	//funcDebug ($strPassword1);
	//funcDebug ($strMD5);

?>


</BODY>
</HTML>

