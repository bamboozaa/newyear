<?php
require 'template/header.php';
if (checkLogin()) {

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */
    $chk_d = false;
    $emp_id = (isset($_POST['stu_id'])) ? $_POST["stu_id"] : '';
$chk_register = (isset($_POST['hidchk']) ? $_POST['hidchk'] : 'register');

    $sql = "select * from " . DATABASE . "." . TBL_EMPLOYEE . " where emp_id = '" . mysql_real_escape_string($emp_id) . "'";
    $result = select($sql);
//    print_r($result);
    $emp_id1 = '';
    if ($result) {
        foreach ($result as $row => $value) {
            $emp_id1 = $value['emp_id'];
        }
        if ($emp_id1 != '') {
            $chk_d = true;
        }
    } // end if

    if ($chk_d) {        
        $sql = "update `" . DATABASE . "`.`" . TBL_EMPLOYEE . "` set " . $chk_register . "='Y' , give_up='N'  where emp_id='" . mysql_real_escape_string($emp_id) . "'";
        //      echo $sql;
        if (mysql_query($sql)) {
            $msg = 'รหัส ' . $emp_id . " ลงทะเบียนเรียบร้อยแล้ว";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=register.php?msg=" . encode($msg) . "&stt=" . encode('Y') . "\">";
        } else {
            echo mysql_error();
        }
        //}
    } else {
        $msg = 'ไม่พบข้อมูลนักศึกษา กรุณาเพิ่มข้อมูลก่อน';
        echo "<script> alert('$msg');</script>";        
        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=register.php?msg=" . encode($msg) . "&stt=" . encode('N') . "\">";
    }
} // end if
require 'template/footer_login.php';
?>
