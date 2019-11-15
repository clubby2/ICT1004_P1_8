/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function div1() {
 document.getElementById("products").style.display="block";
 document.getElementById("others").style.display="none";
}
function div2() {
 document.getElementById("others").style.display="block";
 document.getElementById("products").style.display="none";
}

function adminproduct() {
 document.getElementById("adminProducts").style.display="block";
 document.getElementById("adminCustomers").style.display="none";
}
function admincustomers() {
 document.getElementById("adminCustomers").style.display="block";
 document.getElementById("adminProducts").style.display="none";
}



var $add = document.querySelector('.plus-btn');
var $minus = document.querySelector('.minus-btn');
var $counter = document.querySelector('.counter');

$('.plus-btn').on('click', function(e){
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    if (value < 99){
        value = value + 1;
    }
    else{
        value = 1;
    }
    $input.val(value);
});

$('.minus-btn').on('click', function(e){
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    if (value > 2){
        value = value - 1;
    } else{
        value = 1;
    }
    $input.val(value);
});

/*

$add.addEventListener('click', function(e){
  e.preventDefault();
  $counter.value = parseInt($counter.value) + 1; // `parseInt` converts the `value` from a string to a number
}, false);
});
*/
