<?php
$action = $_POST['action'];
$from = $_POST['from'];
$realname = $_POST['realname'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$emaillist = $_POST['emaillist'];
?>
<html>
<head>
<title>DONSHAQ Was Here</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#003300" text=yellow>
<p align="center"><strong><font face="Arial" size="6" color="#FFFF00">ITS ME</font><font face="Arial" size="6" color="#00FF00">
</font><font face="Arial" size="6" color="#FF0000">AND</font><font face="Arial" size="6" color="#00FF00">
</font><font face="Arial" size="6" color="#CCCC00">2</font><font face="Arial" size="6" color="#FF00FF">0</font><font face="Arial" size="6" color="#FF9900">0</font><font face="Arial" size="6" color="#CCFF66">9</font><font face="Arial" size="6" color="#00FF00">K</font><font face="Arial" size="6" color="#00FFFF">$</font><font face="Arial" size="6" color="#FF0000">I</font>

<body bgcolor="#000000" text="#EEEEEE">
<?php


if ($action=="send"){
	$message = urlencode($message);
	$message = ereg_replace("%5C%22", "%22", $message);
	$message = urldecode($message);
	$message = stripslashes($message);
	$subject = stripslashes($subject);
}
?>

<form name="form1" method="post" action="" enctype="multipart/form-data">
  <br>
  <table width="100%" border="0">
    <tr> 
      <td width="10%"> 
        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Your 
          Email:</font></div>
      </td>
      <td width="18%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type="text" name="from" value="<?php echo $from; ?>" size="30" style="border: 1px dotted #FFFF00">
        </font></td>
     <td width="31%"> 
        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Your 
          Name:</font></div>
      </td>
      <td width="41%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type="text" name="realname" value="<?php echo $realname; ?>" size="30" style="border: 1px dotted #FFFF00">
        </font></td>
    </tr>
    <tr> 
      <td width="10%"> 
        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></div>
      </td>
      <td colspan="3"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type="text" name="subject" value="<?php echo $subject; ?>" size="115" style="border: 3px dotted #FFFF00">
        </font></td>
    </tr>
    <tr valign="top"> 
      <td colspan="3"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="message" cols="60" rows="10" style="border: 3px dotted #FFFF00"><?php echo $message; ?></textarea>
        <br>
        <input type="hidden" name="action" value="send">
        </font>
		<p><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" value="StarT SpamminG" style="border: 1px groove #FFFF00">
        </font></td>
      <td width="41%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="emaillist" cols="30" rows="10" style="border: 1px dotted #FFFF00"><?php echo $emaillist; ?></textarea>
        <br></font></td>
    </tr>
  </table>
</form>

<?php
if ($action =="send"){

	if (!$from && !$subject && !$message && !$emaillist){
	echo "Please complete all fields before sending your message.";
	exit;
	}
	
	$allemails = split("\n", $emaillist);
	$numemails = count($allemails);
	
	for($x=0; $x<$numemails; $x++){
		$to = $allemails[$x];
		if ($to){
		$to = ereg_replace(" ", "", $to);
		$message = ereg_replace("&email&", $to, $message);
		$subject = ereg_replace("&email&", $to, $subject);
                $nrmail=$x+1;
		$domain = substr($from, strpos($from, "@"), strlen($from));
		echo "Sending... $nrmail of $numemails to $to.......";
		flush();
		$header = "From: $realname <$from>\r\n";
		$header .= "Message-Id: <130746$numemails.$nrmail$domain>\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html\r\n";
		$header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$header .= "$message\r\n";
		mail($to, $subject, "", $header);
		echo "delivered ....<br>";
		flush();
		}
		}

}
?>

</body>
</html>
<body bgcolor="#003300" text=yellow>
<p align="center"><strong><font face="Arial" size="6" color="#FFFF00"></font><font face="Arial" size="6" color="#00FF00">
</font><font face="Arial" size="6" color="#FF0000"></font><font face="Arial" size="6" color="#00FF00">
</font><font face="Arial" size="6" color="#CCCC00"> EnjoY </font><font face="Arial" size="6" color="#FF00FF"> YouR </font><font face="Arial" size="6" color="#FF9900"> SpamminG </font></strong></p>