function validateCardForm() {
    //Validate Card Name
    var cName = /^[a-zA-Z ]+$/;
    var a = document.forms["myCardForm"]["cardName"].value;
    if (a == "") {
        alert("Card Name must be filled out");
        return false;
    } else if (!cName.test(a)) {
        alert('Please enter a valid name');
        return false;
    }
    
    //Validate Card Number
    var visa = /^([4]{1})([0-9]{12,15})$/;
    var mastercard = /^5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}$/;
    var cardtype = document.forms["myCardForm"]["cardtype"].value;
    var b = document.forms["myCardForm"]["cardNum"].value;
    if (b == "") {
        alert("Card number must be filled out");
        return false;
    } else if (b.length < 16) {
        alert("Card number must have 16 digits");
        return false;
    } else if (cardtype == "Visa") {
        if (!visa.test(b)) {
            alert('Please enter a valid visa card number');
            return false;
        }
    } else if (cardtype == "Mastercard") {
        if (!mastercard.test(b)) {
            alert('Please enter a valid master card number');
            return false;
        }
    }
    
    //Validate Expiry Date
    var expDateValidate = /^(0[1-9]|1[012])[/]([2-9][0-9])+$/;
    var c = document.forms["myCardForm"]["expDate"].value;
    if (c == "") {
        alert("Expiry date must be filled out");
        return false;
    } else if (!expDateValidate.text(c)){
        alert('Please enter a valid date');
        return false;
    }

    //Validate CVV
    var cvvValidate = /^(?!000)[0-9]{3}$/;
    var d = document.forms["myCardForm"]["cvc"].value;
    if (d == "") {
        alert("CVC/CVV code must be filled out");
        return false;
    } else if (d.length < 3) {
        alert("CVV/CVC code must have 3 digits");
        return false;
    } else if (!cvvValidate.test(d)){
        alert("Please enter a valid CVV code.");
        return false;
    }
}

function validateAddrForm() {
    //Validate Address
    var addrName = /^[A-Za-z0-9\-\(\)#@(\) ]+$/;
    var x = document.forms["myAddrForm"]["addr"].value;
    if (x == "") {
        alert("Address must be filled out");
        return false;
    } else if (!addrName.test(x)) {
        alert('Please enter a valid address');
        return false;
    }

    //Validate Postal Code
    var y = document.forms["myAddrForm"]["postalcode"].value;
    if (y == "") {
        alert("Postal code must be filled out");
        return false;
    } else if (y.length < 6) {
        alert("Postal code must have 6 digits");
        return false;
    }
}
