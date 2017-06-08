/* 
 *Author: Teo Jin Cheng
 *
 *When user clicks on the remove item link on the shopping cart page, 
 *make the table row of that toy disappear to simulate 
 *removing from cart.  
 */





/*
 * Calculate the total price of the items in the shopping cart after the person remove a item.
 * Sets the new total price in the html element
 * 
 */
function calculateNewTotal(){
    var cartTotal = 0;
    var qtyList = document.getElementsByClassName("itemQty");
    var priceList = document.getElementsByClassName("unitPrice");
    
   
    
    for(var j = 0; j < qtyList.length; j++){
       var qty = parseInt(qtyList[j].innerHTML);
       var price = parseFloat(priceList[j].innerHTML);
       var itemTotal = qty * price;
       
       cartTotal = cartTotal + itemTotal;
       
    }
    
   
    document.getElementById("cartTotalBottom").innerHTML = cartTotal.toString();
  
    document.getElementById("cartTotalSide").innerHTML = cartTotal.toString();

    
 }




/**
 * Make a tr element disappear from the html page. 
 * @param {type} num unique id of the tr we want to make disappear
 * 
 */

function fadeFunction(num) {

    var o = num.toString();

    $("#tr" + o).fadeOut("slow");
    
    var child = document.getElementById("tr"+o);
    child.parentElement.removeChild(child);
    setTimeout(function(){calculateNewTotal();},650);
    
}

/**
 * Register element to event listener. 
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
 * For every 'remove item link' in the shopping cart, register the click listener. 
 * */
for (i = 0; i < numToLoop; i++) {
    addListener(i);
}




