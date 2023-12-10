<?php
require 'template/header.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// print_r($_POST);
$session_id = session_id();
$btnaddprize = (isset($_POST["btnaddprize"])) ? $_POST["btnaddprize"] : '';
$btndelprize = (isset($_POST["btndelprize"])) ? $_POST["btndelprize"] : '';

if ($btnaddprize != '') {
    $last_update_by = $_SESSION[$session_id]["uname"];

    $sql = 'select count(prize_id) as mm from ' . TBL_PRIZE_NAME;
    $result = select($sql);
	//print_r($result);
    if ($result) {
        foreach ($result as $row => $value) {
            $count = $value['mm']+1;
        }
    }
	$newdata = array(
		"prize_id" => "prize" . $count,
		"prize_name" => "รางวัลที่ " . $count,
		"prize_amount" => 1,
		"last_update_by" => "$last_update_by"
	);	
	
	insert(TBL_PRIZE_NAME, $newdata);
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=prize.php"/>
<?php
}

if ($btndelprize != '') {
    $last_update_by = $_SESSION[$session_id]["uname"];

    $sql = 'select max(prize_id) as mm from ' . TBL_PRIZE_NAME;
    $result = select($sql);
	//print_r($result);
    if ($result) {
        foreach ($result as $row => $value) {
            $limit = $value['mm'];
        }
    }	
	$strSQL = "DELETE FROM `db_newyear`.`tbl_prize_name` WHERE `tbl_prize_name`.`prize_id` = '$limit'";
    //$strSQL = "DELETE FROM TBL_PRIZE_NAME WHERE prize_id = '$limit'";
	//print_r($strSQL);
	?>
    <script type="text/javascript">
		alert("ยืนยันการลบรางวัล");
	</script>
    <?php
    $objQuery = mysql_query($strSQL);
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=prize.php"/>
<?php
}

require 'template/footer_login.php';
?>
