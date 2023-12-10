<?php
require 'template/header.php';
$session_id = session_id();

$dep_id = $_SESSION[$session_id]["dep_id"];
$doc_no_from_search = (isset($_POST["txtDocFrom"]) ? $_POST['txtDocFrom'] : '');
$doc_no_to_search = (isset($_POST["txtDocTo"]) ? $_POST['txtDocTo'] : '');
$doc_title_search = (isset($_POST["txtDocTitle_search"]) ? $_POST['txtDocTitle_search'] : '');
$doc_date_from_search = (isset($_POST["txtfrom"]) ? $_POST['txtfrom'] : '');
$doc_date_to_search = (isset($_POST["txtto"]) ? $_POST['txtto'] : '');

//$dep_to_search = (isset($_POST["ddldepartment"]) ? $_POST['ddldepartment'] : '');
$dep_to_search = (isset($_GET["to"]) ? decode($_GET['to']) : '');
$this_page = (isset($_GET["p"]) ? $_GET['p'] : '');

    $url = (isset($_POST["hidpage"]) ? $_POST['hidpage'] : 'report_dep.php');

// print_r($_POST);
// ค้นหาคณะ / ฝ่าย ที่สังกัดอยู่
$arr_dep2 = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
if ($arr_dep2 != '') {
    $dep_name = $arr_dep2[$dep_id]["dep_name"];    
}

$tbl_doc_name = (isset($_GET["tbl"]) ? decode($_GET['tbl']) : TBL_DOCUMENT . $dep_id . "_" . ACADYEAR);

//----------// ชื่อหน่วยงาน //----------// 
$arr_dep = getDepartment(DATABASE, TBL_DEPARTMENT, '', '', '', 'Y');
$str_ddl_dept = '';
if ($arr_dep != "") {
    foreach ($arr_dep as $index => $value) {
        if ($index == $dep_to_search) {
            $str_select = " selected=\"selected\"";
        } else {
            $str_select = "";
        }
        $str_ddl_dept .= "<option value=\"$index\" $str_select>" . $value["dep_name"] . "</option>";
    }
} // end if
?>
<div class="container">
    <script>
        $(document).ready(function() {
            $('#txtfrom').datepicker(
                    {
                        format: "yyyy-mm-dd",
                        language: "th",
                        todayHighlight: true
                    });
            $('#txtto').datepicker(
                    {
                        startDate: $('#txtfrom').val(),
                        format: "yyyy-mm-dd",
                        language: "th",
                        todayHighlight: true
                    });
            $('#btnsearch').click(function() {
                showReportParty();
            });
        });
        function showReportParty() {
            var txtfrom = $('#txtfrom').val();
            var txtto = $('#txtto').val();
            var txtDocTitle_search = $('#txtDocTitle_search').val();
            var ddldepartment = $('#ddldepartment').val();
            var acadyear = $('input[name=chkYear]:checked').val();
            var txtDocFrom = $('#txtDocFrom').val();
            var txtDocTo = $('#txtDocTo').val();

            if ((acadyear === '') || (acadyear === null) || (acadyear === undefined)) {
                acadyear = '<?= ACADYEAR ?>';
            }
            if ((ddldepartment === '') || (ddldepartment === null) || (ddldepartment === undefined)) {
                ddldepartment = '<?= $dep_to_search ?>';
            }

            showDetail('showReport', 'divreport', acadyear, '<?= $dep_id ?>', txtfrom, txtto, txtDocTitle_search, ddldepartment, txtDocFrom, txtDocTo, '<?= $this_page ?>','<?=$url?>');
        }

        function showDocDetail(doc_id) {
            var acadyear = $('input[name=chkYear]:checked').val();
            showDetail('showDocDetail', 'divDocDetail', acadyear, '<?= $dep_id ?>', doc_id);
        } // end function
        showReportParty();
    </script>    
    <h3>บันทึก <?= $dep_name ?></h3>
    <div>
        <form id="form1" name="form1" method="post" action="" >
            <table align="center" cellpadding="5" cellspacing="3" class="tblpopup" >
                <tr valign="top">

                    <td align="right">เลขที่เอกสาร</td>
                    <td>ตั้งแต่</td>
                    <td><input name="txtDocFrom" type="text" class="form-control" id="txtDocFrom" value="<?= $doc_no_from_search ?>" size="10" maxlength="10"/></td>
                    <td>ถึง</td>
                    <td><input name="txtDocTo" type="text" class="form-control  " id="txtDocTo" value="<?= $doc_no_to_search ?>" size="10" maxlength="10"/></td>
                    <td rowspan="6">
                        <div class="panel panel-default">
                            <div class="panel-heading">ปีของเอกสาร</div>
                            <div class="panel-body">
                                <?php
                                for ($i = ACADYEAR; $i >= START_ACADYEAR; $i--) {
                                    if ($i == ACADYEAR) {
                                        $showYear = "";
                                    } else {
                                        $showYear = $i - 543;
                                    }
                                    $chkvalue = TBL_DOCUMENT . $dep_id . "_" . $i;
                                    ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <label>
                                        <?php
                                        if ($tbl_doc_name == $chkvalue) {
                                            $old = $i;
                                            $str_check = "checked=\"checked\"";
                                        } else {
                                            $str_check = "";
                                        }
                                        ?>
                                        <input name="chkYear" type="radio" id="chkYear_0" value="<?= $i ?>" <?= $str_check ?>  />                                        
                                        <?= $i ?>
                                    </label>
                                    <br />
                                    <?php
                                } // end for                
                                ?>
                            </div>
                        </div></td>
                </tr>
                <tr>
                    <td align="right">เรื่อง</td>
                    <td colspan="4"><input name="txtDocTitle_search" type="text" class="form-control" id="txtDocTitle_search" size="40" value="<?= $doc_title_search ?>" /></td>
                </tr>
                <tr>
                    <td align="right">จากหน่วยงาน</td>
                    <td colspan="4"><?= $dep_name ?></td>
                </tr>
                <tr>
                    <td align="right">ไปยังหน่วยงาน</td>
                    <td colspan="4"><select name="ddldepartment" id="ddldepartment"  class="form-control"  style="width:300px;">
                            <option value="">ทั้งหมด</option>
                            <?= $str_ddl_dept ?>
                        </select></td>
                </tr>                          
                <tr>
                    <td align="right">วันที่ขอเอกสาร</td>
                    <td >ตั้งแต่</td>
                    <td >
                        <input type="text" class="form-control" name="txtfrom" id="txtfrom" value="<?= $doc_date_from_search ?>">
                    </td>
                    <td >ถึง</td>
                    <td >                              
                        <input type="text" class="form-control" name="txtto" id="txtto" value="<?= $doc_date_to_search ?>">
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="4"><button type="button" name="btnsearch" id="btnsearch" value="ค้นหา"  class=" btn btn-primary" ><span class="glyphicon glyphicon-search"></span> ค้นหา</button></td>
                </tr>
            </table>
        </form>
    </div>    
    <form id="form1" name="form1" method="post" action="add_memo.php" >
    <div class="table-responsive " id="divreport">    
    </div>
        </form>
</div>
    <div id="myModal"  class="modal fade" role="dialog">
        <div id="dialog-modal"  class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ข้อมูลบันทึก</h4>
                </div>
                <div class="modal-body" id="divDocDetail">                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
require 'template/footer_login.php';
?>