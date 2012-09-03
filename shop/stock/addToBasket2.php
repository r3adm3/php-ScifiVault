<?

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctions.php');

if (isset($_POST['Buy'])) {

	$qty = funcSanitize($_POST['qty']);
	$itemcode = funcSanitize($_POST['item']);
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

	//is row locked?
	$strLockCheck = "SELECT ColumnLock FROM tblItem WHERE stockID = '" . $itemcode ."'";
	$strLockResult = mysql_query ($strLockCheck) or die ("Query Failed: " . mysql_error());
	
	while ($line = mysql_fetch_array($strLockResult, MYSQL_ASSOC))
	{
		if ($line["ColumnLock"] == 'YES')
		{
			echo "Item being edited, please try again";
			exit();
			//possible retry, or forward on back to original page??
		}
		else
		{
			funcDebug ("Free to carry on");
		}
	}
	
	//set row lock on in tblItem
	$strLockQuery = "UPDATE tblItem SET ColumnLock = 'YES' WHERE stockID = '" . $itemcode ."'";
	mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());

	//Lets see how much stock for this item there is
	$strStockQuery = "SELECT NoOfItems FROM tblItem where stockID = '" . $itemcode ."'";
	$strStockResult = mysql_query ($strStockQuery) or die ("Query Failed:" . mysql_error());

	while ($line = mysql_fetch_array($strStockResult, MYSQL_ASSOC))
	{
	
			
		if ($line["NoOfItems"] > $qty)
		{
			//great we have some stock
			funcDebug ($itemcode . " in stock: " . $line["NoOfItems"]);	
		
			funcDebug ("Request for " . $qty . " of " . $itemcode );
			
			//insert/update into tblBasket
			$strBasket = "SELECT * FROM tblBasket where item = '" . $itemcode . "'" and PHPSessionID = '" . session_id() . "'";
			$strBasketResult = mysql_query ($strBasket) or die ("Basket Query Failed:" . mysql_error());
			
			$conNumberofRows = mysql_num_rows($strBasketResult)
			
			if ($conNumberofRows == 1)
			{
				//need to update the table
				$line2 = mysql_fetch_array ($strBasketResult, MYSQL_ASSOC));
				funcDebug ("Quantity of " . $itemcode ." in basket is " . $line2["Qty"]);
				$strUpdatedBasketValue = $line2["Qty"] + $qty;
				$strAddToBasket = "UPDATE tblBasket SET qty = '" . $strUpdatedBasketValue . "' where item = '" . $itemcode . "'" and PHPSessionID = '" . session_id() . "'";
				mysql_query ($strAddToBasket) or die ("Update Basket Query Failed:" . mysql_error());
			}
			elseif ($conNumberofRows == 0)
			{
				//need to insert a row into the table
				$strAddToBasket = "INSERT tblBasket Values ('". session_id() ."', '" . $itemcode . "', '" . $qty . "')";
				mysql_query ($strAddToBasket) or die ("Add to Basket Query Failed:" . mysql_error());
				
			}
			else
			{
				//catchall for invalid entries in basket. stops 
				//before making any changes in the main tblItems.
				echo "Invalid number of rows in your basket, please contact us";
				$strLockQuery = "UPDATE tblItem SET ColumnLock = ''";
				mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());			
				exit();
			}


			//update tblItems with new stock value
			$strUpdatedStockValue = $line["NoOfItems"] - $qty;
			funcDebug ("Updated stock value: " . $strUpdateStockValue);
			
			$strUpdateStockQuery = "UPDATE tblItem SET NoOfItems = '" .$strUpdatedStockValue . "' WHERE stockID = '" . $itemcode ."'";
			mysql_query ($strUpdateStockQuery) or die ("Update Query Failed: " . mysql_error());

			$strLockQuery = "UPDATE tblItem SET ColumnLock = ''";
			mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());

		}
		else
		{
			//oh dear, no stock left
			echo "Not enough stock I'm afraid for that item";

			$strLockQuery = "UPDATE tblItem SET ColumnLock = ''";
			mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());			
			
		}
	
	}

	//header('location: ' . $_SERVER['PHP_SELF']);
	//header('location: ' . $_POST['page']);
	exit();
}
?>
<HTML>

<br><a href="index3.php">index3.php</a>
<br><a href="session.php">session.php</a>

</HTML>
