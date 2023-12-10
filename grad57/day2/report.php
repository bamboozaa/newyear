<?php
require 'template/header.php';
// แสดงรายชื่อนักศึกษาทั้งหมด
$session_id = session_id();

$dep_id = $_SESSION[$session_id]["dep_id"];
$emp_no_from_search = (isset($_POST["txtempFrom"]) ? $_POST['txtempFrom'] : '');
$emp_no_to_search = (isset($_POST["txtempTo"]) ? $_POST['txtempTo'] : '');
$emp_title_search = (isset($_POST["txtempTitle_search"]) ? $_POST['txtempTitle_search'] : '');
$emp_date_from_search = (isset($_POST["txtfrom"]) ? $_POST['txtfrom'] : '');
$emp_date_to_search = (isset($_POST["txtto"]) ? $_POST['txtto'] : '');

//$dep_to_search = (isset($_POST["ddldepartment"]) ? $_POST['ddldepartment'] : '');
$dep_to_search = (isset($_GET["to"]) ? decode($_GET['to']) : '');
$this_page = (isset($_GET["p"]) ? $_GET['p'] : '');

$url = (isset($_POST["hidpage"]) ? $_POST['hidpage'] : 'report.php');

// print_r($_POST);
// ค้นหาคณะ / ฝ่าย ที่สังกัดอยู่
$arr_dep2 = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
if ($arr_dep2 != '') {
    $party_id = $arr_dep2[$dep_id]["party_id"];
    $arr_dep3 = getDepartment(DATABASE, TBL_DEPARTMENT, $party_id);
    $party_name = $arr_dep3[$party_id]['dep_name'];
}
$tbl_emp_name = (isset($_GET["tbl"]) ? decode($_GET['tbl']) : TBL_EMPLOYEE . $party_id . "_" . ACADYEAR);

//----------// ชื่อคณะ / สาขาวิชา //----------// 
$arr_dep = getDepartment2(DATABASE, TBL_DEPARTMENT, TBL_EMPLOYEE, '', '', '', 'Y');
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
            $('#btnsearch').click(function() {
                showReportParty();
            });
        });
        function showReportParty() {
            var txtempTitle_search = $('#txtempTitle_search').val();
            var ddldepartment = $('#ddldepartment').val();
            var chkPrize = $('input[name=chkPrize]:checked').val();

            if ((chkPrize === '') || (chkPrize === null) || (chkPrize === undefined)) {
                chkPrize = 'N';
            }
            if ((ddldepartment === '') || (ddldepartment === null) || (ddldepartment === undefined)) {
                ddldepartment = '<?= $dep_to_search ?>';
            }
            showDetail('showReport', 'divreport', chkPrize, txtempTitle_search, ddldepartment);
        }

        function showempDetail(emp_id) {
            var acadyear = $('input[name=chkPrize]:checked').val();
            // showDetail('showempDetail', 'divempDetail', acadyear, '<?= $party_id ?>', emp_id);
        } // end function
        showReportParty();
    </script>    
    <h3>ค้นหารายชื่อนักศึกษา</h3>
    <form id="form1" name="form1" method="post" action="download.php" >
        <div>

            <table align="center" cellpadding="5" cellspacing="3" class="tblpopup" >               
                <tr>
                    <td align="right">ชื่อ / นามสกุล</td>
                    <td><input name="txtempTitle_search" type="text" class="form-control" id="txtempTitle_search" size="40" value="<?= $emp_title_search ?>" /></td>
                </tr>                
                <tr>
                    <td align="right">คณะ / สาขาวิชา</td>
                    <td><select name="ddldepartment" id="ddldepartment"  class="form-control"  style="width:300px;">
                            <option value="">ทั้งหมด</option>
                            <?= $str_ddl_dept ?>
                        </select></td>
                </tr>
                <tr>
                    <td align="right">สถานะ</td>
                    <td ><input type="checkbox" name="chkPrize" id="chkPrize" value="Y">
                        <label for="chkPrize">ถูกรางวัล</label></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button type="button" name="btnsearch" id="btnsearch" value="ค้นหา"  class=" btn btn-primary"  ><span class="glyphicon glyphicon-search"></span> ค้นหา</button></td>
                </tr>
            </table>

        </div>    

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
                <h4 class="modal-title">ข้อมูลนักศึกษา</h4>
            </div>
            <div class="modal-body" id="divempDetail">                    

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