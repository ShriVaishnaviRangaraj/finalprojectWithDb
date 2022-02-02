<?php
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail()
{
    //Create instance of PHPMailer
    $mail = new PHPMailer();
    //Set mailer to use smtp
    $mail->isSMTP();
    //Define smtp host
    $mail->Host = "smtp.gmail.com";
    //Enable smtp authentication
    $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
    $mail->SMTPSecure = "tls";
    //Port to connect smtp
    $mail->Port = "587";
    //Set gmail username
    $mail->Username = "trashcollector.host@gmail.com";
    //Set gmail password
    $mail->Password = "TrashAdmin@07";
    //Email subject
    $mail->Subject = "Garbage Complaint reg.";
    //Set sender email
    $mail->setFrom('trashcollector.host@gmail.com');
    //Enable HTML
    $mail->isHTML(true);
    //Attachment
    $mail->addAttachment('C:/xampp/htdocs/trashLocator/'.strval(date("d-m-Y")).'.xlsx');
    //Email body
    $mail->Body = "<h1>Today's Complaints</h1></br><p>Please Find the Attachment below</p>";
    //Add recipient
    $mail->addAddress('vaishnavi160900@gmail.com');
    //Finally send email
    if($mail->send()) 
        echo '<h5 style="color:Green; font-family:cursive"> File Sent </h5>'; 
    else
    {
        echo '<h5 style="color:Red; font-family:cursive"> Message could not be sent. Mailer Error </h5> ';
    }
    //Closing smtp connection
    $mail->smtpClose();
}

function replyMail($usermail='',$image='')
{
    //Create instance of PHPMailer
    $mail = new PHPMailer();
    //Set mailer to use smtp
    $mail->isSMTP();
    //Define smtp host
    $mail->Host = "smtp.gmail.com";
    //Enable smtp authentication
    $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
    $mail->SMTPSecure = "tls";
    //Port to connect smtp
    $mail->Port = "587";
    //Set gmail username
    $mail->Username = "trashcollector.host@gmail.com";
    //Set gmail password
    $mail->Password = "TrashAdmin@07";
    //Email subject
    $mail->Subject = "Location unable to trace reg.";
    //Set sender email
    $mail->setFrom('trashcollector.host@gmail.com');
    //Enable HTML
    $mail->isHTML(true);
    //Attachment
    $mail->addAttachment($image);
    //Email body
    $mail->Body = '<h3>Unable to Trace your Location..</h3><br/><p>Before Capturing the image or video, please make sure your location tags are "On" and send the file again.</p>';
    //Add recipient
    $mail->addAddress($usermail);
    //Finally send email
    if(!$mail->send()) 
        echo '<h5 style="color:Red; font-family:cursive">Unable to send "LatLong reply mail".</h5>'; 
    
    //Closing smtp connection
    $mail->smtpClose();
}

?>