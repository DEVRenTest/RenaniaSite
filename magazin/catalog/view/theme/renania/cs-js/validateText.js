//validate text on input type text
function validInputText(frm,txt_field){
    if(document.getElementById(txt_field).value != ''){
        return true;
    }
    return false;
}

function validInputPrice(frm,txt_field){
	var price=parseFloat(document.getElementById(txt_field).value);
    if(isNaN(price) || price<=0){
        alert("Va rugam sa introduceti un pret corect. ");
		//frm.txt_field.focus();
        return false;
    }
    return true;
}

//reset the default value of emails fields
function resetEmail(email_field){
    if(document.getElementById('emaila').value == 'nume@domeniu.extensie'){
        document.getElementById('emaila').value = '';
    }
    return true;
}

function validateAlert(frm){
	if(!validInputText(frm,'namea')){
		alert("Va rugam completati spatiul rezervat numelui dumneavoastra!");
        frm.name.focus();
        return false;
    }
	else if(!validateEmail(frm.email.value)){
		alert("Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.");
        frm.email.focus();
        return false;
	}
	else if(!validInputPrice(frm,'price')){
		frm.price.focus();
        return false;
	}
	else{
		frm.submit();
	}
}
function validateComment(frm){
    if(!validInputText(frm,'namec')){
        alert("Va rugam completati spatiul rezervat numelui dumneavoastra.");
        frm.name.focus();
    }


	else if(!validateEmail(frm.email.value)){
		 alert('Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.');
        frm.email.focus();
    }
	else if (!validInputText(frm,'comment')){
	  alert("Va rugam introduceti un text in campul de comentariu.");
	  frm.comment.focus();
	}
	else{
		frm.submit();
	}
}