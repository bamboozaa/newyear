<?php
header("Cache-Control: no-cache, must-revalidate");
include ("config/config.inc.php");
include ("config/function.inc.php");
$session_id = session_id();

if (checkLogin()) {
    $status = $_SESSION[$session_id]["admin"];

    if ($status != "Y") {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>
        <?php
    } else {

        $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE;
        $result = select($sql);
        if ($result) {
            foreach ($result as $row => $value) {
                $prize_no = $value['mm'];
            }
        }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta http-equiv="cache-control" content="no-cache" />
                <meta http-equiv="cache-control" content="max-age=0" />
                <meta http-equiv="pragma" content="no-cache" />
                <meta http-equiv="expires" content="-1" />
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
                <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
                <link href="css/styles.css" rel="stylesheet">
                <script src="js/jquery-1.11.3.js"></script>
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <script src="js/script.js"></script>
                
                <script>
                    $(document).ready(function() {
                        $('#btnstart').click(function() {
                            Drawing();
                        });
                    });

                    function Drawing() {
                        $('#btnstart').fadeOut(1000);
                        $('#divdraw2').fadeIn(1000);
                        showDetail('showDrawingV2', 'divdraw2');
                    }

                </script>
            </head>
            <body style="background-color:#000;" >
                <div class="container">
                    <div id="divshow">
                        <div id="divbgdraw">
                            <div id='divdraw2' style="display: none;">

                            </div>
                              <button id="btnstart" type="button" class="btn btn-info"><span class="glyphicon glyphicon-home"></span> สุ่มรางวัลใหม่อีกครั้ง</button>
                              
                        </div>
                    </div>

                    <form class="navbar-form navbar-right" role="search" action ="main_page.php">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-home"></span> กลับสู่เมนูหลัก</button>
                    </form>
                </div>
            </body>
        </html><?php
    } // end if
} // end if 
?>