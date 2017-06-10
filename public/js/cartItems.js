/* 
 *Author: Teo Jin Cheng
 *
 *When user clicks on the remove item link on the shopping cart page, 
 *make the table row of that toy disappear to simulate 
 *removing from cart.  
 */


/**
 * AJAX call to delete one item in the cart of the user. 
 * @param {type} cartId id of the entry in the cart datastore
 * @returns {undefined}
 */
function asyncDelete(cartId) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    }
    xmlhttp.open("GET", "updateCart.php?d=" + cartId, true);
    xmlhttp.send();
}

function asyncUpdate(cartId){
    var qtyNode = document.getElementById("itemQty"+cartId);
    var qty = parseInt(qtyNode.options[qtyNode.selectedIndex].value);
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    }
    xmlhttp.open("GET", "updateCart.php?u=" + cartId + "&q="+qty, true);
    xmlhttp.send();
}

/*
 * Calculate the total price of the items in the shopping cart after the person remove a item.
 * Sets the new total price in the html element
 * 
 */
function calculateNewTotal(num,arrOfIds) {
    var cartTotal = 0;
    var toRemoveIndex = arrOfIds.indexOf(num);
    arrOfIds.splice(toRemoveIndex,1);
    for (var i = 0; i < arrOfIds.length; i++) {
        
       

        var idToStr = arrOfIds[i].toString();

        var qtyNode = document.getElementById("itemQty" + idToStr);
        var priceNode = document.getElementById("unitPrice" + idToStr);

        var qty = parseInt(qtyNode.options[qtyNode.selectedIndex].value);
        var price = parseFloat(priceNode.innerHTML);
        var itemTotal = qty * price;

        cartTotal = cartTotal + itemTotal;
    
    }

    document.getElementById("cartTotalBottom").innerHTML = cartTotal.toString();
    document.getElementById("cartTotalSide").innerHTML = cartTotal.toString();

    /*
     var cartTotal = 0;
     var qtyList = document.getElementsByClassName("itemQty");
     var priceList = document.getElementsByClassName("unitPrice");
     
     for (var j = 0; j < qtyList.length; j++) {
     var qty = parseInt(qtyList[j].options[qtyList[j].selectedIndex].value);
     var price = parseFloat(priceList[j].innerHTML);
     var itemTotal = qty * price;
     
     cartTotal = cartTotal + itemTotal;
     
     }
     document.getElementById("cartTotalBottom").innerHTML = cartTotal.toString();
     document.getElementById("cartTotalSide").innerHTML = cartTotal.toString();
     */
}

/**
 * Make a tr element visually disappear from the html page. Then remove the node
 * from DOM. 
 * Call the AJAX function to update datastore
 * @param {type} num unique id of the tr we want to make disappear
 * 
 */

function fadeFunction(num,arrOfId) {

    var o = num.toString();

    $("#tr" + o).fadeOut("slow");

    var child = document.getElementById("tr" + o);
    child.parentElement.removeChild(child);
    setTimeout(function () {
        calculateNewTotal(num,arrOfId);
    }, 650);
    asyncDelete(o);

}

/**
 * Register element to event listener. 
 * @param {type} num unique id of the link element that the user clicks to 
 * reomove cart iem. 
 * 
 */

function addClickListener(num,arrOfId) {
    var n = "del" + num.toString();
    document.getElementById(n).addEventListener("click", function () {
        fadeFunction(num,arrOfId);
    });
}

function addChangeListener(num) {
    
    var p = "itemQty" + num.toString();
    document.getElementById(p).addEventListener("change",function(){asyncUpdate(num.toString());
    
    });

}


var cartIdsToReg = arrOfId;


/* 
 * For every 'remove item link' in the shopping cart, register the click listener. 
 * */

for (var i = 0; i < cartIdsToReg.length; i++) {
    addClickListener(cartIdsToReg[i],cartIdsToReg);
    addChangeListener(cartIdsToReg[i]);
}



