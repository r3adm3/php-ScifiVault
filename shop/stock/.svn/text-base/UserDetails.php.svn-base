<?php


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
      </div>
    </td>
  </tr>
</table>
<BR>
<?php

include ('includes/SharedFunctionsStrict.php');

$strUserID = funcSanitize($_GET["user"]);

echo $strUserID;

/************************************************************************
* connect to database
*************************************************************************/
$link = mysql_connect ("localhost", "sfvault_readStor", "fhyF=ruR^#1|WO")
		or die ("Could not connect: " . mysql_error() );


//change to correct database
mysql_select_db ("sfvault_store") or die ("Could not select database");

$strQuery = "SELECT * from tbl_UserLogin where UserID = '" . $strUserID . "'";

$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

$conNumberofRows = mysql_num_rows($strResult);

if ($conNumberofRows = 1)
{

	while ($line = mysql_fetch_array($strResult, MYSQL_ASSOC))
	{

		if ($line["FirstName"] <> "")
		{
		$strFirstName = trim (funcDecrypt (hex2bin ( $line["FirstName"])));
		}
		if ($line["SurName"] <> "")
		{
		$strSurName = trim (funcDecrypt (hex2bin ( $line["SurName"])));
		}
		if ($line["AddressLine1"] <> "")
		{
		$strAddressLine1 = trim (funcDecrypt (hex2bin ( $line["AddressLine1"])));
		}
		if ($line["AddressLine2"] <> "")
		{
		$strAddressLine2 = trim (funcDecrypt (hex2bin ( $line["AddressLine2"])));
		}
		if ($line["Town"] <> "")
		{
		$strTown = trim (funcDecrypt (hex2bin ( $line["Town"])));
		}
		if ($line["County"] <> "")
		{
		$strCounty = trim (funcDecrypt (hex2bin ( $line["County"])));
		}
		if ($line["Country"] <> "")
		{
		$strCountry = trim (funcDecrypt (hex2bin ( $line["Country"])));
		}
		if ($line["PostCode"] <> "")
		{
		$strPostCode = trim (funcDecrypt (hex2bin ( $line["PostCode"])));
		}
		if ($line["DaytimeNo"] <> "")
		{
		$strDayTimeNo = trim (funcDecrypt (hex2bin ( $line["DaytimeNo"])));
		}
		if ($line["Mobile"] <> "")
		{
		$strMobile = trim (funcDecrypt (hex2bin ( $line["Mobile"])));
		}
		$strEmailAddress = $line["emailAddress"];
	}

}
elseif ($conNumberofRows = 0)
{
	//values for table can be blank. Phew.
}
else
{
	echo "Error! We have a problem here, there's more than 1 record with your username. Contact SciFiVault.";
}
?>
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
	  <div align="center">
        <p><a href='/UserDetails.php?strUserID=<?php echo $strUserID;  ?>'>Add/Update
          User Details</a> | <a href='/UserPasswordChange.php?strUserID=<?php echo $strUserID;  ?>'>Change
          Password</a> | <a href='/UserOrderHistory.php?strUserID=<?php echo $strUserID;  ?>'>Order
          History</a> | <a href='/UserOutstandingOrders.php?strUserID=<?php echo $strUserID;  ?>'>Outstanding
          Orders</a></p>
        <p>&nbsp;</p>
      </div>

<form method="POST" action="addDetails.php?strUserID=<?php echo $strUserID; ?>">

		<table>
			<tr><td bgcolor="#FFFFCC">First Name:	  </td><td>	<input type="text" name="FirstName" size="20" value="<?php echo $strFirstName; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Last Name:	  </td><td>	<input type="text" name="SurName" size="20" value="<?php echo $strSurName; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Address Line 1:	  </td><td>	<input type="text" name="AddressLine1" size="20" value="<?php echo $strAddressLine1; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Address Line 2:	  </td><td>	<input type="text" name="AddressLine2" size="20" value="<?php echo $strAddressLine2; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Town/City:	  </td><td>	<input type="text" name="Town" size="20" value="<?php echo $strTown; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">County:	  </td><td>	<input type="text" name="County" size="20" value="<?php echo $strCounty; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Country:	  </td><td>	              <select name="Country" width="20" STYLE="width:150px">

              	<?php

				if ($strCountry <> "UK")
				{
				echo "\n\t<option value='" . $strCountry . "' selected='selected'>" . $strCountry . "</option>";
				echo "\n\t<option value='UK'>UK</option>";
				}
				else
				{echo "\n\t<option value='UK' selected='selected'>UK</option>";}

              	$strOptionQuery = "SELECT Country FROM tbl_PostageZones where Country <> 'UK'";

				$strOptionResult = mysql_query($strOptionQuery) or die ("Query Failed :" . mysql_error());

				while ($line = mysql_fetch_array($strOptionResult, MYSQL_ASSOC))
				{

					echo "\n\t<option value='" . $line["Country"] . "'>" . $line["Country"] . "</option>";

				}

              	?>

              </select><br></td></tr>
			<tr><td bgcolor="#FFFFCC">PostCode:	  </td><td>	<input type="text" name="PostCode" size="20" value="<?php echo $strPostCode; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Daytime Contact No:	  </td><td>	<input type="text" name="DayTimeNo" size="20" value="<?php echo $strDayTimeNo; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Mobile:	  </td><td>	<input type="text" name="Mobile" size="20" value="<?php echo $strMobile; ?>"><br></td></tr>
			<tr><td bgcolor="#FFFFCC">Email Address:	  </td><td>	<?php echo $strEmailAddress; ?><br></td></tr>
			<tr><td	bgcolor="#FFFFCC">   </td><td><input type="submit" value="Submit" name="B1"> </td></tr>
		</table>
	</form>

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
          <p>Version 0.7</p>
        </div>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>

</HTML>

