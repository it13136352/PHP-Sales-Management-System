<?php require_once('Connections/link.php'); 

$shopId=$_GET['shopid'];
$userid=$_GET['userId'];

  mysql_select_db($database_link, $link);
  $insertGoTo = "repwindow.php";
$result = mysql_query("INSERT INTO sales_conferm(`shop_id`, `qr`, `status`) VALUES ('$shopId','$userid','Done')");

?>

