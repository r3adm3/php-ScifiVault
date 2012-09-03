<?php

include ('includes/SharedFunctionsStrict.php');

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();


//connect to database server

		$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
				or die ("Could not connect: " . mysql_error() );

//change to the correct database

		mysql_select_db ("sfvault_store") or die ("Could not select database");

//run query to see if a session exists

		$strQuery = "SELECT * FROM tblSession where PHPSESSIONID = '" . session_id() .  "'";
		$strResult = mysql_query ($strQuery) or die ("Query Failed:" . mysql_error());

//if statement

		$strNoOfRows = mysql_num_rows ($strResult);

		if ( $strNoOfRows != 0 )
		{
			echo "\n<!-- UPDATE (" . $strNoOfRows . ") -->";
			//if query returns non zero, then update the timestamp
			$strNow = date ('Y-m-j h:i:s');
			$strQuery = "UPDATE tblSession SET TimeStmp = '" . $strNow . "' where PHPSESSIONID = '" .session_id(). "'";
			$strResult = mysql_query ($strQuery) or die ("Query Failed:" . mysql_error());
		}
		else
		{
			echo "\n<!-- INSERT -->";
			//if query returns zero rows, insert new row
			$strNow = date ('Y-m-j h:i:s');
			$strQuery = "INSERT INTO tblSession (PHPSESSIONID, TimeStmp) values ('" . session_id() . "', '" . $strNow . "')";
			$strResult = mysql_query ($strQuery) or die ("Query Failed:" . mysql_error());

		}
?>

<HTML>
	<HEAD>
		<TITLE>Welcome to SciFi Vault!</TITLE>

<link rel="stylesheet" href="stylesheets/mainstylesheet.css" type="text/css">
</HEAD>


<BODY bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<table  border="0" cellspacing="0" cellpadding="5" width="900" align="center">
  <tr>
    <td width="500"><a href="http://shop.scifivault.com/index3.php"><img src="images/scifi-small-best.jpg" width="403" height="62" border="0"></a>
    </td>
    <td align="right" valign="top" width="300">
      <div align="right">
        <script language=JavaScript>
<!--
/******************************************
   Today's Date           by Joe Barta
   http://www.pagetutor.com/todaysdate/
*******************************************/

Style = 12; //pick a style from below

/*------------------------------
Style 1: March 17, 2000
Style 2: Mar 17, 2000
Style 3: Saturday March 17, 2000
Style 4: Sat Mar 17, 2000
Style 5: Sat March 17, 2000
Style 6: 17 March 2000
Style 7: 17 Mar 2000
Style 8: 17 Mar 00
Style 9: 3/17/00
Style 10: 3-17-00
Style 11: Saturday March 17
Style 12: Saturday, 17 March 2000
--------------------------------*/

months = new Array();
months[1] = "January";  months[7] = "July";
months[2] = "February"; months[8] = "August";
months[3] = "March";    months[9] = "September";
months[4] = "April";    months[10] = "October";
months[5] = "May";      months[11] = "November";
months[6] = "June";     months[12] = "December";

months2 = new Array();
months2[1] = "Jan"; months2[7] = "Jul";
months2[2] = "Feb"; months2[8] = "Aug";
months2[3] = "Mar"; months2[9] = "Sep";
months2[4] = "Apr"; months2[10] = "Oct";
months2[5] = "May"; months2[11] = "Nov";
months2[6] = "Jun"; months2[12] = "Dec";

days = new Array();
days[1] = "Sunday";    days[5] = "Thursday";
days[2] = "Monday";    days[6] = "Friday";
days[3] = "Tuesday";   days[7] = "Saturday";
days[4] = "Wednesday";

days2 = new Array();
days2[1] = "Sun"; days2[5] = "Thu";
days2[2] = "Mon"; days2[6] = "Fri";
days2[3] = "Tue"; days2[7] = "Sat";
days2[4] = "Wed";

todaysdate = new Date();
date  = todaysdate.getDate();
day  = todaysdate.getDay() + 1;
month = todaysdate.getMonth() + 1;
yy = todaysdate.getYear();
year = (yy < 1000) ? yy + 1900 : yy;
year2 = 2000 - year; year2 = (year2 < 10) ? "0" + year2 : year2;

dateline = new Array();
dateline[1] = months[month] + " " + date + ", " + year;
dateline[2] = months2[month] + " " + date + ", " + year;
dateline[3] = days[day] + " " + months[month] + " " + date + ", " + year;
dateline[4] = days2[day] + " " + months2[month] + " " + date + ", " + year;
dateline[5] = days2[day] + " " + months[month] + " " + date + ", " + year;
dateline[6] = date + " " + months[month] + " " + year;
dateline[7] = date + " " + months2[month] + " " + year;
dateline[8] = date + " " + months2[month] + " " + year2;
dateline[9] = month + "/" + date + "/" + year2;
dateline[10] = month + "-" + date + "-" + year2;
dateline[11] = days[day] + " " + months[month] + " " + date;
dateline[12] = days[day] + ", " + date + " " + months[month] + " " + year;

document.write(dateline[Style]);
//-->
</script>
        <br>
      </div>
    </td>
  </tr>
</table>
<br>

<table  border="0" cellspacing="0" cellpadding="5" align="center" width="900">
  <tr>
    <td width="200" align="left" valign="top">
<table id="partial" width="200"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <td bgcolor="#002A54">
          <div align="center"><img src="images/buttons/CATAGORIES.gif" width="180" height="25"></div>
        </td>
        </tr>
        <tr>
          <td>
            <p>
            <table width="100%" border="0" cellpadding="5" bgcolor='#CCCCCC'>
              <tr>
                <td><font face="Verdana, Arial, Helvetica, sans-serif">
                  <?php

		/************************************************************************
		* connect to database
		*************************************************************************/
		$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
				or die ("Could not connect: " . mysql_error() );

		//change to correct database
		mysql_select_db ("sfvault_store") or die ("Could not select database");

		//run query to see if result is returned

		//$strQuery = "SELECT CategoryTag,CategoryName FROM tblCategory ORDER BY CategoryName";
		$strQuery = "SELECT DISTINCT c.image1 as Image, c.CategoryTag AS CategoryTag, c.CategoryName AS CategoryName,  (

		SELECT count( DISTINCT VersionTag )
		FROM tblItem
		WHERE SubjectTag = c.CategoryTag
		) AS num
		FROM tblCategory c
		INNER JOIN tblItem t ON t.SubjectTag = c.CategoryTag
		WHERE t.NoOfItems <>0
		ORDER BY CategoryName
";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

		echo "<CENTER>";
		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

			//construct menu here

			if  ($line["num"]==1)
			{
			echo "\t<a href='subCategory.php?sTag=" . $line["CategoryTag"] . "&vTag=ALL'><img src='" . $line["Image"] . "'></a><br>\n";
			}
			else
			{
			echo "\t<a href='Category.php?sTag=" . $line["CategoryTag"] . "'><img src='" . $line["Image"] . "'></a><br>\n";
			}




		}
		echo "</CENTER>";

		?>
                  </font></td>
              </tr>

            </table>
          </td>
        </tr>

      </table>
      <p>&nbsp;</p>

    </td>
    <td width="100%" align="center" valign="top"> 
      <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr> 
          <td> 
            <p align="center"><font size="4">Terms and Conditions<br>
              <font size="1">(What they make us say)</font></font></p>
            <p>By using our website, you agree to be bound by Sci-Fi Vault Ltd Terms 
              &amp; Conditions set out below. </p>
            <p><b>Contract for the Supply of Goods </b></p>
            <p>The display of goods on the Sci-Fi Vault Ltd site amounts to an invitation 
              to treat only and is not an offer to sell goods at any price indicated.</p>
            <p>No contract for the supply of goods will be deemed to exist between 
              you and Sci-Fi Vault Ltd unless, and until, an email is sent by 
              Sci-Fi Vault Ltd to you confirming that your order has been shipped. 
              This confirmation e-mail amounts to an acceptance by Sci-Fi Vault 
              Ltd of your offer to buy goods from Sci-Fi Vault Ltd and this acceptance 
              is effective regardless of whether or not you receive the e-mail.</p>
            <p>Sci-Fi Vault Ltd are free to withdraw from a prospective contract at any 
              time prior to acceptance. This also applies in the case of any error 
              or inaccuracy in respect of the goods, any description applied to 
              the goods, the availability of the goods or the order itself. Price 
              and availability information is subject to change without notice. 
              Site Information</p>
            <p>Sci-Fi Vault Ltd is providing this site and its contents on an 'as is' 
              basis and makes no representations or warranties of any kind with 
              respect to this site or its contents.</p>
            <p>Sci-Fi Vault Ltd disclaims all such representations and warranties, including 
              for example warranties of merchantability and fitness for a particular 
              purpose. In addition,</p>
            <p>Sci-Fi Vault Ltd does not represent or warrant that the information 
              accessible via this site is accurate, complete or current. </p>
            <p><b>Processing of orders</b></p>
            <p>Sci-Fi Vault works on a live database stock control system. All 
              Items displayed as available are instock. In the event of a mistake 
              or error in the database we will inform you as soon as possible. 
              We will keep you updated by E-mail as to the status of your order 
              (unless you ask us not to).</p>
            <p>Credit cards are processed by Paypal at the end of the order. Sci-Fi 
              Vault do not hold Credit/Debit card information of any type.</p>
            <p>Shipments outside the European Union (EU) may be subject to local 
              import charges and taxes, which are the responsibility of the purchaser. 
              Our standard Returns Policy applies to all purchases from Sci-Fi 
              Vault Ltd.</p>
            <p>Limitation of Liability Except as specifically stated on this site, 
              neither Sci-Fi Vault Ltd nor any of its directors, employees or other representatives 
              will be liable for damages arising out of or in connection with 
              the use of this site. This is a comprehensive limitation of liability 
              that applies to all damages of any kind, including (without limitation) 
              compensatory, direct, indirect or consequential damages, loss of 
              data, income or profit, loss of or damage to property and claims 
              of third parties.</p>
            <p><b>Illegal Acts </b></p>
            <p>It is a crime to use a false name and address or a known invalid/stolen 
              credit card to order. Anyone caught wilfully entering an erroneous 
              or fictitious order will be prosecuted to the fullest extent of 
              the law.</p>
            <p>We track the IP and transaction codes of every order placed on 
              Sci-Fi Vault Ltd to enable us and all legitimate crime prevention 
              and prosecution authorities to trace individual users engaging in 
              criminal activities on our website.</p>
            <p> <b>Governing Law </b></p>
            <p>All purchases from Sci-Fi Vault Ltd are subject to UK Law. Modification 
              of Terms Sci-Fi Vault Ltd reserves the right to modify these terms 
              at any time without prior notice. Any modification of these terms 
              will be deemed to be effective from the date and time of posting 
              on any of Sci-Fi Vaults websites.</p>
            <p align="center"><b>E&amp;OE</b></p>
          </td>
        </tr>
      </table>
      <br>
    </td>
    <td width="200" align="center" valign="top">
      <table width="200"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr>
          <td bgcolor="#002A54">
            <div align="center"><img src="images/buttons/LOGIN.gif" width="180" height="25"></div>
          </td>
        </tr>
        <tr>
          <td>
            <table width="200" border="0" cellpadding="5" bgcolor="#CCCCCC" id="partial">
              <tr>
                <td>
                  <?php

$strBin = hex2bin($_COOKIE["AUTH"]);
$strDecrypted = funcDecrypt ($strBin);
$strUserID = substr($strDecrypted,0,strpos($strDecrypted,"&"));

if ($strUserID == "")
{
	?>


                  <FORM action="AuthenticateUser.php" method="post">
                    <font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2">
                    Email:</font><br>
                    </b> <font size="2">
                    <input type='text' name='EmailAddress' size='26'>
                    </font></font> <font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><br>
                    <b> Password: </b> <br>
                    <input type='password' name='Password' size='26'>
                    </font></font>
                    <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      <input TYPE='image' SRC='images/buttons/SIGNBUTTON.gif' name='Sign In'>
                      <a href="register.php"><img src="images/buttons/REGBUTTON.gif" border="0"><br>
                      </a></font><a href="register.php"></a> <br>
                      <a href="password.php">Forgotten Password?</a>
                  </FORM>
	<?php

}
else
{

	//setcookie("AUTH", $value, time()+600, "/", "shop.scifivault.com", 0);  /* expire in 10 mins */

	echo " <div align='center'><font face='Verdana, Arial, Helvetica, sans-serif'>You are logged in as <p><B>" . $strUserID . "</B></font><p>
           <a href='/Logout.php'><img src='images/buttons/LOGBUTTON.gif' border='0'></a><a href='/UserOutstandingOrders.php?strUserID=" . $strUserID . "'><img src='images/buttons/MYACCBUTTON.gif' border='0'></a></font></font>";


}

?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
      </table>
      <br>
      <table width="200"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr>
          <td bgcolor="#002A54">
            <div align="center"><img src="images/buttons/SEARCH.gif" width="180" height="25"></div>
          </td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif"> </font>
            <table width="200" border="0" cellpadding="5" bgcolor="#CCCCCC" id="partial">
              <tr>
                <td bgcolor="#CCCCCC">
					<form action='search.php' method='post'>
						<input type='text' name='Search' size='26'>
						<p align="center">
                      <input TYPE='image' SRC='images/buttons/SEARCHBUTTON.gif' name='Search'>
                  </form>
				</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
      </table>
      <br>
      <table width="200"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr>
          <td bgcolor="#002A54">
            <div align="center"><img src="images/buttons/SHOP.gif" width="180" height="25"></div>
          </td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif"> </font>
            <table width="200" border="0" cellpadding="5" bgcolor="#CCCCCC" id="partial">
              <tr>
                <td bgcolor="#CCCCCC">
<div align="center">
                      <?

	//make initial connection to database
	//$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
	//		or die ("Could not connect: " . mysql_error() );

	mysql_select_db ("sfvault_store") or die ("Could not select database");

		$strTotal = '0.00';
		$strTotalqty = 0;
		echo "<table>\n";
		//query to get all items in basket
		$strQuery = "SELECT t.item, c.name, t.qty, c.RRP, c.SaleRRP, c.ShortDescription, c.stockID
				FROM tblBasket t
				INNER JOIN tblItem c
				ON t.item = c.stockId
				WHERE t.PHPSessionID = '" . session_id() . "'";

		//execute query
		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

		if (mysql_num_rows($strResult)==0)
		{

			echo " <tr><td><div align='center'><font face='Verdana, Arial, Helvetica, sans-serif'><p><B>You have no items in your basket</B></font><p></td></tr>";
			echo "</table>";
		}
		else
		{

					echo "<tr><td></td><td>Item</td><td align='center'>Qty</td><td>Price</td>";

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

						echo "\n\t<tr><td width='15' valign='center'><form action='removeFromBasket.php' method='post'><input type='hidden' name='altRemove' value='-'><input type='hidden' name='page' value='" . $_SERVER['REQUEST_URI']. "'><input type='hidden' name='removeitem' value='" . $line["stockID"] . "'><br><INPUT TYPE='image' SRC='images/buttons/trash.gif' ALT='Remove' name='remove' value='-'></form></td><td><a href='displayItem.php?Item=" .$line["stockID"] . "'>" . $line["name"] . "</a></td><td align='center'> " . $line["qty"] . "  </td><td align='right'> &pound;" . sprintf ("%01.2f",($line["qty"] * $strPrice)) . "</td></tr>\n";
						$strTotal = sprintf ("%01.2f", ($line["qty"] * $strPrice) + $strTotal);
						$strTotalqty = $strTotalqty + $line["qty"];
					}
					//echo "before ($strTotal)";

					//echo "after ($strTotal)";

				echo "<tr><td>&nbsp; </td><td>&nbsp; </td><td>&nbsp; </td></tr>";
				echo "<tr><td colspan='2'>Items:<td align='left'> " . $strTotalqty . " </td>\n" ;
				echo "<tr><td colspan='2'><b>Total: </b></td><td align='right'><b>&pound;$strTotal</b></td>\n";
				echo "</table>\n";
				echo "<p> <a href='Choose.php'><img src='images/buttons/CHECKOUTBUTTON.gif' border='0'></a>";
		}


	//print_r ($_SESSION['cart']);

	?>

                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
      </table>
      <br>
    </td>
  </tr>
</table>
<br>
<table width="900" border="0" align="center">
  <tr>
    <td>
      <div align="center">
        <!-- PayPal Logo -->
        <table border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td align="center"> </td>
          </tr>
          <tr>
            <td align="center"> <a href="#" onClick="javascript:window.open('https://www.paypal.com/uk/cgi-bin/webscr?cmd=xpt/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">
              <img  src="images/horizontal_solution_PP.gif" border="0" alt="Solution Graphics" width="350" height="78">
              </a> </td>
          </tr>
        </table>
        <!-- PayPal Logo -->
        <br>
        <a href="about.php">About Us</a> | <a href="terms.php">Terms &amp; Conditions</a>
        | <a href="faq.php">FAQ's</a><br>
        <br>
        Sci-Fi Vault Ltd Ltd &copy; 2006<br>
        www.scifivault.com
        <p>Version 1.0.0</p>
      </div>
    </td>
  </tr>
</table>
<p>&nbsp;</p>

</BODY>
</HTML>
