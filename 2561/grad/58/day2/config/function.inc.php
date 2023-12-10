<?php

function checkLogin() {
    $returnvalue = true;
    $session_id = session_id();
    // check if user not log in by Sirivimol T. on 25-DEC-2012
    if ($session_id == '') {
        $returnvalue = FALSE;
        echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
    } else if ($_SESSION[$session_id]["uname"] == '') {
        $returnvalue = FALSE;
        echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
    }
    return $returnvalue;
}

function select($sql) {
    $result = '';
    $req = mysql_query($sql) or die("SQL Error: " . $sql . "" . mysql_error());
    while ($data = mysql_fetch_assoc($req)) {
        $result[] = $data;
    }
    return $result;

//    //Example of use:
//$sql = "SELECT * FROM mytable";
//$results = select($sql);
//print_r($results);
}


function checkUser($tbl_staff, $tbl_department, $txtusername, $txtpassword, $from_ldap = 'Y') {
    $return_status = false;
    if (($txtpassword != "") && ($txtusername != "")) {
        if ($from_ldap != '') {
            $str_add = " and from_ldap='" . $from_ldap . "' ";
        }
        if ($from_ldap == 'N') {
            $str_add .= " and s.emp_password = '" . $txtpassword . "' ";
        }
        
        $sql = "SELECT s.emp_username, s.emp_firstname, s.emp_surname, s.emp_email, s.dep_id, s.from_ldap,  s.last_login_date, s.last_update_date, d.dep_name , s.admin_status, s.staff
FROM " . DATABASE . ".$tbl_staff AS s 
Inner Join " . DATABASE . ".$tbl_department AS d ON d.dep_id = s.dep_id 
WHERE lower(s.emp_username) = '" . strtolower($txtusername) . "' " . $str_add;
//        echo $sql . "<br>";
        $result = mysql_query($sql);
        if ($result) {
            $numrow = mysql_num_rows($result);
            if ($numrow > 0) {
                $_SESSION["id"] = session_id();
                $session_id = session_id();
                while ($row = mysql_fetch_array($result)) {

                    $_SESSION[$session_id]["uname"] = strtolower($row["emp_username"]);
                    $_SESSION[$session_id]["emp_firstname"] = $row["emp_firstname"];
                    $_SESSION[$session_id]["emp_surname"] = $row["emp_surname"];
                    $_SESSION[$session_id]["emp_email"] = $row["emp_email"];
                    $admin_status = $row["admin_status"];
                    $_SESSION[$session_id]["admin"] = $admin_status;
                    $_SESSION[$session_id]["dep_id"] = $row["dep_id"];
                    $_SESSION[$session_id]["dep_name"] = $row["dep_name"];
                    $_SESSION[$session_id]["staff"] = $row["staff"];
                } // end while
                $return_status = true;
            }
        } // end if
    } // end if
    return $return_status;
}
// 27-AUG-2012 by Sirivimol T.
function getDepartment($dbname, $tbl_department, $dep_id = "", $dep_name = "", $party_id = '', $search_status = '') {
    $arr_return = "";
    $str_add = "";
    if ($dep_id != "") {
        $str_add = " `dep_id` = '$dep_id' and";
    } // end if
    if ($dep_name != "") {
        $str_add .= " `dep_name` = '$dep_name' and";
    } // end if    
    if ($party_id != "") {
        $str_add .= " `party_id` = '$party_id' and";
    } // end if
    if ($search_status != "") {
        $str_add .= " `search_status` = '$search_status' and";
    } // end if
    if ($str_add != "") {
        $str_add = "where " . substr($str_add, 0, strlen($str_add) - 3);
    }
    $sql = "select `dep_id`, `dep_name`, `party_id` from `$dbname`.`$tbl_department` $str_add order by `dep_name`, `dep_id`";
    //   echo $sql . "<br>";
    $result = mysql_query($sql);

    if ($result) {
        $numrow = mysql_num_rows($result);
//        echo $numrow . "<br>";
        if ($numrow > 0) {
            //           echo $result . "<br>";
            while ($row = mysql_fetch_array($result)) {
                $dep_id = $row["dep_id"];
                $dep_name = $row["dep_name"];
                $party_id = $row["party_id"];
                $arr_return[$dep_id]["dep_name"] = $dep_name;
                $arr_return[$dep_id]["party_id"] = $party_id;
            } // end while
        } // end if
    } // end if
    //   print_r($arr_return);
    return $arr_return;
}

function insert($table, $data) {
    $fields = "";
    $values = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $fields.=", ";
            $values.=", ";
        }
        $fields.="$key";
        $values.="'$val'";
        $i++;
    }
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";
    if (mysql_query($sql)) {
        return true;
    } else {
        print("SQL Error: " . $sql . "" . mysql_error());
        debug_to_console("SQL Error: " . $sql . "" . mysql_error());
        return false;
    }
//    //Example of use:
//$data = array(
//    "field1"=>"value1",
//    "field2"=>"value2",
//    "field3"=>"value3",
//);
//insert("mytable",$data);
}

function update($table, $data, $where) {
    $modifs = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $modifs.=", ";
        }
        if (is_numeric($val)) {
            $modifs.=$key . '=' . $val;
        } else if ($val == 'null') {
            $modifs.=$key . ' = null ';
        } else {
            $modifs.=$key . ' = "' . $val . '"';
        }
        $i++;
    }
    $sql = ("UPDATE $table SET $modifs WHERE $where");
    //  echo $sql;
    if (mysql_query($sql)) {
        return true;
    } else {
        die("SQL Error: " . $sql . "" . mysql_error());
        return false;
    }
    ////Example of use:
//$newdata = array(
//    "field1"=>"newvalue1",
//    "field2"=>"newvalue2",
//    "field3"=>"newvalue3",
//);
//update("mytable",$newdata,"myfieldid = 1");
}

function debug_to_console($data) {
    if (is_array($data)) {
        $arr_data = implode(",", $data);
    } else {
        $arr_data = $data;
    }
    $output = "<script>console.log( 'Debug Objects: " . mysql_real_escape_string($data) . "' ); </script>";
    echo $output;
}

// get max field by Sirivimol on 29-AUG-2012
function getMax($tblname, $field_name, $dep_id) {
    if ($dep_id != "") {
        $str_add = "where dep_id = '$dep_id'";
    } // end if
    $sql = "select max(`$field_name`) from $tblname $str_add";
// echo $sql;
    $result = mysql_query($sql);
    $max_id = 1;
    if ($result) {
        while ($row = mysql_fetch_array($result)) {
            $max_id = $row[0];
        }
    }
    $max_id++;
    return $max_id;
}

function getDepartment_v2($dbname, $tbl_department, $tbl_document, $dep_id, $dep_to = '') {
    // แสดงชื่อแผนกที่เคยส่งเอกสารกับคณะ / สาขาวิชา by Sirivimol T. 14-AUG-2013
    $arr_return = "";
    $str_add = '';
    if ($dep_id != "") {
        $str_add = " doc.`dep_id` = '$dep_id' and";
    } // end if
    if ($dep_to != "") {
        $str_add .= " doc.`dep_to` = '$dep_to' and";
    } // end if
    if ($str_add != "") {
        $str_add = " where " . substr($str_add, 0, strlen($str_add) - 3);
    }
    $sql = "SELECT dep.dep_id, dep.dep_name FROM " . $dbname . "." . $tbl_department . " AS dep INNER JOIN " . $dbname . "." . $tbl_document . " AS doc ON dep.dep_id = doc.dep_to
$str_add GROUP BY dep.dep_id, dep.dep_name order by  dep.dep_name";
//	echo $sql. "<br>";
    $result = mysql_query($sql);
    if ($result) {
        $numrow = mysql_num_rows($result);
//        echo "numrow = $numrow";
        if ($numrow > 0) {
            while ($row = mysql_fetch_array($result)) {
                $dep_id = $row["dep_id"];
                $dep_name = $row["dep_name"];
                $arr_return[$dep_id] = $dep_name;
//                echo "dep = " . $dep_id;
            } // end while
        } // end if
    } // end if
    return $arr_return;
}

function getEmployee($tbl_employee, $price_status = '', $emp_search_name = "", $dep_search_id = '', $give_up = 'N') {

    $str_add = "";
    if ($price_status == "Y") {
        $str_add .= " d.`prize_no` is not null and";
    } // end if        
    if ($emp_search_name != "") {
        $str_add .= " (d.`emp_firstname` like '%$emp_search_name%' or d.`emp_surname` like '%$emp_search_name%') and";
    } // end if
    if ($dep_search_id != "") {
        $str_add .= " d.`dep_id` = '$dep_search_id' and";
    } // end if   
	    if ($give_up != "") {
        $str_add .= " d.`give_up` = '$give_up' and";
    } // end if   

    if ($str_add != "") {
        $str_add = substr($str_add, 0, strlen($str_add) - 3);
        $str_add = " where " . $str_add;
    }
    $sql = "SELECT  d.* FROM $tbl_employee as d  $str_add  order by d.emp_id, d.party_name, d.dep_name, d.prize_no, d.emp_firstname, d.emp_surname ";
//     echo $sql . "<br>";
    $result = mysql_query($sql);
    //   echo $result . "<br>";
    return $result;
}

// paging for this page by Sirivimol on 02-JUL-2012    
function pageNumber($sql, $max_row, $url, $this_page, $dep_from = "", $dep_to = "", $tbl_doc_name = '') {        // count page        
    $str_page = "";
    $str_line = "";
    $total_row = 0;
    $resultS = mysql_query($sql);
    if ($resultS) {
        $row = mysql_fetch_row($resultS);
        $total_row = $row[0]; // total row
    }
    $total_page = ceil(($total_row / $max_row));

    if ($this_page == "") {
        $this_page = $total_page - 1;
    } else {
        $this_page--;
    }
    if ($this_page < 0) {
        $this_page = 0;
    }
    for ($i = 1; $i <= $total_page; $i++) {
        if ($i == ($this_page + 1)) {
            $current_style = 'class = "active" ';
        } else {
            $current_style = "";
        } // end if
        $str_line .= '<li ' . $current_style . ' ><a href="' . $url . '?p=' . $i . '&from=' . encode($dep_from) . '&to=' . encode($dep_to) . '&tbl=' . encode($tbl_doc_name) . '">' . $i . '</a></li>';
//        $str_line .= '<td $current_style ><a href=\"$url?p=$i&from=$dep_from&to=$dep_to#bottom\"><div>$i</div></a></td>';
    } // end for    
    $str_page = $str_line;
    if ($str_line != '') {
        echo '<nav><ul class="pagination" style="margin: 0px 0px 0px 0px;">
    <li>
      <a href="' . $url . '?p=1&from=' . encode($dep_from) . '&to=' . encode($dep_to) . '&tbl=' . encode($tbl_doc_name) . '" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>' . $str_line . '    
    <li>
      <a href="' . $url . '?p=' . ($i - 1) . '&from=' . encode($dep_from) . '&to=' . encode($dep_to) . '&tbl=' . encode($tbl_doc_name) . '" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul></nav>';
    } // end if

    $str_limit = calculateLimitSQL($this_page, $max_row);
//    // calculate
//    if (($this_page != "") || ($this_page == 0)) {
//        $start_limit = ($max_row * $this_page);
//        $str_limit = "limit $start_limit, $max_row";
//    } // end if
    return $str_limit;
}

// encryption by Sirivimol T. 05-OCT-2012
function encode($string) {
    $url_send = base64_encode(base64_encode($string));
    return $url_send;
}

// encryption by Sirivimol T. 05-OCT-2012
function decode($string) {
    $url_send = base64_decode(base64_decode($string));
    return $url_send;
}

function calculateLimitSQL($this_page, $max_row) {
    // calculate
    if ($this_page < 0) {
        $this_page = 0;
    }
    if (($this_page != "") || ($this_page == 0)) {
        $start_limit = ($max_row * $this_page);
        $str_limit = "limit $start_limit, $max_row";
    } // end if
    return $str_limit;
}

// 27-AUG-2012
function getDocument($tbl_department, $tbl_document, $dep_id, $doc_id = "", $doc_no, $doc_title, $dep_to = '', $approve_status, $receive_status, $doc_date_from, $doc_date_to, $doc_no_from = "", $doc_no_to = "", $str_limit = "") {
    $str_add = "";
    if ($dep_id != "") {
        $str_add .= " d.`dep_id` = '$dep_id' and";
    } // end if    
    if ($doc_id != "") {
        $str_add .= " d.`doc_id` = '$doc_id' and";
    } // end if
    if (($doc_no_from != "") && ($doc_no_to != "")) {
        $str_add .= " (d.`doc_id` between '$doc_no_from' and '$doc_no_to') and";
    } // end if
    if ($doc_no != "") {
        $str_add .= " d.`doc_no` like '%$doc_no%' and";
    } // end if
    if ($doc_title != "") {
        $str_add .= " d.`doc_title` like '%$doc_title%' and";
    } // end if
    if ($dep_to != "") {
        $str_add .= " d.`dep_to` = '$dep_to' and";
    } // end if   
    if ($approve_status != "") {
        $str_add .= " d.`approve_status` = '$approve_status' and";
    } // end if
    if ($receive_status != "") {
        $str_add .= " d.`receive_status` = '$receive_status' and";
    } // end 
    if (($doc_date_from != "") && ($doc_date_to != "")) {
        $str_add .= " (d.doc_date between '$doc_date_from' and '$doc_date_to') and";
    } // end if

    if ($str_add != "") {
        $str_add = substr($str_add, 0, strlen($str_add) - 3);
        $str_add = " where " . $str_add;
    }
    $sql = "SELECT  d.*,  dep.dep_name
FROM $tbl_document AS d Inner Join $tbl_department AS dep ON d.dep_to = dep.dep_id $str_add  order by d.doc_id desc $str_limit";
    // echo $sql . "<br>";
    $result = mysql_query($sql);
    //   echo $result . "<br>";
    return $result;
}

function thai_date($time) {
    // change date into Thai by Sirivimol T. on 10-JAN-2012
    $thai_date_return = "";

    if ($time != "") {

        $year = substr($time, 0, 4);
        $month = substr($time, 5, 2);
        $date = substr($time, 8, 2);

        $thai_month_arr = array(
            "00" => "",
            "01" => "ม.ค.",
            "02" => "ก.พ.",
            "03" => "มี.ค.",
            "04" => "เม.ย.",
            "05" => "พ.ค.",
            "06" => "มิ.ย.",
            "07" => "ก.ค.",
            "08" => "ส.ค.",
            "09" => "ก.ย.",
            "10" => "ต.ค.",
            "11" => "พ.ย.",
            "12" => "ธ.ค."
        );
        if ($date <= 0) {
            $date = '';
        }
        if ($month <= 0) {
            $str_month = '';
        } else {
            $str_month = $thai_month_arr[$month];
        }
        if ($year <= 0) {
            $year = '';
        } else {
            $year += 543;
        }
        $thai_date_return = $date . " " . $str_month . " " . $year;
    }
    return $thai_date_return;
}

function clearData($show_console = FALSE) {
    $newdata = array(
        "prize_no" => 'null',
    );
    $result = update(TBL_EMPLOYEE, $newdata, "prize_no IS NOT NULL OR prize_no <> '' ");
    if ($result) {
        if ($show_console) {
            echo "Clear data completed<br>";
        }
    } else {
        if ($show_console) {
            echo "Can not clear data<br>";
        }
    }
}

function drawing($limit, $show_console = FALSE) {
    // check if exist data
    $sql1 = "select count(*) as cnt from " . TBL_EMPLOYEE . " where prize_no is not null";

    $result1 = select($sql1);
    $count = 0;
//    echo "<pre>";
//    print_r($result1);
//    echo "</pre>";
    if ($result1) {
        $count = $result1[0]['cnt'];
//        echo ' cnt = ' . $count . "<br>";
    }// end if
    if ($count == 0) {
        // if no data
        $sql = 'SELECT * FROM ' . TBL_EMPLOYEE . ' where give_up = \'N\' ORDER BY RAND() LIMIT ' . $limit;
        $result = select($sql);
        if ($show_console) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        } // end if
        foreach ($result as $line => $arr_data) {
            $prize_no = $line + 1;
            $emp_id = $arr_data['emp_id'];
            // ถ้ามีเลขอยู่แล้ว ให้ update        
            $newdata = array(
                "prize_no" => $prize_no
            );
            update(TBL_EMPLOYEE, $newdata, "emp_id = '" . $emp_id . "'");
        }
    }
}

function showLucky($max_row = 5) {
    $sql2 = "select * from " . TBL_EMPLOYEE . " where (prize_no is not null)  order by prize_no";
    $result_show = select($sql2);
    $str = '';
    $str_div = '';
    $str_script = '';
    $old_cnt = 0;
    $cnt = 0;
    if ($result_show != '') {
        foreach ($result_show as $line => $row) {
            $status_show = false;
			$emp_id = $row["emp_id"];
            $firstname = $row["emp_firstname"];
            $surname = $row["emp_surname"];
            $prefix = $row["emp_prefix"];
            $dep_name = $row["dep_name"];
			$party_name = $row["party_name"];
            $str .= '<tr><td class="tdlucky">' . ($line + 1) . '.</td><td class="tdlucky">' . $prefix . " " . $firstname . " " . $surname . ' [ ' . $emp_id . ' ]<br><span class="tdlucky2">' . $party_name . " " . $dep_name . "</span></td></tr>";
            if ((($line + 1) % $max_row) == 0) {
                $status_show = true;
            } // end if

            if ($status_show) {
                $div_id = 'divlucky' . $cnt;

                $str_div .= '<div id="' . $div_id . '" class="divlucky" ><table>' . $str . '</table></div>';

                $str = '';
                $cnt++;
            }
        } // end foreach'
        if ($str != '') {
            $div_id = 'divlucky' . $cnt;
            $str_div .= '<div id="' . $div_id . '" class="divlucky"  ><table>' . $str . '</table></div>';
            $cnt++;
        }
        if ($cnt > 1) {
            $loop = $cnt * 7000;
            $str_script .= "showLucky ('divlucky',0, " . $cnt . "); setInterval(function(){showLucky ('divlucky',0, " . $cnt . ")}, " . $loop . ");";
        } else {
            $loop = 7000;
            $str_script .= "showLucky ('divlucky',0, " . $cnt . "); setInterval(function(){showLucky ('divlucky',0, " . $cnt . ")}, " . $loop . ");";
        }
        echo $str_div . "<script> " . $str_script . " </script>";
    } // end if
}

?>