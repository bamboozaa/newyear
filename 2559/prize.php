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
    <div class="container">
        <form name="form1" method="post" action="prize_save.php" autocomplete="off">
            <p><label   for="txtprize">จำนวนรางวัล</label>
                <input type="number" name="txtprize" id="txtprize"  class="form-control" value="<?= $limit ?>" />
            </p>
            <p>
                <button type="submit" name="btnsave" id="btnsave" value="save"  class="btn btn-primary ">บันทึก</button>
            </p>  <div class="alert alert-warning" role="alert"> 
             หมายเหตุ เมื่อ update จำนวนรางวัลแล้วข้อมูลผู้ถูกรางวัลจะถูกลบออกจะต้องทำการจับฉลากผู้โชคดีใหม่อีกครั้งค่ะ</div>
        </form>
    </div>
    <?php
}
require 'template/footer_login.php';
?>
