<?

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctions.php');

$basketCode = $_POST['ToDelete'];

funcDebug ("Basketcode: " . $basketCode);

//connect to server
$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
		or die ("Could not connect: " . mysql_error() );

//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");

$strGetBasket = "SELECT * FROM tblBasket WHERE PHPSessionID = '" . $basketCode . "'";
$strGetBasketResult = mysql_query ($strGetBasket) or die ("Query Failed: " . mysql_error());

funcDebug ("Deleting items in Basket");

while ($row = mysql_fetch_array($strGetBasketResult,MYSQL_ASSOC))
{
	funcDebug ("Deleting " . $basketCode . ", " . $row["Item"] );
	funcDeleteItem ($basketCode, $row["Item"], "0");

}

funcDebug ("Deleting Session entry");

$DeleteBasket = "DELETE FROM tblSession where PHPSessionID = '" . $basketCode . "'";
mysql_query ($DeleteBasket) or die ("Query Failed: " . mysql_error());


function funcDeleteItem ($strSessionID, $itemcode, $qty)
{
	//$qty = funcSanitize($_POST['qty']);
	//$itemcode = funcSanitize($_POST['item']);
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



	//is row locked?
	$strLockCheck = "SELECT ColumnLock FROM tblItem WHERE stockID = '" . $itemcode ."'";
	$strLockResult = mysql_query ($strLockCheck) or die ("Query Failed: " . mysql_error());
	
	while ($line = mysql_fetch_array($strLockResult, MYSQL_ASSOC))
	{
		if ($line["ColumnLock"] == 'YES')
		{
			echo "Item being edited, please try again";
			echo "<br><a href='index3.php'>Back to Shop</a>";
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
	$strStockQuery = "SELECT Qty FROM tblBasket where item = '" . $itemcode ."' and PHPSessionID = '" . $strSessionID . "'";
	$strStockResult = mysql_query ($strStockQuery) or die ("Query Failed:" . mysql_error());

	while ($line = mysql_fetch_array($strStockResult, MYSQL_ASSOC))
	{
	
			
		if ($line["Qty"] >= $qty)
		{
			//great we have some stock
			funcDebug ($itemcode . " in basket: " . $line["Qty"]);	
		
			$qty = $line["Qty"] - $qty;
		
			funcDebug ("Request to return " . $qty . " of " . $itemcode );
			
			//insert/update into tblBasket
			$strBasket = "SELECT * FROM tblItem where stockID = '" . $itemcode . "'";
			$strBasketResult = mysql_query ($strBasket) or die ("Basket Query Failed:" . mysql_error());
			
			$conNumberofRows = mysql_num_rows($strBasketResult);
			
			if ($conNumberofRows == 1)
			{
				//need to update the table
				$line2 = mysql_fetch_array ($strBasketResult, MYSQL_ASSOC);
				funcDebug ("Quantity of " . $itemcode ." in stock is " . $line2["NoOfItems"]);
				$strUpdatedBasketValue = $line2["NoOfItems"] + $qty;
				$strAddToBasket = "UPDATE tblItem SET NoOfItems = '" . $strUpdatedBasketValue . "' where stockID = '" . $itemcode . "'";
				mysql_query ($strAddToBasket) or die ("Update Basket Query Failed:" . mysql_error());
			}
			else
			{
				//catchall for invalid entries in basket. stops 
				//before making any changes in the main tblItems.
				echo "Invalid number of rows in stock database, please contact us";
				$strLockQuery = "UPDATE tblItem SET ColumnLock = '' where stockID = '" . $itemcode ."'";
				mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());			
				exit();
			}


			//update tblItems with new stock value
			$strUpdatedStockValue = $line["Qty"] - $qty;
			funcDebug ("Updated stock value: " . $strUpdatedStockValue);
			
			if ($strUpdatedStockValue == 0)
			{
			
				$strUpdateStockQuery = "DELETE FROM tblBasket where item = '" . $itemcode . "' and PHPSessionID = '" . $strSessionID . "'";
				mysql_query ($strUpdateStockQuery) or die ("Update Query Failed: " . mysql_error());
			}
			else
			{
				$strUpdateStockQuery = "UPDATE tblBasket SET qty = '" .$strUpdatedStockValue . "' WHERE item = '" . $itemcode ."' and PHPSessionID = '" . $strSessionID . "'";
				mysql_query ($strUpdateStockQuery) or die ("Update Query Failed: " . mysql_error());

			}
			

			$strLockQuery = "UPDATE tblItem SET ColumnLock = '' where stockID = '" . $itemcode ."'";
			mysql_query ($strLockQuery) or die ("ColumnLock to blank Query Failed: " . mysql_error());

		}
		else
		{
			//oh dear, no stock left
			echo "Not enough of that item in your basket";

			$strLockQuery = "UPDATE tblItem SET ColumnLock = '' where stockID = '" . $itemcode ."'";
			mysql_query ($strLockQuery) or die ("Query Failed: " . mysql_error());			
			
		}
	
	}

	//header('location: ' . $_SERVER['PHP_SELF']);
	//header('location: ' . $_POST['page']);

	echo "<meta http-equiv='refresh' content='0;url=/stock/DisplayBaskets.php'>";

}
?>
<HTML>


</HTML>
