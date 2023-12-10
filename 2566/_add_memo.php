<?php
require 'template/header.php';

// ค้นหาคณะ / ฝ่าย ที่สังกัดอยู่
// print_r($_POST);
$session_id = session_id();
// session user
$doc_date = date('Y-m-d');
$dep_id = (isset($_POST['btnadd']) ? $_POST['btnadd'] : '');
$doc_id = (isset($_POST['btnedit']) ? $_POST['btnedit'] : '');
$acadyear = (isset($_POST['hidyear']) ? $_POST['hidyear'] : ACADYEAR);
if ($dep_id == '') {
    // ถ้ามาจากเมนูหลัก ให้แสดงข้อมูลฝ่ายก่อนเสมอ
    $dep_id = $_SESSION[$session_id]['dep_id'];
// ค้นหาคณะ / ฝ่าย ที่สังกัดอยู่
    $arr_dep2 = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
    if ($arr_dep2 != '') {
        $party_id = $arr_dep2[$dep_id]["party_id"];
        $arr_dep3 = getDepartment(DATABASE, TBL_DEPARTMENT, $party_id);
        $party_name = $arr_dep3[$party_id]['dep_name'];

        // เปลี่ยนค่าหน่วยงานเป็นฝ่าย
        $dep_id = $party_id;
        $dep_name = $party_name;
    }
}

$this_page = (isset($_GET["p"]) ? $_GET['p'] : '');
if ($this_page == "") {
    $this_page = (isset($_POST["hidpage"]) ? $_POST['hidpage'] : 'report.php');
} // end if
//----------// แสดง คำค้นหาที่ใกล้เคียง //----------//
$arr_dep21 = getDepartment(DATABASE, TBL_DEPARTMENT, '', '', '', "Y");

$str_department = "";
if ($arr_dep21 != "") {

    foreach ($arr_dep21 as $dep_id21 => $value) {
        $str_department .= '"' . $value['dep_name'] . '",  ';
    }
    $str_department = substr($str_department, 0, strlen($str_department) - 2);
} // end if


$arr_dep2 = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
if ($arr_dep2 != '') {
    $dep_name = $arr_dep2[$dep_id]["dep_name"];
}
if ($doc_id == "") {
    $str_title = "เพิ่ม";
} else {
    $str_title = "แก้ไข";
}

$doc_to_name = '';
$doc_folder = '';
$doc_title = '';
$comment = '';
$create_by = '';
$create_dep_name = '';
$last_update_by = '';
$last_update_date = '';
$create_date = '';
if ($doc_id != '') {
// แสดงข้อมูลเอกสาร
    $tbl_doc_name = TBL_DOCUMENT . $dep_id . '_' . $acadyear;
    $sql = "SELECT d.doc_id, d.dep_id, d.dep_to, d.doc_date, d.doc_title, d.doc_folder, d.doc_status, d.`comment`, d.create_dep, d.create_by, d.create_date, d.last_update_by, 
d.last_update_date, de.dep_name AS dep_name_to
FROM " . DATABASE . "." . $tbl_doc_name . " AS d
INNER JOIN " . DATABASE . '.' . TBL_DEPARTMENT . " AS de ON d.dep_to = de.dep_id
where d.doc_id='" . $doc_id . "' AND d.dep_id='" . $dep_id . "'";

    $result = select($sql);

    if ($result != '') {
        $arr_doc_from = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
        //      $doc_from_name = $arr_doc_from[$dep_id]['dep_name'];
//            print_r($result);
        foreach ($result as $row => $arr_temp) {
            $doc_id = $arr_temp['doc_id'];
            $doc_date = $arr_temp['doc_date'];
            $doc_to_name = $arr_temp['dep_name_to'];
            $doc_title = $arr_temp['doc_title'];
            $comment = $arr_temp['comment'];
            $create_by = $arr_temp['create_by'];
            $create_date = $arr_temp['create_date'];
            $create_dep = $arr_temp['create_dep'];
            $last_update_by = $arr_temp['last_update_by'];
            $last_update_date = $arr_temp['last_update_date'];
            $doc_folder = $arr_temp['doc_folder'];
            $doc_status = $arr_temp["doc_status"];
        }
        $arr_create_dep = getDepartment(DATABASE, TBL_DEPARTMENT, $create_dep);
        $create_dep_name = " จาก " . $arr_create_dep[$create_dep]['dep_name'];
    } // end if
} // end if
?>
<div class="container">
    <script>
        $(document).ready(function() {
            var subjects = [<?= $str_department ?>];
            $('#txtdepto').typeahead({source: subjects});
   $('#txtDocDate').datepicker(
                    {
                        format: "yyyy-mm-dd",
                        language: "th",
                        todayHighlight: true
                    });
        });
        function checkBeforeSubmit() {
        }
    </script>
    <form action="save_memo.php" method="post" name="form1" autocomplete="off" id="form1" onSubmit="return checkBeforeSubmit();" >
        <h3><?= $str_title ?>บันทึก <?= $dep_name ?></h3>
        <table border="0" cellspacing="8" class="table "  >
            <tr >
                <td  class="col-xs-4" align="right" valign="top">เลขทะเบียนส่ง</td> 
                <td valign="top"><input name="txtdocid" id="txtdocid" type="text" value="<?= $doc_id ?>" class="form-control " readonly   /></td>
                <td align="right">ปีการศึกษา</td>
                <td><input name="acadyear" id="acadyear" type="text" value="<?= $acadyear ?>" class="form-control " readonly   /></td>
            </tr>
            <tr>
                <td align="right">ออกเลขเอกสารในนามหน่วยงาน</td>
                <td valign="top">
                    <?= $dep_name ?>
                    <input name="dep_from" id="dep_from" type="hidden" value="<?= $dep_id ?>" class="form-control "    />                    
                </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>         

            <tr>
                <td align="right" valign="top">ไปถึงหน่วยงาน</td>
                <td valign="top" colspan="2" >
                    <input name="txtdepto" type="text" class="form-control" id="txtdepto" size="45" required   data-provide="typeahead" data-item='10' value="<?= $doc_to_name ?>"   />
                </td><td>
                    <span class="txtred">*</span></td>
            </tr>
            <tr>
                <td align="right">เอกสารลงวันที่</td>
                <td><input name="txtDocDate" type="text" class="form-control" id="txtDocDate" value="<?= $doc_date ?>" size="10" maxlength="10" required/>
                </td>
                <td  valign="top"><span class="txtred">*</span></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td align="right" valign="top">ชื่อแฟ้ม / โครงการ / สาขา /
                    แผนก / หลักสูตร / คณะกรรมการ</td>
                <td valign="top" colspan="3">
                    <input name="txtdocfolder" type="text" class="form-control" id="txtdocfolder" size="45" maxlength="255" placeholder='ช่องกรอกข้อมูลเพิ่มเติม (ถ้ามี) ที่ช่องนี้ค่ะ' value="<?= $doc_folder ?>" />
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">เรื่อง</td>
                <td valign="top" colspan="3"><textarea name="txtDocTitle" id="txtDocTitle" cols="45" rows="5" class="form-control" required><?= $doc_title ?></textarea>
                    <span class="txtred">*</span></td>
            </tr>
            <tr>
                <td align="right" valign="top">หมายเหตุ</td>
                <td valign="top" colspan="3"><textarea name="txtComment" id="txtComment" cols="45" rows="2" class="form-control"><?= $comment ?></textarea></td>
            </tr>
            <tr>
                <td align="right" valign="top">สถานะเอกสาร</td>
                <td valign="top" colspan="3">
                    <?php
                    $arr_status = array('A' => 'ปกติ', 'C' => 'ยกเลิก');
                    if (!isset($doc_status)) {
                        $doc_status = 'A';
                    }
                    foreach ($arr_status as $index => $value) {
                        if ($index == $doc_status) {
                            $check_str = "checked";
                        } else {
                            $check_str = '';
                        }
                        ?>
                        <label>
                            <input name="chkStatus" type="radio" id="chkStatus_<?= $index ?>" value="<?= $index ?>" <?= $check_str ?> />
                            <?= $value ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                    } // end foreach 
                    ?>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">ผู้บันทึกข้อมูล</td>
                <td valign="top"><?= $create_by ?> <?= $create_dep_name ?></td>
                <td align="right" valign="top">วันที่บันทึกข้อมูล</td>
                <td valign="top"><?= thai_date($create_date) ?></td>
            </tr>
            <tr>
                <td align="right" valign="top">ผู้แก้ไขล่าสุด</td>
                <td valign="top"><?= $last_update_by ?></td>
                <td align="right" valign="top">วันที่แก้ไขล่าสุด</td>
                <td valign="top"><?= thai_date($last_update_date) ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><input type="submit" name="btnsubmit" id="btnsubmit" value="บันทึก" class="btn btn-primary" />

                    <input type="button" name="btncancel" id="btncancel" value="ยกเลิก" class="btn btn-default" onclick="window.location.href = '<?= $this_page ?>';" />
                    <input name="hidtype" type="hidden" id="hidtype" value="" />
                    <input name="hidpage" type="hidden" value="<?= $this_page ?>" /></td>
            </tr>
        </table>     
    </form>
</div>
<?php
require 'template/footer_login.php';
?>