<?php
require 'template/header.php';
//echo "<pre>";
//print_r($_SESSION);
//print_r($_POST);
//echo "</pre>";
$hidpage = (isset($_POST['hidpage'])) ? $_POST['hidpage'] : 'index.php';
$dep_from = (isset($_POST['dep_from'])) ? $_POST['dep_from'] : $hidpage = 'index.php';
$str_dep_to = (isset($_POST['txtdepto'])) ? $_POST['txtdepto'] : $hidpage = 'index.php';

$chkStatus = (isset($_POST["chkStatus"])) ? $_POST["chkStatus"] : 'A';
$txtdocid = (isset($_POST["txtdocid"])) ? $_POST["txtdocid"] : '';
$acadyear = (isset($_POST["acadyear"])) ? $_POST["acadyear"] : '';
$txtDocDate = (isset($_POST["txtDocDate"])) ? $_POST["txtDocDate"] : '';
$txtdocfolder = (isset($_POST["txtdocfolder"])) ? $_POST["txtdocfolder"] : '';
$txtDocTitle = (isset($_POST["txtDocTitle"])) ? $_POST["txtDocTitle"] : '';
$txtComment = (isset($_POST["txtComment"])) ? $_POST["txtComment"] : '';
$btnsubmit = (isset($_POST["btnsubmit"])) ? $_POST["btnsubmit"] : '';
$session_id = session_id();
$create_by = $_SESSION[$session_id]["uname"];
$create_dep = $_SESSION[$session_id]["dep_id"];
$tbl_document = TBL_DOCUMENT . $dep_from . "_" . $acadyear;

if ($btnsubmit != '') {
// หาว่าหน่วยงานที่พิมพ์มีอยู่จริงมั้ย
    if ($str_dep_to != '') {
        $arr_dep = getDepartment(DATABASE, TBL_DEPARTMENT, '', $str_dep_to);
        if ($arr_dep != '') {
            // ถ้ามีจริง ให้เก็บค่าไว้
            foreach ($arr_dep as $index => $arr_temp) {
                $dep_to = $index;
                $dep_to_name = $arr_temp["dep_name"];
            } // end foreach
        } else {
            // ถ้าไม่มีก็เพิ่มใหม่
            $data = array(
                "dep_name" => "$str_dep_to",
                "last_update_by" => "$create_by",
                "last_update_date" => "NOW()"
            );
            $result = insert(TBL_DEPARTMENT, $data);
            if ($result) {
                $arr_dep = getDepartment(DATABASE, TBL_DEPARTMENT, '', $str_dep_to);
                if ($arr_dep != '') {
                    // ถ้ามีจริง ให้เก็บค่าไว้
                    foreach ($arr_dep as $index => $arr_temp) {
                        $dep_to = $index;
                        $dep_to_name = $arr_temp["dep_name"];
                    } // end foreach
                    $newdata = array(
                        "party_id" => $dep_to,
                        "last_update_by" => "$create_by",
                        "last_update_date" => date('Y-m-d')
                    );
                    update(TBL_DEPARTMENT, $newdata, "dep_id = '" . $dep_to . "'");
                }
            }
        } // end if
    } // end if

    if ($txtdocid != '') {
        // ถ้ามีเลขอยู่แล้ว ให้ update        
        $newdata = array(
            "doc_date" => $txtDocDate,
            "doc_title" => $txtDocTitle,
            "doc_folder" => $txtdocfolder,
            "comment" => $txtComment,
            "dep_id" => $dep_from,
            "dep_to" => $dep_to,
            "last_update_by" => $create_by,
            "doc_status" => $chkStatus
        );
        update($tbl_document, $newdata, "doc_id = '" . $txtdocid . "'");
    } else {
        // ถ้าไม่มีเลขให้เพิ่ม                
        $doc_id = getMax($tbl_document, 'doc_id', $dep_from);
        // ถ้าไม่มีก็เพิ่มใหม่
        $data = array(
            "dep_id" => $dep_from,
            "doc_id" => $doc_id,
            "dep_to" => $dep_to,
            "create_by" => $create_by,
            "create_dep" => $create_dep,
            "create_date" => date('Y-m-d'),
            "doc_status" => $chkStatus
        );
        // จองเลขก่อน
        $result = insert($tbl_document, $data);
        if ($result) {
            // เพิ่มข้อมูลการจอง
            ////Example of use:
            $newdata = array(
                "doc_date" => $txtDocDate,
                "doc_title" => $txtDocTitle,
                "doc_folder" => $txtdocfolder,
                "comment" => $txtComment,
                "dep_id" => $dep_from,
                "doc_id" => $doc_id,
                "dep_to" => $dep_to,
                "create_by" => $create_by,
                "create_dep" => $create_dep,
                "create_date" => date('Y-m-d'),
                "doc_status" => $chkStatus
            );
            update($tbl_document, $newdata, "doc_id = '" . $doc_id . "'");
            $txtdocid = $doc_id;
        } // end if
    }
} else {
    // ถ้าสุ่มมาตรงๆ ให้เด้งไปหน้าแรก
    $hidpage = 'index.php';
} // end if

?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=report_memo.php?doc=<?=encode($txtdocid)?>&page=<?= encode($hidpage) ?>&dep=<?=encode($dep_from)?>&y=<?=encode($acadyear)?><"/>
<?php
require 'template/footer_login.php';
?>