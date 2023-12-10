<?php
include ("config/config.inc.php");
include ("config/function.inc.php");
// print_r($_POST);
$txtusername = strtolower(TRIM($_POST["txtusername"]));
$txtpassword =  strtolower(TRIM($_POST["txtpass"]));
$ddlregister = (isset($_POST['ddlregister']) ? $_POST['ddlregister'] : 'register');

if (empty($txtusername) || empty($txtpassword)) {
    echo "<script>alert('กรุณากรอก Username และ Password');</script><meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
} else {

    $check = checkUser(TBL_EMPLOYEE, TBL_DEPARTMENT, $txtusername, $txtpassword, 'N');
    if (!$check) {
//error_reporting(0);  
        $server = 'cdc1.utcc-net.utcc-domain.local';
        $base_dn = 'DC=utcc-net,DC=utcc-domain,DC=local';
        $suffix = '@utcc.ac.th';
        $user = $txtusername;
        $pass = $txtpassword;
        /*
          $server = "10.7.46.102";
          $base_dn = "DC=utcc-net,DC=utcc-domain,DC=local";
          $suffix = "@utcc.ac.th";
          $user = "service-ad";
          $pass = "P@ssw0rd@1";
         */

        $ldap_conn = ldap_connect($server, 389);
// echo $ldap_conn . "<br>";
// ถ้าต้องการ search จำเป็นต้อง set option เป็น version 3 และ  
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        if (!$ldap_conn)
            die("Connect not connect to " . $server);
        $check = false;
// try our username/pass
        try {
            $ldap_bind = @ldap_bind($ldap_conn, $user . $suffix, $pass);
            if (!$ldap_bind) {
                echo "<script>alert('กรุณากรอก Username และ Password');</script><meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
//	die("Invalid user name and password");
//        session_destroy();
            } else {
                // echo "Login pass!<br>";
                $filter = "samaccountname=" . $user;
                $fields = array("department", "description");
                $sr = ldap_search($ldap_conn, $base_dn, $filter, $fields);
                $entries = ldap_get_entries($ldap_conn, $sr);
                //     print_r($entries);

                if ($entries[0]['count'] >= 1) {
                    // ถ้าหาคนนั้นเจอ

                    $check = checkUser(TBL_EMPLOYEE, TBL_DEPARTMENT, $txtusername, $txtpassword);
                    if (!$check) {
                        // หาไม่เจอในตาราง
//            print_r($entries);
                        $tmp_name = $entries[0]['description'][0];
                        $fullname = explode(" ", $tmp_name);
                        $dep_full_name = trim($entries[0]['department'][0]);
                        $left_pos = strripos($dep_full_name, "(") + 1;
                        $dep_full_name = substr($dep_full_name, $left_pos, strlen($dep_full_name));
                        $dep_full_name = substr($dep_full_name, 0, strlen($dep_full_name) - 1);
                        $dep_full_name = trim($dep_full_name);

                        // ค้นหา ID ของคณะ / สาขาวิชา
                        $arr_dep2 = getDepartment(DATABASE, TBL_DEPARTMENT, "", $dep_full_name);
                        // print_r($arr_dep2);
                        if ($arr_dep2 != "") {
                            // ถ้าเจอให้ เก็บไว้ในตัวแปร dep_form_id                        
                            foreach ($arr_dep2 as $dep_from_id => $arr_temp) {
                                echo "dep = " . $dep_from_id;
                                break;
                            } // end foreach

                            if ($dep_from_id != '') {
                                // inser new user
                                $data = array(
                                    "emp_username" => strtolower($txtusername),
                                    "emp_firstname" => $fullname[0],
                                    "emp_surname" => $fullname[1],
                                    "emp_email" => $txtusername . $suffix,
                                    "dep_id" => $dep_from_id,
                                    "from_ldap" => 'Y',
                                    'staff' => 'N'
                                );
                                $insert_result = insert(DATABASE . "." . TBL_EMPLOYEE, $data);
                                if ($insert_result) {
                                    $_SESSION["id"] = session_id();
                                    $session_id = session_id();
                                    $_SESSION[$session_id]["uname"] = strtolower($txtusername);
                                    $_SESSION[$session_id]["emp_firstname"] = $fullname[0];
                                    $_SESSION[$session_id]["emp_surname"] = $fullname[1];
                                    $_SESSION[$session_id]["emp_email"] = $txtusername . $suffix;
                                    $_SESSION[$session_id]["dep_id"] = $dep_from_id;
                                    $_SESSION[$session_id]["dep_name"] = $dep_full_name;
                                } // end if
                            } // end if
                        } else {
// ถ้าไม่เจอให้เด้งออกเลย
                            echo "<script>alert('ไม่พบคณะ / สาขาวิชาที่คุณสังกัดในระบบ โปรดติดต่อผู้ดูแลระบบ');</script><meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
                        } // end if   
                    } // end if
                } else {
                    // ถ้าหาไม่เจอ
                    echo "<script>alert('ไม่พบข้อมูลของคุณ โปรดติดต่อผู้ดูแลระบบ');</script><meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
                }
                // set cookie
            }
// ldap_unbind($ldap_bind);
            ldap_close($ldap_conn);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } // end if
    
    if ($check) {
        $_SESSION["id"] = session_id();
        $session_id = session_id();

        $_SESSION[$session_id]["chk_register"] = $ddlregister;
        $arr_update = array('last_login_date' => date('Y-m-d'));
        $str_where = "emp_username = '$txtusername'";
        update(TBL_EMPLOYEE, $arr_update, $str_where);
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>
        <?php
    } else {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php"/>
        <?php
    } // end if
} // end if
?>