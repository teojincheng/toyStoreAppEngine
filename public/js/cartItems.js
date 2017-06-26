/* 
 *Author: Teo Jin Cheng
 *
 *When user removes a cart item or change the qty of an item in the cart, update the datastore
 *and refresh the page. 
 *
 */


/**
 * When an item is removed from the cart, update the quantity as shown on the navbar cart logo.
 * @param {type} qty the amount of toys removed from the cart
 */
function navBarCartDelete(qty){
   var currQty = parseInt(document.getElementById("cartNum").innerHTML);
   var newQty = currQty - qty;
   document.getElementById("cartNum").innerHTML= newQty;
    
}

/**
 * When the user changes the qty of a item in cart. Query the datastore and find out what is the qty of 
 * each cart item. Update the quantity as shown on the navbar cart logo
 * 
 * @param {type} userid id the of the current user in the datastore 
 */
function getAllQuantity(userid){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var result = this.responseText;
            document.getElementById("cartNum").innerHTML = result;
        }
    }
    xmlhttp.open("GET", "updateCart.php?qr=" + userid, true);
    xmlhttp.send();
}






/**
 * AJAX call to delete one item in the cart of the user. 
 * @param {type} cartId id of the entry in the cart datastore
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
 * AJAX call to update qty of one cart item in the datastore
 * 
 * 
 * @param {type} cartId id of the entry of one item in the cart datastore
 * @param {type} arrOfId an array which contains id of the cart items in the datastore
 * @param {type} userid id of the logged in user in the user datastore
 * 
 */
function asyncUpdate(cartId, arrOfId,userid) {
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
            getAllQuantity(userid);
           
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
 * Make a tr element visually disappear from the page
 * then remove the node from DOM.Calls function to update datastore
 * 
 * @param {type} num unique id of the tr we want to make it fade
 * @param {type} arrOfId an array which contains id of the cart items in the datastore
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
    var idNumQty = "itemQty" + num.toString();
    var currQtyNode = document.getElementById(idNumQty);
    var qty = parseInt(currQtyNode.options[currQtyNode.selectedIndex].value);
    document.getElementById(idNum).addEventListener("click", function () {
        fadeFunction(num, arrOfId);
        navBarCartDelete(qty);
    });
}

/**
 * Register the change listener for the html qty dropdown.
 * 
 * @param {type} userid id of the current user in the datastore
 * @param {type} num id of the cart item in the datastore.
 * @param {type} arrOfId an array which contains id of the cart items in the datastore
 */

function addChangeListener(userid,num, arrOfId) {

    var idNum = "itemQty" + num.toString();
    
    document.getElementById(idNum).addEventListener("change", function () {
        asyncUpdate(num.toString(), arrOfId,userid);
    });

}




var cartIdsToReg = arrOfId;
var userId = currUserId;


/* 
 * For every item in the shopping cart, register the event listener. 
 * */

for (var i = 0; i < cartIdsToReg.length; i++) {
    addClickListener(cartIdsToReg[i], cartIdsToReg);
    addChangeListener(userId,cartIdsToReg[i], cartIdsToReg);
}



