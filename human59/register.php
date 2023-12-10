<?php
require 'template/header.php';
if (checkLogin()) {    
    $session_id = session_id();
    $check_status = (isset($_GET['stt'])) ? decode($_GET["stt"]) : '';
    $msg = (isset($_GET['msg'])) ? decode($_GET["msg"]) : '';
    switch ($check_status) {
        case 'Y' : $str_class = 'alert-success';
            $str_hide = '';
            break;
        case 'N' : $str_class = 'alert-danger';
            $str_hide = '';
            break;

        default : $str_hide = ' display: none';
            break;
    }
    $chk_register = $_SESSION[$session_id]['chk_register'];
    ?>
    <style>
        .jumbo {
            font-size: 30pt !important;

        }
    </style>    
    <script>
        $(document).ready(function() {
            $("#stu_id").focus();
        });
    </script>
    <div class='container'>    
        <form action="query_update.php" method="post">
            <div class="panel panel-default">
                <div class="panel-heading jumbo">ลงทะเบียน <?=$arr_chk_register[$chk_register]?></div>
                <div class="panel-body" >
                    <table><tr><td>
                                <span class='jumbo' >รหัสนักศึกษา :: </span>
                                <input name="stu_id" type="text" class=" jumbo " id="stu_id" maxlength="15" /></td><td>&nbsp;
                                <input name="button" type="submit" class="btn btn-primary jumbo" id="button" value="ลงทะเบียน" />
                                            <input name="hidchk" type="hidden"  id="hidchk" value="<?=$chk_register?>" />
                            </td></tr>
                    </table>
                </div>
        </form>    
    </div>    
    <div class="alert <?=$str_class?> jumbo" role="alert" style='<?= $str_hide ?>'><?= $msg ?></div>
    <?php
}
require 'template/footer_login.php';
?>
