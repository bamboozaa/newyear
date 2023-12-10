<?php
define("LDAP_SERVER_UTCC" , "10.7.46.103"); // //$server = 'cdc1.utcc-net.utcc-domain.local';
//define("LDAP_SERVER_UTCC" ,  'cdc1.utcc-net.utcc-domain.local'); // //$server = 'cdc1.utcc-net.utcc-domain.local';
define("LDAP_BESE_DN_UTCC" , 'OU=UTCC Organization Units,DC=utcc-net,DC=utcc-domain,DC=local');
define("DATABASE" , "db_newyear");
define("DATABASE_USER" , "komsan");
define("DATABASE_PASS" , "zRuYhtl8FM");
define('TBL_EMPLOYEE', 'tbl_employee_newyear2562');
define('TBL_DEPARTMENT', 'department_emp2562');
define("APP_TITLE", "ระบบจับฉลากงานปีใหม่");
define("APP_VERSION", "2562");
define("ACADYEAR", "2562");
define("START_ACADYEAR", "2562");
define("TBL_PRIZE", "tbl_prize");
define("TBL_PRIZE_NAME", "tbl_prize_name");
define("MAXROW", "50");

// connect to  mysql server
$my_connect = mysql_connect('localhost', DATABASE_USER, DATABASE_PASS);
if (!$my_connect) {
    die('Could not connect: ' . mysql_error());
}
// echo 'Connected db successfully <br>';
//mysql_close($my_connect);

//select the  database
$db_selected = mysql_select_db(DATABASE, $my_connect);
if (!$db_selected) {
    die ('Can not use ' . DATABASE . ' : ' . mysql_error());
}


mysql_query("SET time_zone = '+7:00'", $my_connect);
mysql_query("SET character_set_results=utf8", $my_connect);
mysql_query("SET collation_connection=utf8_general_ci", $my_connect);
mysql_query("SET NAMES 'utf8'", $my_connect);

@session_start();
?>