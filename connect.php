<?php
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $phonenumber = $_POST['phonenumber'];
  $event_date = $_POST['event_date'];
  $number = $_POST['number'];

  //Database Connection
  $conn=new mysqli('localhost','root','','test');
  if($conn->connect_error){
      die('connection Failed: '.$conn->connect_error);
  }
  else{
    $stmt =$conn->prepare("insert into registration(fname,lname,email,phonenumber,event_date,age) 
    values(?,?,?,?,?,?)");
    $stmt->bind_param("sssiii",$fname,$lname,$email,$phonenumber,$event_date,$age);
    $stmt->execute();
    echo "registration successfull....";
    $stmt->close();
    $conn->close();
  }  

  $recaptcha = $_POST['g-recaptcha-response'];
$res = reCaptcha($recaptcha);
if(!$res['success']){
  // Error
}

function reCaptcha($recaptcha){
    $secret = "6Le0buIZAAAAALvIw6V6xtgSZEypD_iQEn5Ykw_U";
    $ip = $_SERVER['REMOTE_ADDR'];
  
    $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data = curl_exec($ch);
    curl_close($ch);
  
    return json_decode($data, true);
  }
?>