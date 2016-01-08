
//check the length of the email field
function verifyEmail(frm,email_field){

    if (!(document.getElementById(email_field).value.indexOf(' ')==-1 && 0<document.getElementById(email_field).value.indexOf('@') && document.getElementById(email_field).value.indexOf('@')+1 < document.getElementById(email_field).value.length ) || document.getElementById(email_field).value == 'nume@domeniu.extensie'){
        alert("Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.");

        resetEmail(email_field);
        frm.email_field.focus();

        return false;
    }

    return true;
}

//validate text on input type text
function validInputText(frm,txt_field){
    if(document.getElementById(txt_field).value != ''){
        return true;
    }
    return false;
}

//reset the default value of emails fields
function resetEmail(email_field){
    if(document.getElementById(email_field).value == 'nume@domeniu.extensie'){
        document.getElementById(email_field).value = '';
    }
    return true;
}

//check the fields related with the recommend wishlist opperation
function validate(frm){
    //count the selected products, so I know if I need to execute the delete action or not
    if(validInputText(frm,'name') && verifyEmail(frm,'email') && validInputText(frm,'rname') && verifyEmail(frm,'remail')){
        //send form
        frm.submit();
    }
    else if(document.getElementById("name").value == ''){
        alert("Va rog completati spatiul rezervat numelui dumneavoastra!");
        frm.name.focus();
    }
    else if(document.getElementById("rname").value == ''){
        alert("Va rog completati spatiul rezervat numelui celui caruia doriti sa-i trimiteti recomandarea!");
        frm.rname.focus();
    }
}
