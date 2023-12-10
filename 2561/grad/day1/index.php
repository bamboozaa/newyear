<?php require ('template/header_login.php'); ?>
<div class="container">
    <script>   $(document).ready(function() {
            var status = checkBrowser();
            if (status) {
                $('#divsignin').show();
                $('#divold').hide();
            } else {
                $('#divsignin').hide();
                $('#divold').show();
            }
        });
    </script>
    <h2 align="center"><?= APP_TITLE ?> <?= ACADYEAR ?></h2>
    <div id="divsignin">
        <form class="form-signin" action="chk_ldap.php" method="post" autocomplete="off">
            <h2 class="form-signin-heading" align="center">เข้าสู่ระบบ</h2>
            <div class="input-group">
                <label for="txtusername" class="sr-only">Username</label>
                <input type="text" id="txtusername" name="txtusername" class="form-control" placeholder="fullname_sur" required autofocus>
                <div class="input-group-addon">@utcc.ac.th</div>
            </div>
            <label for="txtpass" class="sr-only">Password</label>
            <input type="password" id="txtpass" name="txtpass" class="form-control" placeholder="Password" required><br>
            <button class="btn btn-lg btn-primary btn-block" type="submit" id="btnsubmit" name="btnsubmit">Sign in</button>
        </form>
                <p align="center"><br>
<br>
<br>
<a href="../day2/index.php"  class="btn btn-lg btn-success">
คลิกที่นี่เพื่อไปยัง <?=APP_TITLE?> 4 มี.ค. 60</a></p>
    </div>    

    </div>

    <div class="alert alert-danger" role="alert"  style="margin: auto; width: 100%; max-width: 450px; height: 200px; display:none;" id="divold">
        <strong>คำเตือน! </strong> คุณกำลังใช้ Internet Explorer รุ่นเก่าเกินกว่าที่ระบบจะทำงานได้ 
        กรุณาอัพเกรด Internet Explorer ของคุณ <br>
        <a href="http://www.google.com/chrome/"><div class="divbrowser"><img src="images/chrome.png" longdesc="http://www.google.com/chrome/"><br>
                Chrome</div></a>
        <a href="http://www.mozilla.com/firefox/"><div class="divbrowser"><img src="images/firefox.png" longdesc="http://www.mozilla.com/firefox/"><br>
                Firefox</div></a>
        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie"><div class="divbrowser"><img src="images/ie.png" longdesc="http://www.google.com/chrome/"><br>
                Internet Explorer</div></a></div>

</div>
<?php require ('template/footer_login.php'); ?>
