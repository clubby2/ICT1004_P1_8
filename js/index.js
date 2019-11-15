/*
function Modal(){
//'delzoneid.php?action=edit&device_id='+id+'&zn='+zone+'&name='+zname,
 $('.successmodal').load(function(){
    //$('#myModal1').find('.modal-title').text('Edit zone');
   $('#successmodal').modal({show:true});
 });
}
*/

function logins(){

  console.log("click");
  return false;
}

function validateEmail(email) {// valide function for email
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

$('#userform').on('submit', function(event) { // user login form
  closeModal=false;// check validation
var email = $("#email").val();
var password = $("#password").val();
var errorbth = $("#errorbth").val();
var erroremail = $("#erroremail").val();
var errorpassword = $("#errorpassword").val();
/*
if (email=="") {
  $("#erroremail").text("Emaill is Required!");
  $("#erroremail").show();
    closeModal=true;
}
else if (!validateEmail(email)){
  $("#erroremail").text("Invalid Emaill Address!");
  $("#erroremail").show();
    closeModal=true;
}

if (passsword=="") {
  $("#errorpassword").text("Password is Required!");
  $("#errorpassword").show();
    closeModal=true;
}*/




$.ajax({ // ajax from php validation
    url: 'process_login.php',
    type: 'POST',
   dataType: 'JSON',
   data: { login:'submit',email:email, password:password },
   success: function (data){

    console.log('data going in' + data.errorbth);
    if (data.errorbth=="" && data.errorpassword==""&& data.erroremail=="") {
      closeModal = true;
    }
    else{
      $("#errorbth").text(data.errorbth);
      $("#errorbth").show();
      $("#erroremail").text(data.erroremail);
      $("#erroremail").show();
      $("#errorpassword").text(data.errorpassword);
      $("#errorpassword").show();
    }
     //return closeModal;
         },
   error : function(request, status, errorThrown){
     console.log(request +''+ status +''+ errorThrown);
   },
   async: false

  });
  //alert(pw);

  return closeModal;
});
