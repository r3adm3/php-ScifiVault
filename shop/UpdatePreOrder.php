<?

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctions.php');


	$qty = funcSanitize($_POST['preorderqty']);
	$strNow = date ('Y-m-j h:i:s');
	$itemcode = funcSanitize($_POST['stockID']);
	$email = funcSanitize($_POST['email']);
	$comments = funcSanitize($_POST['Comments']);
	$strBool = 0;
	$counter = 0;

	//additional check to make sure $qty is a numeric
	if (ereg ("[0-9]+", $qty))
	{
		funcDebug ("Quantity string is numeric");
	}
	else
	{

		echo "Invalid Input, stop trying to put non-numerics in the quantity field";
		exit();
	}

	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");




	//check stockID is really at -3

	$strStockQry = "SELECT stockID, NoOfItems from tblItem where stockID = '" . $itemcode . "' and NoOfItems = '-3'";

	$strStockResult = mysql_query($strStockQry) or die ("Query Failed :" . mysql_error());

	$conNumberofRows = mysql_num_rows($strStockResult);

	if ($conNumberofRows == "1")
	{

		//verify email is in our database

		$strEmailQry = "SELECT emailAddress from tbl_UserLogin where emailAddress = '" . $email . "'";

		$strEmailResult = mysql_query($strEmailQry) or die ("Query Failed :" . mysql_error());

		$conNumberofRows2 = mysql_num_rows($strEmailResult);

		if ($conNumberofRows2 == "1")
		{

			//add entry to tbl_PreOrder
			$strInsertQry = "INSERT INTO tbl_PreOrder values ('" . $email . "', '" . $qty . "', '" . $comments . "', '" . $strNow . "','" . $itemcode ."','')";

			$strInsert = mysql_query($strInsertQry) or die ("Query Failed :" . mysql_error());

			funcLogToDebug ("UpdatePreOrder.php: Updated database");

		}
		else
		{funcLogToDebug ("UpdatePreOrder.php: email address does not exist in db - shouldn\'t happen");}
	}
	else
	{echo " Error! More than one piece of this stock in the right state!";
	funcLogToDebug ("UpdatePreOrder.php: More than one piece of stock in the right state");}


	//header('location: ' . $_SERVER['PHP_SELF']);
	//header('location: ' . $_POST['page']);
	echo "<meta http-equiv='refresh' content='0;url=/thanks.htm'>";
	exit();
?>
<HTML>

<br><a href="index3.php">index3.php</a>
<br><a href="session.php">session.php</a>

</HTML>
