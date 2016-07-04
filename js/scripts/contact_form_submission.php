<?php
if(isset($_REQUEST['submit'])){
  $to = "info@wamaki.co.ke";
  $from = $_REQUEST['email'];
  $name = $_REQUEST['name'];
  $subject = $_REQUEST['subject'];
  $message = $name . " wrote the following:" . "\n\n" . $_REQUEST['message'];

  $headers = "From:" . $from;
  mail($to,$subject,$message,$headers);

  echo "Mail Sent. Thank you " . $name . ", we will contact you shortly.";

}
?>
