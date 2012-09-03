<HTML>

	<HEAD>
		<TITLE>  The Vault StoreRoom - Submit/Add </TITLE>

			<?php $gblnDebug = false; ?>

		<?php


			include ('includes/SharedFunctionsStrict.php');

			//Write Debug information
			funcDebug ("this is a test debug");


			//connect to server
			funcDebug ("Connecting to database");

			$link = mysql_connect ("localhost", "sfvault_writeSto", "Ti*ESUf3*_b?Km")
					or die ("Could not connect: " . mysql_error() );

			funcDebug ("Connected to database");

			//change to correct database
			mysql_select_db ("sfvault_store") or die ("Could not select database");

			//run query to see if result is returned

			$strStockID = $_POST["stockID"];
			$strQuery = "SELECT * FROM tblItem where stockID = '" . $strStockID . "'";
			funcDebug ("strQuery: " . $strQuery);
			$strResult = mysql_query($strQuery) or die ("Query Failed :" . mysql_error());

			$conNumberofRows = mysql_num_rows($strResult);


			funcDebug ($conNumberofRows);
			//funcDebug (mysql_num_rows($strResult) . "<br>");

			//if there are any rows in the table with the same ID, error
			if ($conNumberofRows != 0 )
				{
					echo "<b>ERROR! stockID ". $strStockID . "Already exists<br></b>\n";
				}
			else
				{


					$strDescription = $_POST["Description"];
					$strSmallPicture = $_POST ["smallPicture"];
					$strBigPicture = $_POST ["bigPicture"];
					$strShortDescription = $_POST["shortDescription"];
					$strName = $_POST["Name"];
					$strCost = $_POST["Cost"];
					$strRRP = $_POST["RRP"];
					$strSaleRRP = $_POST["SaleRRP"];
					$strWeight = $_POST["Weight"];
					$strBarcode = $_POST["Barcode"];
					$strFeatures =$_POST["Features"];
					$strVersion = $_POST["Version"];
					$strSize = $_POST["Size"];
					$strPercentDiscount = $_POST["percentDiscount"];
					$strWholesalePrice = $_POST["WholeSalePrice"];
					$strSupplier = $_POST["Supplier"];
					$strAvailability = $_POST["Availability"];
					$strNoOfItems = $_POST["NoOfItems"];
					$strSubject = $_POST["Subject"];
					$strCategory = $_POST["Category"];
					$strSubjectTag = $_POST["SubjectTag"];
					$strCategoryTag = $_POST["CategoryTag"];
					$strVersionTag = $_POST["VersionTag"];

					$strDescription = funcSanitize ($strDescription);
					$strSmallPicture = funcSanitize ($strSmallPicture) ;
					$strBigPicture = funcSanitize ($strBigPicture);
					$strShortDescription = funcSanitize ($strShortDescription);
					$strName = funcSanitize ($strName);
					$strCost = funcSanitize ($strCost);
					$strRRP = funcSanitize ($strRRP);
					$strSaleRRP = funcSanitize ($strSaleRRP);
					$strWeight = funcSanitize ($strWeight);
					$strBarcode = funcSanitize ($strBarcode);
					$strFeatures = funcSanitize ($strFeatures);
					$strVersion = funcSanitize ($strVersion);
					$strSize = funcSanitize ($strSize);
					$strPercentDiscount = funcSanitize ($strPercentDiscount);
					$strWholesalePrice = funcSanitize ($strWholesalePrice);
					$strSupplier = funcSanitize ($strSupplier);
					$strAvailability = funcSanitize ($strAvailability);
					$strNoOfItems = funcSanitize ($strNoOfItems);
					$strSubject = funcSanitize ($strSubject);
					$strCategory = funcSanitize ($strCategory);
					$strSubjectTag = funcSanitize ($strSubjectTag);
					$strCategoryTag = funcSanitize ($strCategoryTag);
					$strVersionTag = funcSanitize ($strVersionTag);

					$strInsertQuery = "INSERT INTO tblItem VALUES ('" . $strDescription . "','" . $strStockID . "','" . $strSmallPicture . "','" . $strBigPicture . "','" . $strShortDescription . "','" . $strName ."','" . $strCost . "','" . $strRRP . "','" . $strSaleRRP . "','" . $strWeight . "','" . $strBarcode . "','" . $strFeatures . "','" . $strVersion . "','" . $strSize . "','" . $strPercentDiscount . "','" . $strWholesalePrice . "','" . $strSupplier . "','" . $strAvailability . "','" .$strCategory . "','" .$strSubject . "','" . $strNoOfItems .  "','" . $strSubjectTag . "','" . $strCategoryTag . "','" .$strVersionTag . "', '','','')";

					funcDebug ("strInsertQuery: " . $strInsertQuery);

					//$strUpdateQuery = "UPDATE tblItem SET Description = '" . $strDescription . "', smallPicture = '" . $strSmallPicture . "', bigPicture = '" . $strBigPicture . "', ShortDescription = '" .$strShortDescription . "', Name = '" . $strName . "', Cost = '" . $strCost . "', RRP = '" . $strRRP . "', SaleRRP = '" . $strSaleRRP . "', Weight = '" . $strWeight . "', Barcode = '" . $strBarcode . "', Features = '" . $strFeatures . "', Version = '" . $strVersion . "', Size = '" . $strSize ."', PercentDiscount = '" . $strPercentDiscount . "', WholesalePrice = '" . $strWholesalePrice . "', Supplier = '" . $strSupplier . "', Availability = '" . $strAvailabilty . "' WHERE stockID = '" . $strStockID . "'";

					//funcDebug ("strUpdateQuery: " . $strUpdateQuery );

					$strInsertResult = mysql_query ($strInsertQuery) or die ("Query Failed :" . mysql_error());

					$strNow = date ('Y-m-j h:i:s');

					$strEditedInsert = "INSERT: $$" . $strStockID . "$$,$$" . $strSmallPicture . "$$,$$" . $strBigPicture . "$$,$$" . $strShortDescription . "$$,$$" . $strName ."$$,$$" . $strCost . "$$,$$" . $strRRP . "$$,$$" . $strSaleRRP . "$$,$$" . $strWeight . "$$,$$" . $strBarcode . "$$,$$" . $strFeatures . "$$,$$" . $strVersion . "$$,$$" . $strSize . "$$,$$" . $strPercentDiscount . "$$,$$" . $strWholesalePrice . "$$,$$" . $strSupplier . "$$,$$" . $strAvailability . "$$,$$" . $strNoOfItems . "$$,$$" . strSubjectTag . "$$,$$" . $strCategoryTag . "$$,$$" . $strVersionTag;

					$strLogInsert = "INSERT INTO tblLog Values ('" . $strNow . "','DEV','" . $strEditedInsert . "')";

					funcDebug ("strLogInsert: " . $strLogInsert);

					$strInsertLogEntry = mysql_query ($strLogInsert) or die ("Log Entry Failed");

				}


			//close connection to database
			funcDebug ("Closing link to db");
			mysql_close ($link);

redirect( "displayItem.php?stockID=" . $strStockID , 1, "<B>Redirecting...</B><br> <a href='displayItem.php?stockID=" . $strStockID . "'>Click here if redirect fails</a>" );

?>


<?php


   // Redirects to another Page using HTTP-META Tag
   function redirect( $url, $delay = 0, $message = "" )
   {
      /* redirects to a new URL using meta tags */
      echo "<meta http-equiv='Refresh' content='".$delay."; url=".$url."'>";
      die( "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center> ".$message." </div>" );
   }


?>











