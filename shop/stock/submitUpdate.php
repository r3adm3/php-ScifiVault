<HTML>

	<HEAD>
		<TITLE>  The Vault StoreRoom - Update </TITLE>

			<?php $gblnDebug = true; ?>

	</HEAD>

	<BODY>
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
			if ($conNumberofRows != 1 )
				{
					echo "<b>ERROR! StockID ". $strStockID . "Doesn't exist in the database or there is more than one result<br>\n";
					echo "Redirecting you to the 'add' section of website</b><br>\n";

					echo "<meta http-equiv='REFRESH' content='5;updateItem.htm'>";
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
					$strCategory = $_POST["Category"];
					$strSize = $_POST["Size"];
					$strPercentDiscount = $_POST["percentDiscount"];
					$strWholesalePrice = $_POST["WholeSalePrice"];
					$strSupplier = $_POST["Supplier"];
					$strAvailability = $_POST["Availability"];
					$strNoOfItems = $_POST["NoOfItems"];
					$strSubjectTag = $_POST["SubjectTag"];
					$strCategoryTag = $_POST["CategoryTag"];
					$strVersionTag = $_POST["VersionTag"];					
					
					$strSubject = funcSanitize ($strSubject);
					$strCategory = funcSanitize ($strCategory);
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
					$strSubjectTag = funcSanitize ($strSubjectTag);
					$strCategoryTag = funcSanitize ($strCategoryTag);
					$strVersionTag = funcSanitize ($strVersionTag);	
					
					$strUpdateQuery = "UPDATE tblItem SET Description = '" . $strDescription . "', Category = '" . $strCategory . "', smallPicture = '" . $strSmallPicture . "', bigPicture = '" . $strBigPicture . "', ShortDescription = '" .$strShortDescription . "', Name = '" . $strName . "', Cost = '" . $strCost . "', RRP = '" . $strRRP . "', SaleRRP = '" . $strSaleRRP . "', Weight = '" . $strWeight . "', Barcode = '" . $strBarcode . "', Features = '" . $strFeatures . "', Version = '" . $strVersion . "', Size = '" . $strSize ."', PercentDiscount = '" . $strPercentDiscount . "', WholesalePrice = '" . $strWholesalePrice . "', Supplier = '" . $strSupplier . "', Availability = '" . $strAvailability . "', NoOfItems = '" . $strNoOfItems. "', SubjectTag='" . $strSubjectTag . "', CategoryTag='" . $strCategoryTag . "', VersionTag='" . $strVersionTag . "' WHERE stockID = '" . $strStockID . "'";

					funcDebug ("strUpdateQuery: " . $strUpdateQuery );

					$strUpdateResult = mysql_query ($strUpdateQuery) or die ("Query Failed :" . mysql_error());

					$strNow = date ('Y-m-j h:i:s');

					$strEditedInsert = "UPDATE: $$" . $strStockID . "$$,$$" . $strSmallPicture . "$$,$$" . $strBigPicture . "$$,$$" . $strShortDescription . "$$,$$" . $strName ."$$,$$" . $strCost . "$$,$$" . $strRRP . "$$,$$" . $strSaleRRP . "$$,$$" . $strWeight . "$$,$$" . $strBarcode . "$$,$$" . $strFeatures . "$$,$$" . $strVersion . "$$,$$" . $strSize . "$$,$$" . $strPercentDiscount . "$$,$$" . $strWholesalePrice . "$$,$$" . $strSupplier . "$$,$$" . $strAvailability . "$$,$$" . $strNoOfItems . "$$,$$" . $strCategoryTag . "$$,$$" .$strSubjectTag . "$$,$$" . $strVersionTag;

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
