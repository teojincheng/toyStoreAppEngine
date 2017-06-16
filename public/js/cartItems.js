/* 
 *Author: Teo Jin Cheng
 *
 *When user removes a cart item or change the qty of an item in the cart, update the datastore
 *and refresh the page. 
 *
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
            
        }
    }
    xmlhttp.open("GET", "updateCart.php?d=" + cartId, true);
    xmlhttp.send();
}

/**
 * AJAX call to update the qty of one cart item in the datastore
 * @param {type} cartId id of the entry of one item in the cart datastore
 * @param {type} arrOfId an array which contains id of the cart items in the datastore
 * @returns {undefined}
 */
function asyncUpdate(cartId, arrOfId) {
    var qtyNode = document.getElementById("itemQty" + cartId);
    var qty = parseInt(qtyNode.options[qtyNode.selectedIndex].value);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            calculateTotal(arrOfId);
           
        }
    }
    xmlhttp.open("GET", "updateCart.php?u=" + cartId + "&q=" + qty, true);
    xmlhttp.send();
}

/**
 * Caculate the total cost of the items in the cart based on the html markup. 
 * Used when user only changes the qty of a cart item.
 * 
 * @param {type} arrOfIds an array which contains id of the cart items in the datastore

 */
function calculateTotal(arrOfIds) {
    var cartTotal = 0;
    for (var i = 0; i < arrOfIds.length; i++) {
        var idToStr = arrOfIds[i].toString();

        var qtyNode = document.getElementById("itemQty" + idToStr);
        var priceNode = document.getElementById("unitPrice" + idToStr);

        var qty = parseInt(qtyNode.options[qtyNode.selectedIndex].value);
        var price = parseFloat(priceNode.innerHTML);
        var itemTotal = qty * price;

        cartTotal = cartTotal + itemTotal;
    }
    document.getElementById("cartTotalBottom").innerHTML = cartTotal.toFixed(2);
    document.getElementById("cartTotalSide").innerHTML = cartTotal.toFixed(2);
}

/**
 * 
 * Calculate the total price of the items in the shopping cart after the person remove a item.
 * Sets the new total price in the html element
 * 
 * @param {type} num id of the cart item in the datastore
 * @param {type} arrOfIds an array which contains id of the cart items in the datastore
 */
function calculateNewTotal(num, arrOfIds) {
    var cartTotal = 0;
    var toRemoveIndex = arrOfIds.indexOf(num);
    arrOfIds.splice(toRemoveIndex, 1);
    for (var i = 0; i < arrOfIds.length; i++) {

        var idToStr = arrOfIds[i].toString();

        var qtyNode = document.getElementById("itemQty" + idToStr);
        var priceNode = document.getElementById("unitPrice" + idToStr);

        var qty = parseInt(qtyNode.options[qtyNode.selectedIndex].value);
        var price = parseFloat(priceNode.innerHTML);
        var itemTotal = qty * price;

        cartTotal = cartTotal + itemTotal;

    }

    document.getElementById("cartTotalBottom").innerHTML = cartTotal.toFixed(2);
    document.getElementById("cartTotalSide").innerHTML = cartTotal.toFixed(2);


}

/**
 * Make a tr element visually disappear from the html page. Then remove the node
 * from DOM. 
 * Call the AJAX function to update datastore
 * @param {type} num unique id of the tr we want to make disappear
 * 
 */

function fadeFunction(num, arrOfId) {

    var idNum = num.toString();

    $("#tr" + idNum).fadeOut("slow");

    var child = document.getElementById("tr" + idNum);
    child.parentElement.removeChild(child);
    setTimeout(function () {
        calculateNewTotal(num, arrOfId);
    }, 650);
    asyncDelete(idNum);
    
    
    
    if(arrOfId.length == 1){
        var mainContent = document.getElementById("mainContent");
        mainContent.innerHTML = "<div class='col-md-9'><p id='noItem'>No items in your cart</p></div>";
    }

}

/**
 * Register the click listener for a remove cart item link
 * 
 * @param {type} num id of the cart item in the datastore
 * @param {type} arrOfId an array which contains id of the cart items in the datastore
 */

function addClickListener(num, arrOfId) {
    var idNum = "del" + num.toString();
    document.getElementById(idNum).addEventListener("click", function () {
        fadeFunction(num, arrOfId);
    });
}

/**
 * Register the change listener for the item qty dropdown
 * 
 * @param {type} num id of the cart item in the datastore
 * @param {type} arrOfId arrOfId an array which contains id of the cart items in the datastore
 */

function addChangeListener(num, arrOfId) {

    var idNum = "itemQty" + num.toString();
    document.getElementById(idNum).addEventListener("change", function () {
        asyncUpdate(num.toString(), arrOfId);

    });

}


var cartIdsToReg = arrOfId;


/* 
 * For every item in the shopping cart, register the event listener. 
 * */

for (var i = 0; i < cartIdsToReg.length; i++) {
    addClickListener(cartIdsToReg[i], cartIdsToReg);
    addChangeListener(cartIdsToReg[i], cartIdsToReg);
}



