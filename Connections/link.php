<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_link = "localhost";
$database_link = "linkfive_link";
$username_link = "linkfive_thamara";
$password_link = "thamara";
$link = mysql_pconnect($hostname_link, $username_link, $password_link) or trigger_error(mysql_error(),E_USER_ERROR); 
?>