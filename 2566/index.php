<?php require ('template/header_login.php'); ?>
<script>
$(document).ready(function() {
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
<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
<!-- <div class="container" style="position: absolute; left:30%; top: 25%; font-family: 'Kanit', sans-serif;"> -->
<div class="container" style="font-family: 'Kanit', sans-serif;">
	<div class="panel-default col-md-6 col-sm-10 shadow" id="divsignin" style="position:absolute">
    	<div class="panel-heading">
        	<div class="panel-title"><h1 align="center"><?= APP_TITLE ?> <?= ACADYEAR ?></h1></div>
        </div>
        <form class="form-signin" action="chk_ldap.php" method="post" autocomplete="off">
        <div class="panel-body">
        	<h2 class="form-signin-heading" align="center">เข้าสู่ระบบ</h2>
            <div class="input-group">
                <input type="text" id="txtusername" name="txtusername" class="form-control" placeholder="fullname_sur" required autofocus>
                <div class="input-group-addon">@utcc.ac.th</div>
			</div>
            <input type="password" id="txtpass" name="txtpass" class="form-control" placeholder="password" required><br>   
		</div>
        	<button class="btn btn-lg btn-primary btn-block" type="submit" id="btnsubmit" name="btnsubmit">Sign in</button>
        </form>
    </div>  
</div>

<div class="alert alert-danger" role="alert"  style="margin: auto; width: 100%; max-width: 450px; height: 200px; display:none;" id="divold">
	<strong>คำเตือน! </strong> คุณกำลังใช้ Internet Explorer รุ่นเก่าเกินกว่าที่ระบบจะทำงานได้ กรุณาอัพเกรด Internet Explorer ของคุณ <br>
    <a href="http://www.google.com/chrome/">
    	<div class="divbrowser">
        	<img src="images/chrome.png" longdesc="http://www.google.com/chrome/">
        	<br>Chrome
		</div>
	</a>
    <a href="http://www.mozilla.com/firefox/">
    	<div class="divbrowser">
        	<img src="images/firefox.png" longdesc="http://www.mozilla.com/firefox/">
            <br>Firefox
		</div>
	</a>
    <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
    	<div class="divbrowser">
        	<img src="images/ie.png" longdesc="http://www.google.com/chrome/">
            <br>Internet Explorer
		</div>
	</a>
</div>

<?php require ('template/footer_login.php'); ?>
