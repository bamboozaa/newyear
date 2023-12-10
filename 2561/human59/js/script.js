// JavaScript Document
function checkBrowser() {
    var mybrowser = navigator.userAgent.toLowerCase();
    var version_browser = 0;
    var type_browser = '';
    var return_status = true;

    if (mybrowser.indexOf('msie') > 0) {
        type_browser = mybrowser.indexOf('msie');
        version_browser = parseInt(mybrowser.substring(type_browser + 5, mybrowser.indexOf(".", type_browser)));
//        alert("IE /// " + version_browser);
        if (version_browser < 8) {
            return_status = false;
        } // end if
    } else if (mybrowser.indexOf('firefox') > 0) {
        type_browser = mybrowser.indexOf('firefox');
        version_browser = parseInt(mybrowser.substring(type_browser + 8, mybrowser.indexOf(".", type_browser)));
//        alert("Firefox /// " + version_browser);
        if (version_browser < 25) {
            return_status = false;
        } // end if
    } else if (mybrowser.indexOf('presto') > 0) {
        type_browser = mybrowser.indexOf('presto');
        version_browser = parseInt(mybrowser.substring(type_browser + 7, mybrowser.indexOf(".", type_browser)));
//        alert("Opera /// " + mybrowser);        
        if (version_browser < 12) {
            return_status = false;
        } // end if    
    }
    return return_status;
}


function showDetail(func_name, divid, value1, value2, value3, value4, value5, value6, value7, value8, value9, value10) {
// by Sirivimol T. on 25-MAR-2013
    var url = "config/getinfo.php";
    var div = "#" + divid;
    var check = true;
//    alert(value1);
    var dataSet = {
        func: func_name,
        val1: value1,
        val2: value2,
        val3: value3,
        val4: value4,
        val5: value5,
        val6: value6,
        val7: value7,
        val8: value8,
        val9: value9,
        val10: value10
    };
    if (check) {
        $(div).html("<h1 align=\"center\"><span class=\"glyphicon glyphicon-refresh glyphicon-refresh-animate\"></span> <br>Loading...</h1>");

        $.post(url, dataSet, function(data) {

            $(div).html(data);
        });
    } else {
        $(div).html('');
    }
} // end showDetail
function showLucky(divid, start, end) {
    var count_start = 0; // 12 
    var div = '';
        for (var i = start; i <= end; i++) {
            div = '#' + divid + i;
            $(div).delay(count_start).fadeIn(1000);
            $(div).delay(5000).fadeOut(1000);
            count_start += 7000;
        } // end for        
    

}