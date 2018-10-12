/** Top navigation bar stay on top of screen **/
/** Original code source and adepted from : https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_navbar_sticky **/
var navbar = document.getElementsByTagName('nav')[0];
var sticky = navbar.offsetTop;

function navStayOnTop() {
    if (window.pageYOffset > sticky) {
        navbar.classList.add("stickOnTop")
    } else {
        navbar.classList.remove("stickOnTop");
    }
}

/** Drop down menu for product and products page **/
/** Original code source and adepted from : https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_collapsible **/
var dropdown = document.getElementsByClassName("left-menu-dropdown");
var i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;

    if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "block";
    }
    });
}

/** Product function and validation check **/
function decValue() {
    var num = parseInt(document.getElementById("product-info-qty").value, 10);
    num = isNaN(num) ? 1 : num;

    if(num != 1 || num > 1) {
        num--;
    }

    document.getElementById("product-info-qty").value = num;

    calcTotalPrice();
}

function incValue() {
    var num = parseInt(document.getElementById("product-info-qty").value, 10);
    num = isNaN(num) ? 1 : num;
    num++;
    document.getElementById("product-info-qty").value = num;

    calcTotalPrice();
}

function getOption() {
    var opt = document.getElementById("opt").value;
    document.getElementsByName("option")[0].value = opt;

     for (var p in products) {
         // console.log(p);
         if (p == opt) { // find the product id
             var proPrice = products[p]["PRICE"];
             document.getElementById('price').innerHTML = proPrice;
             document.getElementById('description').innerHTML = products[p]["DESCRIPTION"];
             document.getElementsByName("price")[0].value = proPrice;
         }
         /** waste resources **/
         // for (var field in product[p]) {
         //     if(product[p].hasOwnProperty(field) && field == "PRICE")
         //        console.log(field + " -> " + product[p]["PRICE"]);
         // }
     }

     calcTotalPrice();
}

function calcTotalPrice() {
    var price = document.getElementsByName("price")[0].value;
    var qty = document.getElementById("product-info-qty").value;

    qty = (qty < 1 || isNaN(qty))? 1 : qty;
    document.getElementById("product-info-qty").value = qty;

    var total = qty * price;

    document.getElementById('price').innerHTML = total.toFixed(2);
}

/** Original code source and adepted from : https://www.w3schools.com/js/js_validation.asp **/
function validateForm() {
    var num = document.getElementById("product-info-qty").value;
    var opt = document.getElementsByName("option")[0].value;

    if(opt == "") {
        alert("Please select an option before proceed.");
        return false;
    }
}

function checkCardType() {
    var cardType = "";
    var regex    = /^(3|4|5|6)\d{3}[ ]?\d{4,6}[ ]?\d{4,5}[ ]?(?:[0-9]{0,7})$/;
    var number   = document.getElementById("ccNo").value;

    number = number.replace(/\s/g, '');

    if(number.match(regex)){
        if(number.substring(0, 1) == "4") {
            cardType = '<i class="fa fa-cc-visa"></i>';
        } else if (number.substring(0, 1) == "3"){
            cardType = '<i class="fa fa-cc-amex"></i>';
        } else if (number.substring(0, 1) == "5") {
            cardType = '<i class="fa fa-cc-mastercard"></i>';
        } else if (number.substring(0, 1) == "6") {
            cardType = '<i class="fa fa-cc-discover"></i>';
        }
    } else {
        cardType = '<i class="fa fa-credit-card"></i>';
    }

    document.getElementById("cardLogo").innerHTML = cardType;
}
