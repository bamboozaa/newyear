<?php
require 'template/header.php';
$session_id = session_id();

if (checkLogin()) {
    $status = $_SESSION[$session_id]["admin"];

    if ($status != "Y") {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>
        <?php
    } // end if
    $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE;
    $result = select($sql);
    if ($result) {
        foreach ($result as $row => $value) {
            $limit = $value['mm'];
        }
    }
    ?>
    <div class="container" id="clear_data" style="position: static">
        <form name="form1" method="post" action="clear_data.php" autocomplete="off">
        	<p>
            	<button type="submit" name="btnsave" id="btnsave" value="save"  class="btn btn-danger">Clear Data</button>              
            </p>
            <div class="alert alert-warning" role="alert"> <u>หมายเหตุ</u> <br />- กดปุ่มบันทึกข้อมูลหลังจากใส่จำนวนรางวัล และรายละเอียดของรางวัล เพื่อจับฉลากสุ่มรายชื่อผู้โชคดี <br />- เมื่อ Clear Data แล้ว จำนวนรางวัลและข้อมูลผู้ถูกรางวัลจะถูกลบออก จะต้องทำการจับฉลากผู้โชคดีใหม่อีกครั้งค่ะ</div>
        </form>
    </div>

    
<?php
}
require 'template/footer_login.php';
?>
