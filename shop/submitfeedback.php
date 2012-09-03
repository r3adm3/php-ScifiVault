<?php

include ('includes/SharedFunctionsStrict.php');

$strMailText = funcSanitize($_POST['feedback']);
$strURL = funcSanitize($_POST['URL']);

		mail("webmaster@scifivault.com,adrian@nofishhere.com,hilary@scifivault.com,david@scifivault.com", "Feedback" , $strMailText,
		     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
		     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
			"X-Mailer: PHP/" . phpversion());

echo "<meta http-equiv='refresh' content='0;url=" . $strURL . "'>";

?>
