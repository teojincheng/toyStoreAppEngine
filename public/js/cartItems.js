/* 
 *Author: Teo Jin Cheng
 */




/**
 * 
 * @param {type} num
 * @returns {undefined}
 */

function fadeFunction(num) {

    var o = num.toString();

    $("#tr" + o).fadeOut("slow");
}



var numToLoop = counter;


function woah(numo){
    alert(numo);
}

function doThis(num){
    var n = "del" + num.toString();
    document.getElementById(n).addEventListener("click",function(){woah(num);});
}


for(i = 0; i < numToLoop; i++){
    doThis(i);
}
/*
for (i = 0; i < numToLoop; i++) {
    (function () {

        var n = "del" + i.toString();
        document.getElementById(n).addEventListener("click", function () {
            fadeFunction(i);
        });
    }());
}

*/
