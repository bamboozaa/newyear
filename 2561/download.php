<?php
date_default_timezone_set("Asia/Bangkok");
$filename = "report" . date('Ymdhis') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: no-cache, must-revalidate");
include ("config/config.inc.php");
include ("config/function.inc.php");
$session_id = session_id();
// print_r($_POST);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//  print_r($_POST);
$prize_status = (isset($_POST['chkPrize'])) ? $_POST["chkPrize"] : '';
$search_name = (isset($_POST['txtempTitle_search'])) ? $_POST["txtempTitle_search"] : '';
$dep_id_search = (isset($_POST['ddldepartment'])) ? $_POST["ddldepartment"] : '';
$btn_submit = $_POST['btnsearch'];
if ($btn_submit != '') {
    $result_doc = getEmployee(TBL_EMPLOYEE, $prize_status, $search_name, $dep_id_search);
    $str_tr_class = '';
    if ($result_doc) {
        $str = "";
        $numrow = mysql_num_rows($result_doc);

        if ($numrow > 0) {
            ?>
            <table border="1">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        <th>คำนำหน้า</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <!--<th>หน่วยงาน</th>-->
                        <th>หน่วยงาน</th>
                        <th >รางวัล</th>  
                        <th >ลายเซ็น</th>                      
                    </tr>                            
                </thead>
                <tbody>
                    <?php
                    $line = 1;
                    $str_link = '';
                    $str_link_end = '';
                    while ($row = mysql_fetch_array($result_doc)) {
                        //$emp_id = $row["emp_id"];
                        $emp_prefix = $row["emp_prefix"];
                        $emp_firstname = $row["emp_firstname"];
                        $emp_surname = $row['emp_surname'];
                        $dep_name = $row['dep_name'];
                        $prize_no = $row["prize_no"];
						//$party_name = $row["party_name"];
                        $str .= "<tr $str_tr_class>
                                </div>
                                    <td>$str_link " . $emp_prefix .  " $str_link_end</td>
									<td>$str_link " . $emp_firstname .  " $str_link_end</td>                                        
                                    <td>$str_link " . $emp_surname . " $str_link_end</td>
									<td>$str_link $dep_name $str_link_end</td>
									<td>$str_link $prize_no $str_link_end</td>
									<td>&emsp;</td> 
                                </tr>";
                        $line++;
                    } // end while    

                    echo $str;
                    ?>
                </tbody>
            </table>
            <?php
        }
    }
} // end if        
?>
