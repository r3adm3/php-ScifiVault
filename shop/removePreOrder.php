<?

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctionsStrict.php');

if (isset($_POST['remove']) or isset($_POST['altRemove'])) {

	$itemcode = funcSanitize($_POST['removeitem']);
	$emailaddress = funcSanitize($_POST['emailaddress']);
	$strBool = 0;
	$counter = 0;

	funcDeleteItem ($itemcode, $emailaddress);
}

function funcDeleteItem ( $itemcode, $emailaddress)
{

	//connect to server
	$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
			or die ("Could not connect: " . mysql_error() );

	//change to correct database
	mysql_select_db ("sfvault_store") or die ("Could not select database");

	//$qty = "1";
	//$itemcode = funcSanitize($_POST['removeitem']);
	$strBool = 0;
	$counter = 0;

	$strUpdateStockQuery = "DELETE FROM tbl_PreOrder where stockID = '" . $itemcode . "' and emailaddress = '" . $emailaddress . "'";
	mysql_query ($strUpdateStockQuery) or die ("Update Query Failed: " . mysql_error());

	funcLogToDebug ("RemovePreOrder.php: PreOrder for " . $itemcode . " by " . $emailaddress . "was removed.");

	//header('location: ' . $_SERVER['PHP_SELF']);
	//header('location: ' . $_POST['page']);

	//echo $_POST['page'];
	echo "<meta http-equiv='refresh' content='0;url=" . $_POST['page'] . "'>";

}



?>
<HTML>

</HTML>
