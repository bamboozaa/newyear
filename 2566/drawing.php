<?php
header("Cache-Control: no-cache, must-revalidate");
include ("config/config.inc.php");
include ("config/function.inc.php");
$session_id = session_id();
//$prize = $_GET["prize"];

if (checkLogin()) {
    $status = $_SESSION[$session_id]["admin"];

    if ($status != "Y") {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>
        <?php
    } else {

        $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE;
        //$sql2 = 'SELECT COUNT(id) FROM tbl_prize_name';
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
                <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-datepicker.css">
                <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
                <link href="css/styles.css" rel="stylesheet">
                <script src="js/jquery-1.11.3.js"></script>
                <script src="bootstrap/js/bootstrap3-typeahead.js"></script>
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <script src="bootstrap/js/bootstrap-datepicker.js"></script>
                <script src="js/script.js"></script>
            </head>
            <script>
                $(document).ready(function() {
                    $('#btndraw').one('click', function(e) {
						e.preventDefault();
                        //$("#btndraw").attr("disabled", "disabled");
						//$(this).attr("disabled", true);
						showAnimate();
						//document.getElementById(btndraw).disabled = 'true';
                    });
                });
                function showAnimate() {
					//document.getElementById(btndraw).disabled = 'true';
					//$('#btndraw').attr("disabled", true);
                    $('#btndraw').fadeOut(1000);
                    $('#divbgshow').delay(1000).fadeOut(1000);
                    $('#divloading').delay(1000).fadeIn(2000);
                    $('#divloading').fadeOut(10000, function() {
                    $('#divbgdraw').fadeIn(1000);
                        setTimeout(Drawing, 1000);
                    });
                }
                function Drawing() {
					var prize = $('#prize').val();
                    showDetail('showDrawing', 'divdraw', prize);				
                }
                
            </script>
            <body style="background-color:#000;" >
                <div class="container">
                    <div id="divshow">
                        <div id="divbgshow">
                            <div id="divno">
                                <?= $prize_no ?>
                            </div>
                            <div id='btndraw'>&nbsp;</div>
                        </div>
                        <div id="divloading" style="display:none;" > <img src="images/HNY2566-Happy.gif" > </div>
                        <div id="divbgdraw" style="display:none;" >
                            <div id='divdraw' > </div>
                        </div>
                    </div>
                    <form class="navbar-form navbar-right" role="search" action ="report.php">
                    	<!-- <input name="prize" type="hidden" class="form-control" id="prize" size="40" value="<?= $prize ?>" /> -->
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-home"></span> กลับสู่เมนูหลัก</button>
                    </form>
                </div>
            </body>
        </html><?php
    } // end if
} // end if 
?>