<?

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctions.php');

$basketCode = $_GET['BasketID'];

//connect to database
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );

//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");


//query to get all items in basket
$strQuery = "SELECT t.item, c.name, t.qty, c.RRP, c.SaleRRP, c.ShortDescription, c.stockID
		FROM tblBasket t
		INNER JOIN tblItem c
		ON t.item = c.stockId
		WHERE t.PHPSessionID = '" . $basketCode . "'";

//execute query
$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

?>

<HTML>

	<HEAD>
		<TITLE>Welcome to SciFi Vault!</TITLE>

	</HEAD>

<table>

<tr>

	<td>qty</td><td>Name</td><td>QuickFind</td><td>Cost/Item</td><td>Cost</td>

</tr>

<?


//enumerate through each of the rows and display
while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
{

						if ($line["RRP"] == $line["SaleRRP"] or $line["SaleRRP"]==0.00)
						{
							$strPrice = $line["RRP"];
						}
						else
						{
							$strPrice = $line["SaleRRP"];
						}

	//display row.
	echo "<tr><td>" . $line["qty"] . "</td><td>" . $line["name"] . " " . $line["ShortDescription"] . "</td>
	<td>" . $line["stockID"] . "</td><td>" . sprintf ("%01.2f",$strPrice) ."</td><td>" . sprintf ("%01.2f",$strPrice * $line["qty"]) . "</td></tr>\n";

	//cumulative total
	$total = $total + ($line["RRP"] * $line["qty"]);


}

?>
</table>

<?
echo "\n<br> Total Spent = " . sprintf ("%01.2f",$total) ;

echo "<br><br><a href='/index3.php'>Back to Shop</a>";
?>
