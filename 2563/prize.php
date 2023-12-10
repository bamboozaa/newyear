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
/*    $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE;
    $result = select($sql);
    if ($result) {
        foreach ($result as $row => $value) {
            $limit = $value['mm'];
        }
    }*/
    ?>
 <!--   <div class="container">
        <form name="form1" method="post" action="prize_save.php" autocomplete="off">
            <p><label   for="txtprize">จำนวนรางวัล</label>
                <input type="number" name="txtprize" id="txtprize"  class="form-control" value="<?= $limit ?>" />
                <div class="alert alert-success"> กรุณาระบุจำนวนรางวัลที่ต้องการจับฉลาก</div>
            </p>
            <p>
                <button type="submit" name="btnsave" id="btnsave" value="save"  class="btn btn-primary ">บันทึก</button>
            </p>  
            <br />
            
        </form>
    </div>
  -->
    
    <div class="container">
    <link href="https://fonts.googleapis.com/css?family=Mitr" rel="stylesheet" type="text/css">
    	<form name="form1" method="post" action="prize_manage.php" autocomplete="off">
    	<div class="row">
        	<div class="col-md-8"><h4 style="font-family: 'Mitr', Sans Serif;">ข้อมูลของรางวัล</h4></div>
            <div class="col-md-4">
                <button type="submit" name="btnaddprize" value="addprize" class="btn btn-success" style="font-family: 'Mitr', Sans Serif; float: right;">เพิ่มของรางวัล</button>
                <button type="submit" name="btndelprize" value="delprize" class="btn btn-danger" style="font-family: 'Mitr', Sans Serif; float: right;">ลบของรางวัล</button>
			</div>
        </div>
        </form>
        <form name="form1" method="post" action="prize_save_name.php" autocomplete="off">
        <?php
        $strSQL = "SELECT * from tbl_prize_name";
		$result = mysql_query($strSQL);
		$numrow = mysql_num_rows($result);
		
		$i = 0;
		if ($numrow > $i) {
			while ($row = mysql_fetch_array($result)) {	
			$i++;
			$strSQL2 = "SELECT prize FROM " . TBL_EMPLOYEE . " WHERE prize is not null";
			//print_r($strSQL2);
			$result2 = mysql_query($strSQL2) or die(mysql_error());
			$btndis = "";
			while ($row2 = mysql_fetch_array($result2)) {
				//echo $row2['prize'] . "<br>"	;
				if ($row['prize_id'] == $row2['prize']) {
					$btndis = "disabled";	
				}
			}
		?>
			<table class="table">
            	<tr>
                	<td align="center" valign="middle" style="background: url('./images/award-1714292_1920.jpg') no-repeat center center; background-size: 100px; height: 100px; width: 100px; vertical-align: middle;"><h1 style="font-family: 'Mitr', Sans Serif; color: #d4af37; text-shadow: 2px 2px 4px;"><?= $i ?></h1></td>
                    <td><textarea class="form-control" name="txtprize_detail[]>" rows="4" cols="50" placeholder="รายละเอียด<?= $row['prize_name'] ?>"><?= $row['prize_detail']; ?></textarea></td>
                    <td style="width: 150px;"><input type="number" name="prize_amount[]" id="txt<?= $row['prize_id'] ?>"  class="form-control" value="<?= $row['prize_amount']; ?>" style="text-align: center; font-size: 20px; height: 90px;" /></td>
                    <td align="center" valign="middle" style="width: 150px;"><button type="submit" name="btn_save_prize[]" value="<?= $row['prize_id']; ?>" class="btn btn-primary btn-lg" style="height: 90px;" <?= $btndis ?>>บันทึกข้อมูล<br />ชุดที่ <?= substr($row['prize_name'], -1) ?></button></td>
				</tr>
			</table>
		<?php
			}
		}
		?>
        </form>
    </div>
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
