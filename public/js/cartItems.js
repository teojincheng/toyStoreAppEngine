/* 
 *Author: Teo Jin Cheng
 *
 *When user clicks on the remove item link on the shopping cart page, 
 *make the table row of that toy disappear to simulate 
 *removing from cart.  
 */


/**
 * 
 * @param {type} num unique id of the tr we want to make disappear
 * 
 */

function fadeFunction(num) {

    var o = num.toString();

    $("#tr" + o).fadeOut("slow");
}

/**
 * 
 * @param {type} num unique id of the link element that the user clicks to 
 * reomove cart iem. 
 * 
 */

function addListener(num) {
    var n = "del" + num.toString();
    document.getElementById(n).addEventListener("click", function () {
        fadeFunction(num);
    });
}


var numToLoop = counter;

/* 
 * For every remove item link the shopping cart register the click listener. 
 * */
for (i = 0; i < numToLoop; i++) {
    addListener(i);
}

