<?php
foreach( $_GET as $key=>$val ) {${$key}=$val;}  foreach($_POST as $key=>$val){${$key}=$val;}
require 'template/header.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// print_r($_POST);
$session_id = session_id();
$last_update_by = $_SESSION[$session_id]["uname"];
//$txtprize1 = (isset($_POST["txtprize1"])) ? $_POST["txtprize1"] : '';
//$txtprize2 = (isset($_POST["txtprize2"])) ? $_POST["txtprize2"] : '';
//$txtprize3 = (isset($_POST["txtprize3"])) ? $_POST["txtprize3"] : '';
//$btnprize1 = (isset($_POST["btnprize1"])) ? $_POST["btnprize1"] : '';
//$btnprize2 = (isset($_POST["btnprize2"])) ? $_POST["btnprize2"] : '';
//$btnprize3 = (isset($_POST["btnprize3"])) ? $_POST["btnprize3"] : '';
//$txtprize_detail_prize1 = (isset($_POST["txtprize_detail_prize1"])) ? $_POST["txtprize_detail_prize1"] : '';
//$txtprize_detail_prize2 = (isset($_POST["txtprize_detail_prize2"])) ? $_POST["txtprize_detail_prize2"] : '';
//$txtprize_detail_prize3 = (isset($_POST["txtprize_detail_prize3"])) ? $_POST["txtprize_detail_prize3"] : '';
$txtprize_detail = (isset($_POST["txtprize_detail"])) ? $_POST["txtprize_detail"] : '';
$prize_amount = (isset($_POST["prize_amount"])) ? $_POST["prize_amount"] : '';
$btn_save_prize = (isset($_POST["btn_save_prize"])) ? $_POST["btn_save_prize"] : '';
$btn_name_prize = (isset($_POST["btn_name_prize"])) ? $_POST["btn_name_prize"] : '';


foreach($btn_save_prize as $key=>$save_prize) {
	if($btn_save_prize[$key] != '') {
		$prize = substr($save_prize,5);
		$prize_id = substr($save_prize,5)-1;
		//echo $save_prize.$txtprize_detail[$key].$prize_amount[$key].$save_prize;
		//echo $txtprize_detail[$prize_id];
		
	    if (is_numeric($prize_amount[$prize_id])) {
			if ($prize_amount[$prize_id] < 1) {
				$prize_amount[$prize_id] = 1;
			}
		} else {
			$prize_amount[$prize_id] = 1;
		}

	$newdata1 = array(
		"prize_detail" => $txtprize_detail[$prize_id],
		"prize_amount" => $prize_amount[$prize_id],
		"last_update_by" => "$last_update_by"
	);
	
    $newdata2 = array(
        "prize_amount" => $prize_amount[$prize_id],
        "last_update_by" => "$last_update_by"
    );	
	
	update(TBL_PRIZE_NAME, $newdata1, "prize_id = '$save_prize'");
	update(TBL_PRIZE, $newdata2, "prize_amount is not null ");
	clearData();
	?>
    <script language="javascript">
		alert('บันทึกข้อมูลรางวัลที่ <?= $prize ?> เรียบร้อยแล้ว');
	</script>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=drawing.php?prize=<?= $save_prize ?>"/>	
	<?php
	}
}

/*
foreach($btn_name_prize as $key=>$value) {
//for($i=0;$i<count($btn_name_prize);$i++){	
	if($btn_name_prize[$key] != '') {
		$prize = substr($value,5);
		$newdata = array(
        	"prize" => $value
    	);
		update(TBL_EMPLOYEE, $newdata, "prize_no is not null ");
		$strSQL = "UPDATE tbl_employee_newyear2562 SET prize_seq = prize_no WHERE prize_seq is NULL";
		mysql_query($strSQL);
		clearData();
		?>
		<script type="text/javascript">
			alert('บันทึกรายชื่อผู้ได้รับรางวัลที่ <?= $prize ?> เรียบร้อยแล้ว');
		</script>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=report.php"/>
        <?php
	}
}
*/
require 'template/footer_login.php';

/*
if ($btnprize1 != '') {
    $last_update_by = $_SESSION[$session_id]["uname"];
	$btnprize = $btnprize1;
	
    if (is_numeric($txtprize1)) {
        if ($txtprize1 < 1) {
            $txtprize1 = 1;
        }
    } else {
        $txtprize1 = 1;
    }
	
	$newdata1 = array(
		"prize_detail" => $txtprize_detail_prize1,
		"prize_amount" => $txtprize1,
		"last_update_by" => "$last_update_by"
	);
	
    $newdata2 = array(
        "prize_amount" => $txtprize1,
        "last_update_by" => "$last_update_by"
    );	
	
	update(TBL_PRIZE_NAME, $newdata1, "prize_id = '$btnprize'");
	update(TBL_PRIZE, $newdata2, "prize_amount is not null ");
    ?>
    <script type="text/javascript">
		alert("บันทึกข้อมูลรางวัลที่ 1 เรียบร้อยแล้ว");
	</script>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=prize.php"/>
    <?php
}

if ($btnprize2 != '') {
    $last_update_by = $_SESSION[$session_id]["uname"];
	$btnprize = $btnprize2;
	
    if (is_numeric($txtprize2)) {
        if ($txtprize2 < 1) {
            $txtprize2 = 1;
        }
    } else {
        $txtprize2 = 1;
    }
	
	$newdata1 = array(
		"prize_detail" => $txtprize_detail_prize2,
		"prize_amount" => $txtprize2,
		"last_update_by" => "$last_update_by"
	);
	
    $newdata2 = array(
        "prize_amount" => $txtprize2,
        "last_update_by" => "$last_update_by"
    );
	
	$newdata3 = array(
        "prize" => $btnprize
    );		
	
	update(TBL_PRIZE_NAME, $newdata1, "prize_id = '$btnprize'");
	update(TBL_PRIZE, $newdata2, "prize_amount is not null ");
	update(TBL_EMPLOYEE, $newdata3, "prize_no is not null ");
	clearData();
    ?>
    <script type="text/javascript">
		alert("บันทึกข้อมูลรางวัลที่ 2 เรียบร้อยแล้ว");
	</script>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=prize.php"/>
    <?php
}

if ($btnprize3 != '') {
    $last_update_by = $_SESSION[$session_id]["uname"];
	$btnprize = $btnprize3;
	
    if (is_numeric($txtprize3)) {
        if ($txtprize3 < 1) {
            $txtprize3 = 1;
        }
    } else {
        $txtprize3 = 1;
    }
	
	$newdata1 = array(
		"prize_detail" => $txtprize_detail_prize3,
		"prize_amount" => $txtprize3,
		"last_update_by" => "$last_update_by"
	);
	
    $newdata2 = array(
        "prize_amount" => $txtprize3,
        "last_update_by" => "$last_update_by"
    );
	
	$newdata3 = array(
        "prize" => $btnprize
    );
	
	update(TBL_PRIZE_NAME, $newdata1, "prize_id = '$btnprize'");
	update(TBL_PRIZE, $newdata2, "prize_amount is not null ");
	update(TBL_EMPLOYEE, $newdata3, "prize_no is not null ");
	clearData();
    ?>
    <script type="text/javascript">
		alert("บันทึกข้อมูลรางวัลที่ 3 เรียบร้อยแล้ว");
	</script>
    <META HTTP-EQUIV="Refresh" CONTENT="0;URL=prize.php"/>
    <?php
}

require 'template/footer_login.php';
*/
?>
