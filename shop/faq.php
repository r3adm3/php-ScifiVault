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
            <p align="center"><b><font size="5">F.A.Q.</font></b></p>
            <p><a href="#Registration">Registration and Your Accout</a></p>
            <p><a href="#PreOrders">Pre-Orders</a><br>
              <br>
              <a href="#Whatformofpaymentdoyouaccept">What form of payment do 
              you accept?</a><br>
              <br>
              <a href="#Whatformofpaymentdoyouaccept">Is it safe to use my credit/debit 
              card?</a><br>
              <br>
              <a href="#Doyouchargeforpostageandpackaging">Do you charge for postage 
              and packaging?</a></p>
            <p><a href="#PreOrders">Pre-Orders and how they work</a><br>
              <br>
              <a href="#Doyouchargeforpostageandpackaging">Do you accept international 
              orders?</a><br>
              <br>
              <a href="#Whatisyourpolicyonreturneditems">What is your policy on 
              returned items?</a><br>
              <br>
              <a href="#Willmypersonaldetailsremainprivateonyoursite">Will my 
              personal details remain private on your site?</a><br>
              <br>
              <a href="#HowcanIcancelmyorder">How can I cancel my order?</a><br>
              <br>
              <a href="#Clothingsizes">Clothing sizes</a><br>
              <br>
              <a href="#CollectableItems">Collectable Items</a><br>
              <br>
              <a href="#Promotions">Promotions</a><br>
              <br>
            </p>
            <hr>
            <p><b>Registration and Your Account</b><a name="Registration"></a><br>
            </p>
            <p>To order from Sci-Fi Vault you need to be registered. If it is 
              your first time using the site you will be registered as you progress 
              through the checkout.</p>
            <p>Your e-mail becomes your login ID and we will send you an e-mail 
              of your password which you can change.</p>
            <p>Registration enables you to see the progress of your current orders 
              and all your previous orders.</p>
            <p>To register first you can click on the register button and fill 
              out your contact details. </p>
            <p>If you are having difficulty in registering or ordering please 
              contact us at <a href="mailto:info@scifivault.com"><b>info@scifivault.com</b></a>.</p>
            <hr>
            <p><b>Pre-Orders</b><a name="PreOrders"></a><br>
            </p>
            <p> To Pre-Order from Sci-Fi Vault you'll need to register so you 
              can track your pre-orders.</p>
            <hr>
            <p><b>What form of payment do you accept?</b><a name="Whatformofpaymentdoyouaccept"></a><br>
            </p>
            <p> Sci-Fi Vault Ltd accepts credit and debit card payments through 
              PayPal </p>
            <p>Currently Paypal accept Visa, Mastercard, Delta, Switch, Amex, 
              Solo, Electron and Paypal. </p>
            <hr>
            <p><b>Is it safe to use my credit/debit card?</b><a name="Whatformofpaymentdoyouaccept"></a><br>
            </p>
            <p>Yes. All credit card information is processed by Paypal and any 
              personal details are handled with the utmost security and will never 
              be released to any other organisation.</p>
            <hr>
            <p><b>Do you charge for postage and packaging?</b><a name="Doyouchargeforpostageandpackaging"></a><br>
              <br>
              Postage and packaging are calculated on the total weight of the 
              item and where in the world it is being sent. </p>
            <p>This calculation is made when you are at the final checkout stage 
              and requires you to register with us as your address is used to 
              calculate delivary costs.</p>
            <hr>
            <p><b>Pre-Orders and how they work</b><a name="PreOrders"></a><br>
            </p>
            <p>Pre-Order are for items that we expect to be in stock soon. </p>
            <p>To pre-order an item you have to be registered. When you sign in 
              and go to the item to pre-order your e-mail is already filled in. 
              Enter the Qty that you would like and any comments that you would 
              like to add.</p>
            <p>When you submit your Pre-Order the item will be added to your Pre-Order 
              list. You can view this through your account page. You can cancel 
              the Pre-Order item any time you want by clicking cancel.</p>
            <p>When the item come into stock we will send you a PayPal invoice 
              for the quantity of items you have Pre-Ordered. </p>
            <p><i><b>You have upto 3 days to authorise the payment before we cancel 
              the invoice (depending on demand for the item).</b> </i></p>
            <p>If you do not wish to proceed with the pre-order when you recieve 
              the invoice please send us an e-mail to <a href="mailto:cancellations@scifivault.com"><b>cancellations@scifivault.com</b></a>. 
            </p>
            <hr>
            <p><b>Do you accept international orders?</b><a name="Doyouchargeforpostageandpackaging"></a><br>
              <br>
              Yes, we ship to all countries. When you register the country you 
              select will be used to calculate shipping costs when you order.</p>
            <hr>
            <p><b>What is your policy on returned items?</b><a name="Whatisyourpolicyonreturneditems"></a><br>
              <br>
              Our policy is to take anything back for whatever reason as long 
              as it is returned unopened with all parts and in the same condition 
              as when shipped, and is in a re-sellable condition.<br>
              <br>
              If you wish to return an item that has been delivered to you, you 
              must do this within 7 days of recieveing the item. E-mail at <a href="mailto:returns@scifivault.com"><b>returns@scifivault.com</b></a> 
              us explaining your reason for returning this item and include the 
              invoice number.</p>
            <p>We will then issue you with a returns authorisation number, which 
              you should write on the invoice. Enclose the invoice with your returns 
              package. This will ensure that your return is dealt with as quickly 
              as possible.</p>
            <p>Goods must be returned via the same postage method they were shipped. 
              Sci-Fi Vault will not refund used or otherwise spoiled goods. The 
              customer must pay for the return postage and obtain proof of posting. 
            </p>
            <hr>
            <p><b>How can I cancel my order?</b><a name="HowcanIcancelmyorder"></a><br>
              <br>
              You can cancel your order at any time before shipping by e-mail 
              us at <a href="mailto:cancellations@scifivault.com"><b>cancellations@scifivault.com</b></a>. 
              Please note that once orders have been shipped you cannot cancel 
              the order immediatly as it's already on it's way. Once the item 
              has been shipped you have 7 days from recieveing the order to cancel 
              it.</p>
            <p>Please e-mail us at <a href="mailto:cancellations@scifivault.com"><b>cancellations@scifivault.com</b></a> 
              if the item has already been shipped and you wish to return it. 
              After we recieve the item back we will refund your money. Goods 
              must be returned in the same mint condition they were dispatched 
              in, and be in a re-sellable condition</p>
            <p>See more on our <a href="#Whatisyourpolicyonreturneditems">returns 
              policy.</a></p>
            <hr>
            <p><b>Will my personal details remain private on your site?</b><a name="Willmypersonaldetailsremainprivateonyoursite"></a><br>
            </p>
            <p>Sci-Fi Vault Ltd are committed to protecting your privacy. We will 
              only use the information that we collect about you lawfully (in 
              accordance with the Data Protection Act 1998) and according to the 
              Which? Web Trader Code of Practice. We collect information about 
              you to process your order and to provide you with the best possible 
              service in the future.</p>
            <p>We do not send unsolicited mail and give you the opportunity to 
              refuse marketing email from us.</p>
            <hr>
            <p><b>Information we need?</b><br>
              <br>
              For us to process your order, we need to know your name, email address, 
              and delivery address . We will never collect sensitive information 
              about you without your explicit consent. If we intend to transfer 
              your information outside the EEA (European Economic Area) we will 
              always obtain your consent first. The information we hold will be 
              accurate and up to date. You can check the information that we hold 
              about you by emailing us at service. If you find any inaccuracies 
              we will delete or correct it promptly.</p>
            <p>If you have any questions/comments about privacy, you should email 
              us.</p>
            <hr>
            <p><b>Data Protection</b><br>
              <br>
              The Data Protection Act requires us, to be open about our holding 
              and use of personal data. It also entitles individuals to find out 
              from us what personal data is held about them on computer, to have 
              that information corrected or erased if it is inaccurate, and to 
              claim compensation if they can prove they have suffered damage from 
              an inaccuracy or breach of security.</p>
            <p>For further details about the Data Protection Act visit: <a href="http://www.direct.gov.uk/" target="_blank">http://www.direct.gov.uk/</a></p>
            <hr>
            <p><b>Clothing sizes</b><a name="Clothingsizes"></a><br>
              <br>
              The following is a rough guideline.</p>
            <p>Men's sizes: small= 36in chest, medium= 38in chest, large= 40in 
              chest, Extra Large 42/ 44in chest.</p>
            <p>Ladies sizes: small= size 10, medium=size 12, large= size 14/16.</p>
            <p>We do not refund money on clothing, however we will exchange the 
              item if the wrong size has been ordered. Please note that any further 
              postage incurred has to be paid for by the customer.</p>
            <hr>
            <p><b>Collectable Items</b><a name="CollectableItems"></a><br>
              <br>
              Please note that some items on the site are rare and either 'Discontinued' 
              or 'Sold as a Collectable', we cannot guarantee that the item is 
              in 100% working order.</p>
            <p>i.e. the display battery's in some collectable electronic items 
              may have stopped working. These battery are normally replaceable. 
            </p>
            <hr>
            <p><b>Promotions</b><a name="Promotions"></a><br>
              <br>
              Disclaimer : No more than one special offer or discount shall apply 
              to any title ordered through the Sci-Fi Vault Ltd site. If for any 
              reason a title appears in more than one promotion we will automatically 
              apply the best available special offer or discount to that title.</p>
            <hr>
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
        Sci-Fi Vault Ltd &copy; 2006<br>
        www.scifivault.com
        <p>Version 1.0.0</p>
      </div>
    </td>
  </tr>
</table>
<p>&nbsp;</p>

</BODY>
</HTML>
