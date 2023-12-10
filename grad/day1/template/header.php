<?php
include ("config/config.inc.php");
include ("config/function.inc.php");

$fullname = '';
$session_id = session_id();
if (checkLogin()) {
    $fullname = $_SESSION[$session_id]["emp_firstname"] . " " . $_SESSION[$session_id]["emp_surname"] . " " . $_SESSION[$session_id]["dep_name"];
    $dep_id = $_SESSION[$session_id]["dep_id"];
    $arr_dep2 = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
    if ($arr_dep2 != '') {
        $party_id = $arr_dep2[$dep_id]["party_id"];
        $dep_name = $arr_dep2[$dep_id]["dep_name"];
        $arr_dep3 = getDepartment(DATABASE, TBL_DEPARTMENT, $party_id);
        $party_name = $arr_dep3[$party_id]['dep_name'];
    }
} // end if
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content=" <?= APP_TITLE ?>
              Version
              <?= APP_VERSION ?>">
        <meta name="author" content=" <?= APP_TITLE ?>
              Version
              <?= APP_VERSION ?>">
        <link rel="icon" href="images/favicon.ico">
        <title>
            <?= APP_TITLE ?>
            Version
            <?= APP_VERSION ?>
        </title>
        <link href="css/styles.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-datepicker.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script src="js/jquery-1.11.3.js"></script>
        <script src="bootstrap/js/bootstrap3-typeahead.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/bootstrap-datepicker.js"></script>
        <script src="js/script.js"></script>
    </head>
    <body>   
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="main_page.php"> <?= APP_TITLE ?>
                    <?= APP_VERSION ?></a>
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>                    
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                    
                    <ul class="nav navbar-nav">
                        <li><a href="report.php">รายชื่อนักศึกษา</a></li>
                        <li><a href="loop.php">แสดงรายชื่อผู้โชคดี</a></li>
                        <?php
                        $status = $_SESSION[$session_id]["admin"];
                        if ($status == "Y") {
                            ?>
                            <li><a href="prize.php">จำนวนรางวัล</a></li>
                            <li><a href="drawing.php">จับฉลาก</a></li>                            
                            <?php
                        } // end if
                        ?>                        
                    </ul>
                    <form class="navbar-form navbar-right" role="search" action ="signout.php">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-home"></span> ออกจากระบบ</button>
                    </form>                    
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav><br><br><br>
        <div class="container">            
            <p align="right"><span class="glyphicon glyphicon-user"></span> <?= $fullname ?></p>            
        </div>
