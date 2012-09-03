<?php

//expires cookies after 1/2 hour
$sessionExpire = 60*30;

session_set_cookie_params($sessionExpire);

//start new session
session_start();
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = array();

include ('includes/SharedFunctions.php');

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

		// get the tags
		//$strCTag = funcSanitize($_GET['cTag']);
		//$strVTag = funcSanitize($_GET['vTag']);
		$strSTag = funcSanitize($_GET['sTag']);
		$strPTag = funcSanitize($_GET['p']);


?>

<!-- I'm expecting a URL like this: http://blah/Category.php?sTag=XX-->

<HTML>
	<HEAD>
		<TITLE>Sci-Fi Vault</TITLE>

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
      <p><a href="http://shop.scifivault.com/subCategory.php?sTag=WOW&vTag=ALL"><img src="images/WOFWARbanner.jpg" width="200" height="100" border="0"></a><a href="http://shop.scifivault.com/subCategory.php?sTag=DW&vTag=ALL"><img src="images/DRWHObanner.jpg" width="200" height="100" border="0"></a></p>
    </td>
    <td width="100%" align="center" valign="top">
      <p>
        <?php

//Title stuff. **************************************************************************************
		$strQueryTitle = "SELECT * FROM tbl_Synopsis where colCategory='" . $strSTag . "' and colSubCategory = '" . $strVTag . "'";

		$strResultTitle = mysql_query($strQueryTitle) or die ("Query Failed :" . mysql_error());

		while ($lineTitle = mysql_fetch_array($strResultTitle, MYSQL_ASSOC))
		{


			echo "\n<H1>" . $lineTitle["colTitle"] . "</H1>";


		}

//****************************************************************************************************

	if ($strVTag == "ALL") {} else {

	$strQuery = "SELECT distinct Version, VersionTag FROM `tblItem` where SubjectTag='" . $strSTag. "' order by VersionTag";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


		//echo "|";

		while ($line2 = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{

			echo "   <a href='subCategory.php?sTag=" . $strSTag . "&vTag=" . $line2["VersionTag"]. "'><img src='/images/buttons/" . $line2["VersionTag"] . ".gif' border=0></a> ";


			// THis bit here was to do with autoforwarding to the subCategory page.

			//	if (mysql_num_rows($strResult) == 1)
			//	{
			//			echo "<meta http-equiv='refresh' content='0;url=/subCategory.php?sTag=" . $strSTag . "&vTag=" . $line2["VersionTag"] . "'>";
			//
			//	}

		}
		echo " \n<br><br>\n";
	}
//Description stuff.  **************************************************************************************
		$strQueryDesc = "SELECT * FROM tbl_Synopsis where colCategory='" . $strSTag . "' and colSubCategory='" . $strVTag . "'";

		$strResultDesc = mysql_query($strQueryDesc) or die ("Query Failed :" . mysql_error());

		while ($lineDesc = mysql_fetch_array($strResultDesc, MYSQL_ASSOC))
		{


			echo "\n" . $lineDesc["colDescription"] . "<BR><BR>";


		}
//****************************************************************************************************


?>
      </p>
      <table width="100%" height="25" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr>
          <td width="8" height="25"><img src="images/buttons/curveleft.gif" width="8" height="25" align="top">
            <div align="center"></div>
          </td>
          <td bgcolor="#002A54">
            <div align="center"><img src="images/buttons/feature.gif" width="129" height="25" align="top"></div>
          </td>
          <td width="8" height="25"><img src="images/buttons/curveright.gif" width="8" height="25" align="top"></td>
        </tr>
      </table>
      <table id="partial" width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#002A54">
        <tr>
          <td>
            <table border="0" cellpadding="0" align="center">
              <tr>
                <!--<td>-->
                <?php










		mysql_select_db ("sfvault_store") or die ("Could not select database");

		//$strQuery = "SELECT stockID FROM tblItem where DisplayonFrontPage = '1' and NoOfItems <> '0'";

		//$strQuery = "SELECT stockID FROM tblItem where DisplayonFrontPage = '1' and NoOfItems >= 0";

		$strQuery = "SELECT stockID FROM tblItem where SubjectTag='" . $strSTag . "' and DisplayonSubCatPage='1' and NoOfItems>'0' ORDER BY RAND() LIMIT 3";

		$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());


		//if (count ($arrFrontStock)==0)
		
		if (mysql_num_rows($strResult)==0)
		{

				funcDebug ("Entered IF");

				$strQuery = "SELECT stockID FROM tblItem where SubjectTag='" . $strSTag . "' and NoOfItems>'0' LIMIT 3";

				$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());



		}


		while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
		{
			$arrFrontStock[] = $line["stockID"];
		}






		$numElements = count ($arrFrontStock)+1;



		for ($counter=1; $counter < $numElements; $counter++)
		{



		mysql_select_db ("sfvault_store") or die ("Could not select database");

			$strQuery = "SELECT stockID, smallPicture, Name, ShortDescription, NoOfItems, RRP, SaleRRP FROM tblItem where stockID ='" . $arrFrontStock[$counter-1] . "'";

			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());







			while ($line2 = mysql_fetch_array($strResult, MYSQL_ASSOC))
			{



				if ($counter %3 <> 0) {
				echo "\n <td><!-- Counter has a remainder ($counter) -->

				<table cellpadding='5' cellspacing='5' bgcolor='#FFFFFF'>
				<tr valign='top'>

				<td height='170' width='150'>
				<b><center><a href='displayItem.php?Item=". $line2["stockID"] . "'>
				<img src='" . $line2 ["smallPicture"] . "' border='0' height='90'>
				<p>" . $line2["Name"] . "</a></b>
				<br><h2>";

				if ($line2["RRP"] == $line2["SaleRRP"] or $line2["SaleRRP"]==0.00)
				{
							echo " &pound;" . $line2["RRP"];
				}
				else
				{
					//Item is for sale...
					echo "<del><font size ='-2' color=red>&pound;" . $line2["RRP"] . "</font></del> &pound;" . $line2["SaleRRP"];

				}



				echo "</h2></center></td>

				</tr>

				</table></td>";
				}
				else
				{
				echo "\n<td>
				<!-- Counter can be divided by three ($counter) -->

				<table cellpadding='5' cellspacing='5' bgcolor='#FFFFFF'>
				<tr valign='top'>

				<td height='170' width='150'>
				<b><center><a href='displayItem.php?Item=". $line2["stockID"] . "'>
				<img src='" . $line2 ["smallPicture"] . "' border='0' height='90'>
				<p>" . $line2["Name"] . "</a></b>
				<br><h2>";

				if ($line2["RRP"] == $line2["SaleRRP"] or $line2["SaleRRP"]==0.00)
				{
							echo " &pound;" . $line2["RRP"];
				}
				else
				{
					//Item is for sale...
					echo "<del><font size ='-2' color=red>&pound;" . $line2["RRP"] . "</font></del> &pound;" . $line2["SaleRRP"];

				}



				echo "</h2></center></td>

				</tr>


				</table></td></tr><tr>";
				}


				//if ($counter %3 == 0) {echo "</td></tr>";} else {echo "</td>";}

			}


		}



?>
                <!--</td>-->
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <p><?


      //break up the results sets into a number of pages ***************************************************************

	  		$strNumberQuery = "select count(*) as ItemCount from tblItem where SubjectTag='" . $strSTag . "' and NoOfItems <> 0";

	  		$strNumberResult = mysql_query($strNumberQuery) or die ("Query Failed: " . mysql_error());

	  		while ($lineRes = mysql_fetch_array($strNumberResult,MYSQL_ASSOC))
	  		{

	  			$strTotalItems = $lineRes["ItemCount"];

	  		}

	  		$strPages = ceil ($strTotalItems / 5);

	  		if ($strPages <> 0)
	  		{

	  			if ($strPTag <> 0)
	  			{$strPrevious = $strPTag - 1;
	  			echo "<a href='Category.php?sTag=" . $strSTag . "&p=" . $strPrevious  . "'> &lt;&lt; Prev</a> ";}


	  			for ($counter=0;$counter<$strPages;$counter+=1)
	  			{

	  				$displayCounter = $counter + 1;


	  				echo " | ";

	  				if ($strPTag == $counter)
	  				{echo "<b><font size=+1>";}

	  				echo "<a href='Category.php?sTag=" . $strSTag . "&p=" . $counter . "'>" . $displayCounter . "</a>" ;

	  				if ($strPTag == $counter)
	  				{echo "</font></b>";}
	  			}

	  			echo " | ";

	  			if ($strPTag <> $strPages - 1)
	  			{$strNext = $strPTag + 1;
	  			echo "<a href='Category.php?sTag=" . $strSTag . "&p=" . $strNext  . "'> Next &gt;&gt; </a>";}


	  		}

	  //end of break up the results sets into a number of pages ***************************************************************

	  		$strQueryDisp = "SELECT stockID, smallPicture, Name, ShortDescription, NoOfItems, RRP, SaleRRP FROM tblItem where SubjectTag='" . $strSTag . "' and NoOfItems <> -1 order by Name LIMIT " . $strPTag * 5 . ", 5";

	  		funcDebug ($strQueryDisp);

	  		$strResultDisp = mysql_query($strQueryDisp) or die ("Query Failed :" . mysql_error());
	  		echo "<TABLE width='100%' border='0'>\n";



	  		while ($lineDisp = mysql_fetch_array($strResultDisp, MYSQL_ASSOC))
	  		{

	  			echo "\t<TR width='100%' valign='center'>    <TD width='50'> <a href='displayItem.php?Item=" . $lineDisp["stockID"] . "'><img src='". $lineDisp["smallPicture"] . "' border='0'></a> </TD>"
	  				.	"\n<TD width='100%'> <a href='displayItem.php?Item=" . $lineDisp["stockID"] . "'>" . $lineDisp["Name"] . "</a> </TD>"
	  				.	"\n<TD width='100'> ";

	  				if ($lineDisp["RRP"] == $lineDisp["SaleRRP"] or $lineDisp["SaleRRP"]==0.00)
	  				{
	  							echo "&pound;" . $lineDisp["RRP"];
	  				}
	  				else
	  				{
	  					//Item is for sale...
	  					echo "<del><font size ='-2' color=red>£" . $lineDisp["RRP"] . "</font></del> &pound;" . $lineDisp["SaleRRP"];

	  				}



	  				/*echo " </TD>"
	  				.	"\n<TD width='60'>
	  				<form action='addToBasket2.php' method='post'>  <br>
	  				<input TYPE='image' SRC='images/buttons/BUYBUTTON.gif' name='Buy'>
	  				<input type='hidden' name='altBuy' value='Buy'>
	  				<input type='hidden' name='qty' value='1'>
	  				<input type='hidden' name='item' value='". $lineDisp["stockID"] ."'>
	  				<input type='hidden' name='page' value='" . $_SERVER['REQUEST_URI']. "'></form></TD>"
	  				. "</TR>\n";
	  				*/
				if ($lineDisp["NoOfItems"] > 0)
				{
				echo "</td><td valign='center'><form action='addToBasket2.php' method='post'>
                <input type='hidden' name='qty' value='1'>
                <input TYPE='image' SRC='images/buttons/BUYBUTTON.gif' name='Buy' value='Buy'>
                <input type='hidden' name='altBuy' value='Buy'>
                <!--<input type='submit' name='Buy' value='Buy'> -->
                <input type='hidden' name='item' value='". $lineDisp["stockID"] ."'>
                <input type='hidden' name='page' value= '" . $_SERVER['REQUEST_URI'] . "?Item=" . $lineDisp["stockID"] . "'>
                </form></td></tr>";
				}
				else
				{
				  echo "</td><td valign='center'><a href='displayItem.php?Item=" . $lineDisp["stockID"] . "'><IMG SRC='images/buttons/VIEW.gif' BORDER='0' ALT='View' name='View'></a></td></tr>";
				}




	  		}

	  		echo "</TABLE><BR>";

	  		if ($strPages <> 0)
	  		{


	  			if ($strPTag <> 0)
	  			{$strPrevious = $strPTag - 1;
	  			echo "<a href='Category.php?sTag=" . $strSTag . "&p=" . $strPrevious  . "'> &lt;&lt; Prev</a> ";}


	  			for ($counter=0;$counter<$strPages;$counter+=1)
	  			{

	  				$displayCounter = $counter + 1;


	  				echo " | ";

	  				if ($strPTag == $counter)
	  				{echo "<b><font size=+1>";}

	  				echo "<a href='Category.php?sTag=" . $strSTag . "&p=" . $counter . "'>" . $displayCounter . "</a>" ;

	  				if ($strPTag == $counter)
	  				{echo "</font></b>";}
	  			}

	  			echo " | ";

	  			if ($strPTag <> $strPages - 1)
	  			{$strNext = $strPTag + 1;
	  			echo "<a href='Category.php?sTag=" . $strSTag . "&p=" . $strNext  . "'> Next &gt;&gt; </a>";}

	  		}



      ?></p>
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
                  <form action="AuthenticateUser.php" method="post">
                    <font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2">
                    Email:</font><br>
                    </b> <font size="2">
                    <input type='text' name='EmailAddress' size='26'>
					<input type='hidden' name='pagelink' value='<?php echo $_SERVER['REQUEST_URI'];?>'>
                    </font></font> <font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><br>
                    <b> Password: </b> <br>
                    <input type='password' name='Password' size='26'>
                    </font></font>
                    <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type='image' src='images/buttons/SIGNBUTTON.gif' name='Sign In'>
                      <a href="register.php"><img src="images/buttons/REGBUTTON.gif" border="0"></a></font><a href="register.php"></a>
                  </form>
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
                  <form action='search.php' method='get'>
                    <input type='text' name='Search' size='26'>
                    <p align="center">
                      <input type='image' src='images/buttons/SEARCHBUTTON.gif' name='Search'>
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
      <p><a href="http://shop.scifivault.com/Category.php?sTag=ST"><img src="images/STARTREKbanner.jpg" width="200" height="100" border="0"></a><a href="http://shop.scifivault.com/subCategory.php?sTag=SG&vTag=ALL"><img src="images/STARGATEbanner.jpg" width="200" height="100" border="0"></a><a href="http://shop.scifivault.com/subCategory.php?sTag=ALN&vTag=ALL"><img src="images/alienbanner.jpg" width="200" height="100" border="0"></a><a href="http://shop.scifivault.com/subCategory.php?sTag=EVE&vTag=ALL"><img src="images/EVEbanner.jpg" width="200" height="100" border="0"></a><a href="http://shop.scifivault.com/subCategory.php?sTag=JB&vTag=ALL"><img src="images/007banner.jpg" width="200" height="100" border="0"></a><a href="http://shop.scifivault.com/Category.php?sTag=SW"><img src="images/STARWARSbanner.jpg" width="200" height="100" border="0"></a></p>
    </td>
  </tr>
</table>
<br>
<div align="center">
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
          <p>Version 0.7</p>
        </div>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
      </div>

</BODY>


</HTML>
