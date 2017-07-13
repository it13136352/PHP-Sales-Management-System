
<?php
$password = $_GET['Password'];
	$TP_mobile = $_GET['TP_mobile'];
	
	
?>
<?php
	// Authorisation details.
	


	
	$username = "it13136352@my.sliit.lk";
	$hash = "5b05f759b1dbd70dbabb48aecfe8221a4b4b0c31";

	// Configuration variables. Consult http://api.txtlocal.com/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "Linkfivesoft"; // This is who the message appears to be from.
	$numbers = "$TP_mobile"; // A single number or a comma-seperated list of numbers
	$message = "$password";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.txtlocal.com/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	
	curl_close($ch);
	
?>
<html>
<body>
<script>
    setTimeout(function(){
       window.location='viewwebuser.php';
    }, 10);
</script>
</body>
</html>
