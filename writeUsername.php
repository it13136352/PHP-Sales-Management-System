<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/link.php'); ?>
<?

mysql_select_db($database_link, $link);
$username=$_SESSION['MM_Username'];
$result = mysql_query("SELECT * FROM users WHERE username='$username'");
$row = mysql_fetch_array($result);
$userRole= $row["role"];

$userRole;


?>

<?php /*?>
<?php if($userRole="Admin"){ ?>
	<p><a href="#">For Admin interface</a></p> 
	<?php } else if($userRole="Rep") {?>
    <p><a href="#2">REP interface</a></p> 
    <?php } ?>
<?php */?>
<?php if($userRole=="Rep"){?> <script> alert("I'm rep") </script> <?php }?>

<?php if($userRole=="Rep"){ ?><p><a href="#">For Rep</a></p><?php } ?>
<?php if($userRole=="Admin"){ ?><p><a href="#2">For Andmin And Rep</a></p><?php } ?>