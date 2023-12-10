<?php
require 'template/header.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// print_r($_POST);
$session_id = session_id();
$txtprize = (isset($_POST["txtprize"])) ? $_POST["txtprize"] : '';
$btnsave = (isset($_POST["btnsave"])) ? $_POST["btnsave"] : '';

if ($btnsave != '') {
    $last_update_by = $_SESSION[$session_id]["uname"];

    if (is_numeric($txtprize)) {
        if ($txtprize < 1) {
            $txtprize = 1;
        }
    } else {
        $txtprize = 1;
    }
    $newdata = array(
        "prize_amount" => $txtprize,
        "last_update_by" => "$last_update_by"
    );
    //clearData();
    update(TBL_PRIZE, $newdata, "prize_amount is not null ");
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=prize.php"/>
    <?php
} else {
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>
    <?php
}

require 'template/footer_login.php';
?>
