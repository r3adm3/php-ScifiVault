<?php ob_start() ?>
<?php 
if ($_GET['randomId'] != "BdoesGnHc3596PglYagR1NE5B0ojHlcxExkcsqgtsSRUIq9qWIE2NJqkPHS5KbQnudPli_KcTtx_GRmyD9auQNs5ufx1Jx1EwUYEG8GRmPPGjLba03wCGkNMpW25bv1igxXVjwEFaRdIiy0apvmsm9f3osTkjTJK9xBPWrrAmhwB3Vn2vwSmXBumoe4upM9q1GkzzrTRddqbqDDORH24xRKK9vliu9fCX4bAM1f8AvGffvK7HMYTI7uGgTn5SeFA") {
	echo "Access Denied";
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Editing bugReport.htm</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">body {background-color:threedface; border: 0px 0px; padding: 0px 0px; margin: 0px 0px}</style>
</head>
<body>
<div align="center">
<script language="javascript">
<!--//
// this function updates the code in the textarea and then closes this window
function do_save() {
	var code =  htmlCode.getCode();
	document.open();
	document.write("<html><form METHOD=POST name=mform action='http://www.scifivault.com:2082/frontend/x/files/savehtmlfile.html'><input type=hidden name=dir value='/usr/home/sfvault/www/shop/stock'><input type=hidden name=file value='bugReport.htm'>Saving ....<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><textarea name=page rows=1 cols=1></textarea></form></html>");
	document.close();
	document.mform.page.value = code;
	document.mform.submit();
}
function do_abort() {
	var code =  htmlCode.getCode();
	document.open();
	document.write("<html><form METHOD=POST name=mform action='http://www.scifivault.com:2082/frontend/x/files/aborthtmlfile.html'><input type=hidden name=dir value='/usr/home/sfvault/www/shop/stock'><input type=hidden name=file value='bugReport.htm'>Aborting Edit ....</form></html>");
	document.close();
	document.mform.submit();
}
//-->
</script>
<?php
// make sure these includes point correctly:
include_once ('/usr/home/sfvault/public_html/WysiwygPro/editor_files/config.php');
include_once ('/usr/home/sfvault/public_html/WysiwygPro/editor_files/editor_class.php');

// create a new instance of the wysiwygPro class:
$editor = new wysiwygPro();

// add a custom save button:
$editor->addbutton('Save', 'before:print', 'do_save();', WP_WEB_DIRECTORY.'images/save.gif', 22, 22, 'undo');

// add a custom cancel button:
$editor->addbutton('Cancel', 'before:print', 'do_abort();', WP_WEB_DIRECTORY.'images/cancel.gif', 22, 22, 'undo');

$body = '<HTML>

<HEAD>
	<TITLE>Submit Bug/Feature</Title>
</HEAD>

<BODY bgcolor="#FFFFFF" text="#000000">
<div align="center"><img src="../images/sfv.jpg" width="250"><BR>
</div>
<CENTER>
  <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>S u b m i t </b>B 
  u g . . . . .</font><font size="3"><BR>
  </font>
  <form method="POST" action="submitBug.php">
    <font size="3">
    <textarea name=\'Description\' cols=\'50\' rows=\'16\'></textarea>
    <br>
    <br>
    <input type="submit" value="Submit" name="B1">
    </font>
  </form>

		<br>
  <a href="displayBugs.php"><font face="Verdana, Arial, Helvetica, sans-serif">List 
  All Open Bugs</font></a> 
</CENTER>

</BODY>

</HTML>


';

$editor->set_code($body);

// add a spacer:
$editor->addspacer('', 'after:cancel');

// print the editor to the browser:
$editor->print_editor('100%',450);

?>
</div>
</body>
</html>
<?php ob_end_flush() ?>

