<?php 
  $to="xyz@gmail.com";
 $subject="test";
 $msg="hello! 2nd test.";
 $from="From: your_email_id@gmail.com";

 if (mail($to, $subject, $msg, $from)) {
  echo "email sent.";}
 else{echo "not sent.";}
 ?>
 
/*  this is for referencre and the bellow stuff can be deleted */

Configuration:  php.ini file:-
SMTP=smtp.gmail.com
smtp_port=587 / 465
sendmail_from = your_email_id@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t" 
Note:( it can be different if you've installed xampp somewhere else. )

sendmail.ini file:-
smtp_server=smtp.gmail.com
smtp_port=587 or 465 //use any of them
error_logfile=error.log
debug_logfile=debug.log
auth_username=your_email_id@gmail.com
auth_password=Your-Gmail-Password

Important:In library/admin/student.php file please put your email at line 76.
