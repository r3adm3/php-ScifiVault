
<HTML>


<HEAD></HEAD>

<?php

	include ('includes/SharedFunctions.php');

	$strUserName = funcSanitize($_GET["UserID"]);
	$strVerifyCode = funcSanitize($_GET["VerifyKey"]);

	funcDebug ($strUserName);
	funcDebug ($strVerifyCode);

	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");

	$strUserQuery = "SELECT UserID FROM tbl_UserLogin where UserID = '" . $strUserName ."'";
	$strUserResult = mysql_query ($strUserQuery) or die ("Query Failed:" . mysql_error());

	//User Exists, so Error gracefully, then forward the user on
	$conNumberofRows = mysql_num_rows($strUserResult);
	if ($conNumberofRows == 1)

	{
		//here's our user
		$strNow = date ('Y-m-j h:i:s');

		//User Doesn't exist so carry on Adding
		$strAddUserQuery = "UPDATE tbl_UserLogin SET UserVerified='1' where UserID='" . $strUserName. "'";
		$strAddUserResult = mysql_query ($strAddUserQuery) or die ("Query Failed:" . mysql_error());

		echo "

<table  border='0' cellspacing='0' cellpadding='5' width='900' align='center'>
  <tr>
    <td width='500'><a href='http://shop.scifivault.com/index3.php'><img src='images/scifi-small-best.jpg' width='403' height='62' border='0'></a>

    </td>
    <td align='right' valign='top' width='300'>


    </td></tr>

<tr><td>
<br> <font face='verdana'>Thankyou! You've succesfully verified.

<p>Feel free to sign on and shop.  Click on the link below to hurry things along.
<br><br><a href='index3.php'>Back to Shop</a></font></td><td></td></tr>

</table>


		";
		funcLogToDebug ("VerifyUser.php: " . $strUserName . " verified successfully");
		//echo "<meta http-equiv='refresh' content='10;url=/index3.php'>";


	}
	else
	{
		//we've got more than 1 user with the same user ID in the db (Shouldn't be possible)
		//or no user with that user name

		echo "Error! Please contact scifivault.com with details of your UserId";
		funcLogToDebug ("VerifyUser.php: " . $strUserName . " errored.");
		echo "<A href='index3.php'>Back to shop</a>";
	}


?>

</HTML>
