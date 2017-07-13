<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php require_once('Connections/link.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO stock (item_name, item_size, unit_price, quantity) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['item_name'], "text"),
                       GetSQLValueString($_POST['item_size'], "text"),
                       GetSQLValueString($_POST['unit_price'], "double"),
                       GetSQLValueString($_POST['quantity'], "int"));

  mysql_select_db($database_link, $link);
  $Result1 = mysql_query($insertSQL, $link) or die(mysql_error());
}

$maxRows_viewstock = 10;
$pageNum_viewstock = 0;
if (isset($_GET['pageNum_viewstock'])) {
  $pageNum_viewstock = $_GET['pageNum_viewstock'];
}
$startRow_viewstock = $pageNum_viewstock * $maxRows_viewstock;

mysql_select_db($database_link, $link);
$query_viewstock = "SELECT * FROM stock";
$query_limit_viewstock = sprintf("%s LIMIT %d, %d", $query_viewstock, $startRow_viewstock, $maxRows_viewstock);
$viewstock = mysql_query($query_limit_viewstock, $link) or die(mysql_error());
$row_viewstock = mysql_fetch_assoc($viewstock);

if (isset($_GET['totalRows_viewstock'])) {
  $totalRows_viewstock = $_GET['totalRows_viewstock'];
} else {
  $all_viewstock = mysql_query($query_viewstock);
  $totalRows_viewstock = mysql_num_rows($all_viewstock);
}
$totalPages_viewstock = ceil($totalRows_viewstock/$maxRows_viewstock)-1;
?>
<!-------------------------validetion-------------------------------->
<script type='text/javascript'>

function formValidator(){
	// Make quick references to our fields
	var firstname = document.getElementById('firstname');
	var zip = document.getElementById('zip');
	var state = document.getElementById('state');
	var price = document.getElementById('price');
	
	// Check each input in the order that it appears in the form!
	if(isAlphabet(firstname, "Please enter only letters for your Item Name")){
		if(madeSelection(state, "Please Choose a State")){
		if(isNumeric(zip, "Please enter a valid Numeric price")){
		if(isNumeric(price, "Please enter a valid Numeric Quntity")){
							return true;
						}
					}
				}
	}
	
	return false;
	
}

function notEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus(); // set the focus to this input
		return false;
	}
	return true;
}

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphabet(elem, helperMsg){
	var alphaExp = /^[a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function isAlphanumeric(elem, helperMsg){
	var alphaExp = /^[0-9a-zA-Z]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}

function lengthRestriction(elem, min, max){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("Please enter between " +min+ " and " +max+ " characters");
		elem.focus();
		return false;
	}
}

function madeSelection(elem, helperMsg){
	if(elem.value == "Please Choose"){
		alert(helperMsg);
		elem.focus();
		return false;
	}else{
		return true;
	}
}

function emailValidator(elem, helperMsg){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}
</script>
<!------------------------------------------------------->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Link5 Solution(SLIIT)</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dash.html">Stock</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dash.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="addheadusers.php"><i class="fa fa-fw fa-bar-chart-o"></i> User Management</a>
                    </li>
                    <li>
                        <a href="replocation.php"><i class="fa fa-fw fa-table"></i>Rep Location</a>
                    </li>
                    <li>
                        <a href="stockin.php"><i class="fa fa-fw fa-edit"></i>Store</a>
                    </li>
                    <li>
                        <a href="AddNewItem1.php"><i class="fa fa-fw fa-edit"></i>Add Item</a>
                    </li>
                    <li>
                        <a href="addnewrep.php"><i class="fa fa-fw fa-desktop"></i> REP Management</a>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i>Sales Management<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="orderView1.php">View Orders</a>
                            </li>
                            <li>
                                <a href="viewwebuser.php">View New Client</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php /*?><h1 class="page-header">
                            Stock 
                            <small>Management</small>
                        </h1>
                        <br><?php */?>
                        
                        <!------------------------------------------------------>                   
                    <h1 class="page-header">Stock Management<?php /*?><small>Subheading</small><?php */?>
                      </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index1.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    
                     </div>				 
    
                              <div class="row">
                       <div class="col-md-8">  
                
 <!------------------------------------------------------>
  
  <form  onsubmit='return formValidator()' method="post" name="form1"  >
  <table align="center"  width="480" border="0" cellpadding="0" cellspacing="" height="250">
    <tr valign="centerline">
      <td nowrap align="center"><strong>Item Name: </strong></td>
      <td><input type="text" name="item_name"  id='firstname' class="form-control" size="60">
      
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Item Size: </strong></td>
      <td><select id='state' name="item_size"  class="form-control">
        <option value="Small" <?php if (!(strcmp("Small", ""))) {echo "SELECTED";} ?>>Small</option>
        <option value="Large" <?php if (!(strcmp("Large", ""))) {echo "SELECTED";} ?>>Large</option>
      </select></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Unit Price: </strong>
      </td>
      <td><input type="text" name="unit_price" id='zip' class="form-control" value="" size="60"></td> 
    </tr>
    <tr valign="centerline">
      <td nowrap align="center"><strong>Quantity: </strong></td>
      <td><input type="text" name="quantity" id='price' class="form-control" value="" size="60"></td>
    </tr>
    <tr valign="centerline">
      <td nowrap align="center">&nbsp;</td>
      <td><input type="submit" name="submit" class="btn btn-primary btn-lg btn-block active"  value="insert Recorde" ></td>
      
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
    </div>
    
    
     <div class="col-md-4"> <input type="submit" class="btn btn-primary btn-lg btn-block active"  value="Damege handling" onClick="window.location.href='dameges.php'">
</div>
                  </div>     
                </div>
                <!-- /.row -->

<div class="col-xs-12 col-sm-6 col-md-8" >
  
  <table class="table table-condensed"  border="2" width="100"  height="80">
    <tr bgcolor="#FFFF99">
      <td>Item Id</td>
      <td>Item Name</td>
      <td>Item Size</td>
      <td>Unit Price</td>
      <td>Quantity</td>
      <td></td>
    </tr>
    <?php do { ?>
      <tr bgcolor="">
       <td bgcolor="#CCCCCC"><a href="updateStock.php?item_id=<?php echo $row_viewstock['item_id']; ?>"><?php echo $row_viewstock['item_id']; ?></a></td>
        <td bgcolor="#CCCCCC"><?php echo $row_viewstock['item_name']; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row_viewstock['item_size']; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row_viewstock['unit_price']; ?></td>
        <td bgcolor="#CCCCCC"><?php echo $row_viewstock['quantity'];
		$newQun=$newQun+$row_viewstock['quantity']; ?></td>
        <td bgcolor="#CCCCCC"><a href="deletestock.php?item_id=<?php echo $row_viewstock['item_id']; ?>"><img src="img/delete.png" width="100" 
        height="30"></a></td>
      </tr>
      <?php } while ($row_viewstock = mysql_fetch_assoc($viewstock)); ?>
  </table>
</div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

<?php
mysql_free_result($viewstock);
?>
</html>