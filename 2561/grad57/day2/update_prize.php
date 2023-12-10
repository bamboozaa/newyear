<?php

include ("config/config.inc.php");
include ("config/function.inc.php");

// print_r($_POST);
$btnclear = (isset($_POST["btnclear"])) ? $_POST["btnclear"] : '';
$btnsubmit = (isset($_POST["btnsubmit"])) ? $_POST["btnsubmit"] : '';

if ($btnclear != '') {
    clearData(TRUE);
} elseif ($btnsubmit != '') {
 //   clearData(TRUE);
        $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE ;
        $result = select($sql);
        if ($result) {
            foreach ($result as $row => $value) {
                $limit = $value['mm'];
            }
        }
        echo $limit;
    drawing ($limit, TRUE);
}
?>
