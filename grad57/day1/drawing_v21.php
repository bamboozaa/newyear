<?php
header("Cache-Control: no-cache, must-revalidate");
include ("config/config.inc.php");
include ("config/function.inc.php");
$session_id = session_id();

if (checkLogin()) {
    $status = $_SESSION[$session_id]["admin"];

    if ($status != "Y") {
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=main_page.php"/>
        <?php
    } else {

        $sql = 'select max(prize_amount) as mm from ' . TBL_PRIZE;
        $result = select($sql);
        if ($result) {
            foreach ($result as $row => $value) {
                $prize_no = $value['mm'];
            }
        }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta http-equiv="cache-control" content="no-cache" />
                <meta http-equiv="cache-control" content="max-age=0" />
                <meta http-equiv="pragma" content="no-cache" />
                <meta http-equiv="expires" content="-1" />
                <meta name="viewport" content="width=device-width, initial-scale=1">

                <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
                <meta name="description" content=" <?= APP_TITLE ?>
                      Version
                      <?= APP_VERSION ?>">
                <meta name="author" content=" <?= APP_TITLE ?>
                      Version
                      <?= APP_VERSION ?>">
                <link rel="icon" href="images/favicon.ico">
                <title>
                    <?= APP_TITLE ?>
                    Version
                    <?= APP_VERSION ?>
                </title>
                <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
                <link href="css/styles.css" rel="stylesheet">
                <script src="js/jquery-1.11.3.js"></script>
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <script src="js/script.js"></script>
                <!-- slot machine -->
                <script src="jSlots/jquery.easing.1.3.js"></script><script src="jSlots/jquery.jSlots.min.js"></script>
                <script>
                    $(document).ready(function() {
                  //      Drawing();
                    });

                    function Drawing() {
                        showDetail('showDrawingV2', 'divdraw2');
                    }

                </script>
                <style type="text/css">
                    ul {
                        padding: 0;
                        margin: 0;
                        list-style: none;
                    }
                    .jSlots-wrapper {
                        overflow: hidden;
                        height: 20px;
                        display: inline-block; /* to size correctly, can use float too, or width*/
                        border: 1px solid #999;
                    }
                    .slot {
                        float: left;
                    }
                    input[type="button"] {
                        display: block;
                    }
                    /* ---------------------------------------------------------------------
                       FANCY EXAMPLE
                    --------------------------------------------------------------------- */
                    .fancy .jSlots-wrapper {
                        overflow: hidden;
                        height: 100px;
                        display: inline-block; /* to size correctly, can use float too, or width*/
                        border: 1px solid #999;
                    }
                    .fancy .slot li {
                        width: 100px;
                        line-height: 100px;
                        text-align: center;
                        font-size: 70px;
                        font-weight: bold;
                        color: #fff;
                        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.8);
                        font-family: inherit;
                        border-left: 1px solid #999;
                    }
                    .fancy .slot:first-child li {
                        border-left: none;
                    }
                    .fancy .slot li:nth-child(7) {
                        background-color: #FFCE29;
                    }
                    .fancy .slot li:nth-child(6) {
                        background-color: #FFA22B;
                    }
                    .fancy .slot li:nth-child(5) {
                        background-color: #FF8645;
                    }
                    .fancy .slot li:nth-child(4) {
                        background-color: #FF6D3F;
                    }
                    .fancy .slot li:nth-child(3) {
                        background-color: #FF494C;
                    }
                    .fancy .slot li:nth-child(2) {
                        background-color: #FF3333;
                    }
                    .fancy .slot li:nth-child(1), .fancy .slot li:nth-child(8), .fancy .slot li:nth-child(9), .fancy .slot li:nth-child(0) {
                        background-color: #FF0000;
                    }
                    .fancy .slot li span {
                        display: block;
                    }

                    /* ---------------------------------------------------------------------
                       ANIMATIONS
                    --------------------------------------------------------------------- */

                    @-webkit-keyframes winner {
                        0%, 50%, 100% {
                        -webkit-transform: rotate(0deg);
                        font-size:70px;
                        color: #fff;
                    }
                    25% {
                        -webkit-transform: rotate(20deg);
                        font-size:90px;
                        color: #FF16D8;
                    }
                    75% {
                        -webkit-transform: rotate(-20deg);
                        font-size:90px;
                        color: #FF16D8;
                    }
                    }
                    @-moz-keyframes winner {
                        0%, 50%, 100% {
                        -moz-transform: rotate(0deg);
                        font-size:70px;
                        color: #fff;
                    }
                    25% {
                        -moz-transform: rotate(20deg);
                        font-size:90px;
                        color: #FF16D8;
                    }
                    75% {
                        -moz-transform: rotate(-20deg);
                        font-size:90px;
                        color: #FF16D8;
                    }
                    }
                    @-ms-keyframes winner {
                        0%, 50%, 100% {
                        -ms-transform: rotate(0deg);
                        font-size:70px;
                        color: #fff;
                    }
                    25% {
                        -ms-transform: rotate(20deg);
                        font-size:90px;
                        color: #FF16D8;
                    }
                    75% {
                        -ms-transform: rotate(-20deg);
                        font-size:90px;
                        color: #FF16D8;
                    }
                    }
                    @-webkit-keyframes winnerBox {
                        0%, 50%, 100% {
                        box-shadow: inset 0 0 0px yellow;
                        background-color: #FF0000;
                    }
                    25%, 75% {
                        box-shadow: inset 0 0 30px yellow;
                        background-color: aqua;
                    }
                    }
                    @-moz-keyframes winnerBox {
                        0%, 50%, 100% {
                        box-shadow: inset 0 0 0px yellow;
                        background-color: #FF0000;
                    }
                    25%, 75% {
                        box-shadow: inset 0 0 30px yellow;
                        background-color: aqua;
                    }
                    }
                    @-ms-keyframes winnerBox {
                        0%, 50%, 100% {
                        box-shadow: inset 0 0 0px yellow;
                        background-color: #FF0000;
                    }
                    25%, 75% {
                        box-shadow: inset 0 0 30px yellow;
                        background-color: aqua;
                    }
                    }
                    .winner li {
                        -webkit-animation: winnerBox 2s infinite linear;
                        -moz-animation: winnerBox 2s infinite linear;
                        -ms-animation: winnerBox 2s infinite linear;
                    }
                    .winner li span {
                        -webkit-animation: winner 2s infinite linear;
                        -moz-animation: winner 2s infinite linear;
                        -ms-animation: winner 2s infinite linear;
                    }
                    /* Syntax Highlighter, ignore */
                    .dp-highlighter ol {
                        padding: 10px;
                    }
                </style>
            </head>
            <body style="background-color:#000;" >
                <div class="container">
                    <div id="divshow">
                        <div id="divbgdraw">
                            <div id='divdraw2' > <div id="content">
            <div class="fancy">
                <ul class="slot">
                    <!-- In reverse order so the 7s show on load -->
                                        <li><span>0</span></li>
                                        <li><span>9</span></li>
                    <li><span>8</span></li>
                    <li><span>7</span></li>
                    <li><span>6</span></li>
                    <li><span>5</span></li>
                    <li><span>4</span></li>
                    <li><span>3</span></li>
                    <li><span>2</span></li>
                    <li><span>1</span></li>
                </ul>
                <input type="button" id="playFancy" value="Play">
            </div>
        </div>
                <!-- Syntax highlighting, ignore this --> 
                <script src="jSlots/SyntaxHighlighter/Scripts/shCore.js" type="text/javascript" charset="utf-8"></script> 
                <script src="jSlots/SyntaxHighlighter/Scripts/shBrushCss.js" type="text/javascript" charset="utf-8"></script> 
                <script src="jSlots/SyntaxHighlighter/Scripts/shBrushJScript.js" type="text/javascript" charset="utf-8"></script> 
                <script src="jSlots/SyntaxHighlighter/Scripts/shBrushXml.js" type="text/javascript" charset="utf-8"></script> 
                <script language="javascript">
                    dp.SyntaxHighlighter.ClipboardSwf = '/flash/clipboard.swf';
                    dp.SyntaxHighlighter.HighlightAll('code', false, false)//, [collapseAll], [firstLine], [showColumns] );
                    //HighlightAll(name, [showGutter], [showControls], [collapseAll], [firstLine], [showColumns])
                </script> 
                <!-- /Syntax highlighting --> 
                <script>
				    $(document).ready(function() {
                    //------------ slot machine -------------//
     
                    // fancy example
                    $('.fancy .slot').jSlots({
                        number: 10,
                        spinner: '#playFancy',
                        easing: 'easeOutBounce',
                        time: 20000,
                        loops: 7,
												 endNumbers: [0, 1, 2,3,4,5,6,7,8,9],
                        onWin: function(winCount, winners, finalNumbers) {
                            
                            // react to the # of winning slots
                            if (winCount === 1) {
                                //alert('You got ' + winCount + ' 7!!!');
                            } else if (winCount > 1) {
                                //alert('You got ' + winCount + ' 7’s!!!');
                            }

                        }						
                    });
                    //------------ end slot machine -------------//
					});
                </script></div>
                        </div>
                        
                    </div>
                    <form class="navbar-form navbar-right" role="search" action ="main_page.php">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-home"></span> กลับสู่เมนูหลัก</button>
                    </form>
                </div>

            </body>
        </html><?php
    } // end if
} // end if 
?>