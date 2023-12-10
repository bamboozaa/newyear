<?php
include("config.inc.php");
include("function.inc.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$func_name = $_POST["func"];
switch ($func_name) {
    case 'showReport' :
        //  print_r($_POST);
        $prize_status = $_POST['val1'];
        $search_name = (isset($_POST['val2'])) ? $_POST["val2"] : '';
        $dep_id_search = (isset($_POST['val3'])) ? $_POST["val3"] : '';
        $emp_id_search = (isset($_POST['val4'])) ? $_POST["val4"] : '';
        $check_register = (isset($_POST['val5'])) ? $_POST["val5"] : 'register';
        $result_doc = getEmployee(TBL_EMPLOYEE, $prize_status, $search_name, $dep_id_search, $emp_id_search, $check_register);
        $str_tr_class = '';
        if ($result_doc) {
            $str = "";
            $numrow = mysql_num_rows($result_doc);

            if ($numrow > 0) {
                ?>

                <p align="right"><button type="submit" name="btnsearch" id="btnsearch" value="ค้นหา"  class=" btn btn-success" ><span class="glyphicon glyphicon-download"></span> ดาวน์โหลดข้อมูล</button>
                </p>
                <table class="table table-striped table-hover table-condensed" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัส</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th>สาขา</th>       
                            <?php
                            foreach ($arr_chk_register as $index => $text) {
                                echo '<th>' . $text . '</th>';
                            } // end foreach 
                            ?>                            
                            <th >รางวัล</th>                      
                        </tr>                            
                    </thead>
                    <tbody>
                        <?php
                        $line = 1;
                        $str_link = '';
                        $str_link_end = '';
                        while ($row = mysql_fetch_array($result_doc)) {
                            $emp_id = $row["emp_id"];
                            $emp_prefix = $row["emp_prefix"];
                            $emp_firstname = $row["emp_firstname"];
                            $emp_surname = $row['emp_surname'];
                            $dep_name = $row['dep_name'];
                            $prize_no = $row["prize_no"];
                            $register = $row['register'];
                          
                            if ($register == 'Y') {
                                $str_register = '<span class="glyphicon glyphicon-ok"></span>';
                            } else {
                                $str_register = '';
                            }
                              $register2 = $row['register2'];
                            if ($register2 == 'Y') {
                                $str_register2 = '<span class="glyphicon glyphicon-ok"></span>';
                            } else {
                                $str_register2 = '';
                            }
                            $str .= "<tr $str_tr_class>
                                <td >$str_link" . $line . "$str_link_end</div>
                                <td >$str_link" . $emp_id . "$str_link_end</div>
                                    <td>$str_link " . $emp_prefix . " " . $emp_firstname . " " . $emp_surname . " $str_link_end</td>
                                    <td>$str_link $dep_name $str_link_end</td>                                                             
                                        <td>$str_link $str_register $str_link_end</td>                                                             
                                            <td>$str_link $str_register2 $str_link_end</td>           
                                        <td>$str_link $prize_no $str_link_end</td> 
                                </tr>";
                            $line++;
                        } // end while    

                        echo $str;
                        ?>
                    </tbody>
                </table>

                <?php
            } else {
                ?>

                <br>    
                <div class="alert alert-info" role="alert">
                    <strong>คำแนะนำ </strong> ไม่พบข้อมูล
                </div>

                <?php
            } // end if 
        } else {
            ?>
            <br>
            <div class="alert alert-danger" role="alert">
                <strong>คำเตือน </strong> หน่วยงานของท่านยังไม่เปิดใช้งานข้อมูลในส่วนนี้ โปรดติดต่อผู้พัฒนาระบบ
            </div>
            <?php
        } // end if

        break;
    case 'showDocDetail' :
//        print_r($_POST);
        $acadyear = $_POST['val1'];
        $dep_id = $_POST['val2'];
        $doc_id = $_POST['val3'];
        $str_cancel = '';
        $tbl_doc_name = TBL_DOCUMENT . $dep_id . '_' . $acadyear;
        $sql = "SELECT d.doc_id, d.dep_id, d.dep_to, d.doc_date, d.doc_title, d.doc_folder, d.doc_status, d.`comment`, d.create_dep, d.create_by, d.create_date, d.last_update_by, 
d.last_update_date, de.dep_name AS dep_name_to
FROM " . DATABASE . "." . $tbl_doc_name . " AS d
INNER JOIN " . DATABASE . '.' . TBL_DEPARTMENT . " AS de ON d.dep_to = de.dep_id
where d.doc_id='" . $doc_id . "' AND d.dep_id='" . $dep_id . "'";

        $result = select($sql);
        if ($result != '') {
            $arr_doc_from = getDepartment(DATABASE, TBL_DEPARTMENT, $dep_id);
            $doc_from_name = $arr_doc_from[$dep_id]['dep_name'];
//            print_r($result);
            foreach ($result as $row => $arr_temp) {
                $doc_id1 = $arr_temp['doc_id'];
                $doc_date1 = $arr_temp['doc_date'];
                $doc_to_name = $arr_temp['dep_name_to'];
                $doc_title = $arr_temp['doc_title'];
                $comment = $arr_temp['comment'];
                $create_by = $arr_temp['create_by'];
                $create_date = $arr_temp['create_date'];
                $create_dep = $arr_temp['create_dep'];
                $last_update_by = $arr_temp['last_update_by'];
                $last_update_date = $arr_temp['last_update_date'];
                $doc_status = $arr_temp['doc_status'];
            }
            $arr_create_dep = getDepartment(DATABASE, TBL_DEPARTMENT, $create_dep);
            $create_dep_name = $arr_create_dep[$create_dep]['dep_name'];

            if ($doc_status == 'C') {
                $str_tr_class = ' bg-danger ';
                $str_cancel = ' (ยกเลิก) ';
            } else {
                $str_tr_class = '';
                $str_cancel = '';
            }
            ?>
            <form action="" method="post" name="form1" id="form2" class="form-horizontal <?= $str_tr_class ?>">                    
                <div class="form-group">
                    <div class="col-sm-3 col-xs-3 "><strong>เลขทะเบียนส่ง</strong></div>
                    <div class="col-sm-3 col-xs-3"><?= $doc_id1 ?> / <?= $acadyear ?> <?= $str_cancel ?></div>                            
                    <div class="col-sm-3 col-xs-3 "><strong>วันที่ของเอกสาร</strong></div>
                    <div class="col-sm-3 col-xs-3"><?= thai_date($doc_date1) ?></div>
                </div>
                <div class="form-group">                         
                    <div class="col-sm-3 col-xs-3 "><strong>จาก</strong></div>
                    <div class="col-sm-3 col-xs-3"><?= $doc_from_name ?></div>
                    <div class="col-sm-3 col-xs-3 "><strong>ถึง</strong></div>
                    <div class="col-sm-3 col-xs-3"><?= $doc_to_name ?></div>
                </div>
                <div class="form-group">                            
                    <div class="col-sm-3 col-xs-3 "><strong>เรื่อง</strong></div>
                    <div class="col-sm-9 col-xs-9 "><?= nl2br($doc_title) ?></div>
                </div>                         
                <div class="form-group">
                    <div class="col-sm-3 col-xs-3 "><strong>หมายเหตุ</strong></div>
                    <div class="col-sm-9 col-xs-9"><?= nl2br($comment) ?></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-xs-3 "><strong>สร้างโดย</strong></div>
                    <div class="col-sm-3 col-xs-3"><?= $create_by ?> <br><?= $create_dep_name ?><br><?= thai_date($create_date) ?></div>
                    <div class="col-sm-3 col-xs-3 "><strong>แก้ไขล่าสุด</strong></div>
                    <div class="col-sm-3 col-xs-3"><?= $last_update_by ?> <br><?= thai_date($last_update_date) ?></div>
                </div>                       
            </form>      
            <?php
        } else {
            ?>
            <br>    
            <div class="alert alert-info" role="alert">
                <strong>คำแนะนำ </strong> ไม่พบข้อมูล
            </div>
            <?php
        } // end if        
        break;
    case 'showDrawing' :
        $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE;
        $result = select($sql);
        if ($result) {
            foreach ($result as $row => $value) {
                $limit = $value['mm'];
            }
        }
        // echo $limit;
        //   clearData(FALSE);
        drawing($limit);
        showLucky(5);
        break;
    case 'showLoop' :
        showLucky(5);
        break;
} // end switch
?>