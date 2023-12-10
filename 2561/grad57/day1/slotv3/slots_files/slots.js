
//note parseInt
//note stop


var opts = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];





$(document).ready(
        function() {
            addSlots($("#slots_0 .wrapper"));
            addSlots($("#slots_1 .wrapper"));
            addSlots($("#slots_2 .wrapper"));
            addSlots($("#slots_3 .wrapper"));
            addSlots($("#slots_4 .wrapper"));
            addSlots($("#slots_5 .wrapper"));
            addSlots($("#slots_6 .wrapper"));
            addSlots($("#slots_7 .wrapper"));
            addSlots($("#slots_8 .wrapper"));
            addSlots($("#slots_9 .wrapper"));
        }
);


function addSlots(jqo) {
    for (var j = 0; j < 3; j++) {
        for (var i = 0; i < 10; i++) {
            //var ctr = Math.floor(Math.random() * opts.length);
            var ctr = i;
            jqo.append("<div class='slot'>" + opts[ctr] + "</div>");

        }
    }
}

function moveSlots(jqo, endNum) {
    var time = 8000; // 8 SECONDS
    time += Math.round(Math.random() * 1000);
    jqo.stop(true, true);

    var marginTop = parseInt(jqo.css("margin-top"), 10)
//alert(endNum);
    endNum += 30;
    marginTop -= (endNum * 100)

    jqo.animate(
            {"margin-top": marginTop + "px"},
    {'duration': time, 'easing': "easeOutBounce"});

}
