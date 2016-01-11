// JavaScript Document

function register_company () {
	document.form_register.company_option.value = document.form_register.company.value;
	document.form_register.continue_edit.value = 1;
	document.form_register.submit();
}

function register_samedelivery () {
	if (document.form_register.samedelivery.checked) document.form_register.samedelivery_option.value=1;
	else document.form_register.samedelivery_option.value=0;
	document.form_register.continue_edit.value = 1;
	document.form_register.submit();
}

function checkForgotEmail(){
	if (!(document.getElementById('forgotemail').value.indexOf(' ')==-1 && 0<document.getElementById('forgotemail').value.indexOf('@') && document.getElementById('forgotemail').value.indexOf('@')+1 < document.getElementById('forgotemail').value.length)){
			alert("Adresa de email introdusa nu este valida. Va rugam sa introduceti o adresa email valida si sa incercati din nou.");
			return false;
		}
		document.forgot_password.submit();
}

function checkLength(form){
	if (!(form.firstname.value.length)){
		alert("Va rugam sa introduceti prenumele si sa incercati din nou.");
		return false;
	}
	if (!(form.lastname.value.length)){
		alert("Va rugam sa introduceti numele si sa incercati din nou.");
		return false;
	}
	if (!(form.email.value.indexOf(' ')==-1 && 0<form.email.value.indexOf('@') && form.email.value.indexOf('@')+1 < form.email.value.length)){
		alert("Adresa de email introdusa nu este valida. Va rugam sa introduceti o adresa email valida si sa incercati din nou.");
		return false;
	}

	//if(!(form.password_generated.checked)){
		if (!(form.password.value.length)){
			alert("Va rugam sa alegeti o parola si sa incercati din nou.");
			return false;
		}
		if (form.password.value != form.password_confirm.value){

			alert("Cele doua parole introduse nu corespund. Va rugam sa introduceti aceeasi parola in ambele campuri si sa incercati din nou.");

			return false;
		}
	//}

	if (!(form.terms.checked)){
		alert("Pentru a putea continua trebuie sa fiti de acord cu termenii si conditiile {/literal}{$CSSITENAME}{literal}.");
		return false;
	}
	return true;
}