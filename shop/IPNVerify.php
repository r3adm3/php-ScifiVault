
<?php

	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );


	mysql_select_db ("sfvault_store") or die ("Could not select database");

	funcLog ("IPNVerify.php fired");

	//------------------------------------------------
	// Read post from PayPal system and create reply
	// starting with: 'cmd=_notify-validate'...
	// then repeating all values sent - VALIDATION.
	//------------------------------------------------

	$req = 'cmd=_notify-validate';

	foreach ($_POST as $key => $value)
	{
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}

	// assign posted variables to local variables
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];


	//--------------------------------------------
	// Create message to post back to PayPal...
	// Open a socket to the PayPal server...
	//--------------------------------------------
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";

	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
	$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

	funcLog ($txn_id . ": Opening a socket");

	//----------------------------------------------------------------------
	// Check HTTP connection made to PayPal OK, If not, print an error msg
	//----------------------------------------------------------------------
	if (!$fp)
	{
		echo "$errstr ($errno)";

		funcLog ("Http connection errored");

		$res = "FAILED";
	}
	//--------------------------------------------------------
	// If connected OK, write the posted values back, then...
	//--------------------------------------------------------
	else
	{
		funcLog ($txn_id . ": Apparently connected ok");

		fputs ($fp, $header . $req);
		//-------------------------------------------
		// ...read the results of the verification...
		// If VERIFIED = continue to process the TX...
		//-------------------------------------------
		while (!feof($fp))
		{
			$res = fgets ($fp, 1024);

			if (strcmp ($res, "VERIFIED") == 0)
			{

				funcLog ($txn_id . ": TX: " . $res );

				funcLog ($txn_id . ": Our ID: " . $item_number . ", " .$item_name );

				$strNow =  date ('Y-m-j H:i:s');

				//now update tbl_Orders
				$strUpdateQuery = "UPDATE tbl_Orders SET status = 'PAID', IPNDateTime = '" . $strNow . "', PaypalTXN = '" . $txn_id . "' where OrderNo = '" . $item_name . "'";
				$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Update Failed");

			}
			else
			{
				funcLog ($txn_id . ": Some other TX Status: " . $res);

				$strNow =  date ('Y-m-j H:i:s');

				$strUpdateQuery = "UPDATE tbl_Orders SET status = 'PROBLEM', IPNDateTime = '" . $strNow . "', PaypalTXN = '" . $txn_id . "' where OrderNo = '" . $item_name . "'";
				$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Update Failed");

			}


		}

	}

	funcLog ($txn_id . ": The End....");

function funcLog ($strmsg)
{

	$strNow = date ('Y-m-j H:i:s');

	$strLogInsert = "INSERT INTO tblLog Values ('" . $strNow . "','DEV', '" . $strmsg . "')";

	$strInsertLogEntry = mysql_query ($strLogInsert) or die ("Log Entry Failed");

}

?>
