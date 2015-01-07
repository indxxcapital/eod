<?php
$from = "indexing@indxx.com"; // sender
    $subject = "Check for Junk";
    $message = "Checking for Junk";
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
   if( mail("sgoyal@indxx.com",$subject,$message,"From: $from\n"))
    echo "Thank you for sending us feedback";


?>
