<?php
require 'template/header.php';
$session_id = session_id();

if (checkLogin()) {
    $status = $_SESSION[$session_id]["admin"];

    if ($status != "Y") {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>        
        <?php
    } else {
        ?>
        <div class="container">
            <form action="update_prize.php" method="post" name="form1" id="form1" target="show_result" >
                <button class="btn btn-default" type="submit" id='btnsubmit' value="drawing" name="btnsubmit">จับฉลาก</button>
                <button class="btn btn-default" type="submit" id='btnclear' value="clearing" name="btnclear">ล้างข้อมูล</button>
            </form>
            <br>
            <iframe name="show_result" width="100%" frameborder="0" height="500">
            </iframe>
        </div>
        <?php
    } // end if
} // end if

require 'template/footer_login.php';
?>