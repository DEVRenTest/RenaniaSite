<?php
@session_start(); //Start our session.
header("Cache-Control: no-store, no-cache"); //Tell the browser to not cache this page (don't store it in the internet temp folder).
header("Content-type: text/javascript"); //Let the browser think that this is a Javascript page.
?>

function AddLibrary(file){
	var NewScript=document.createElement('script');
	NewScript.src=file+".js";
	document.body.appendChild(NewScript);
}

function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}

$(document).ready(function() {

	//AddLibrary('view/javascript/jquery/jquery.jeditable.mini.js');
	
	// Set variables to session values
	var token 			= '<?php echo $_SESSION['token']; ?>';
	var jedit_disabled 	= '<?php echo $_SESSION["jedit_disabled"]; ?>';
	var jedit_enabled 	= '<?php echo $_SESSION["jedit_enabled"]; ?>';
	var tooltip 		= '<?php echo $_SESSION["jedit_enabled"]; ?>';
	var submit 			= '<?php echo $_SESSION["jedit_enabled"]; ?>';
	var indicator		= '<?php echo $_SESSION["jedit_enabled"]; ?>';
	var jedit_no		= '<?php echo $_SESSION["jedit_no"]; ?>';
	var jedit_yes		= '<?php echo $_SESSION["jedit_yes"]; ?>';

	
	// Get Token from URL and other defaults if session passing isn't working
	if (!token) {token = getURLParameter('token');}
	if (!jedit_disabled) { jedit_disabled = 'Disabled'; }
	if (!jedit_enabled) { jedit_enabled = 'Enabled'; }
	if (!tooltip) { tooltip = 'Dbl-Click to Edit'; }
	if (!submit) { submit = 'Ok'; }
	if (!indicator) { indicator = '<img src="view/javascript/jquery/jeditload.gif" alt="Saving..."/>'; }
	if (!jedit_no) { jedit_no = 'No'; }
	if (!jedit_yes) { jedit_yes = 'Yes'; }

	// Set this to preference on what you want to happen when you click outside an active jedit box
	var blur		= 'submit'; //cancel, submit, ignore
	var event		= 'dblclick'; //click, dblclick


	$('.edit_text').editable('index.php?route=jedit/jedit/jEditSaveText&token='+token, {
		event		: event,
		onblur		: blur,
		tooltip		: tooltip,
		indicator	: indicator,
		data   		: function(value) {
						var retval = value.replace(/&gt;/gi, '>');
						var retval = retval.replace(/&amp;/gi, '&');
						var splitval = retval.split('>');
						return splitval[splitval.length-1];
					}
	});

	// Statically Loaded Select Boxes
	$('.edit_select_status').editable('index.php?route=jedit/jedit/jEditSaveStatus&token='+token, {
		type   		: 'select',
		event		: event,
		submit 		: submit,
		onblur 		: blur,
		tooltip		: tooltip,
		indicator	: indicator,
		data   		: {'0':jedit_disabled,'1':jedit_enabled}
	});

	$('.edit_select_yesno').editable('index.php?route=jedit/jedit/jEditSaveYesNo&token='+token, {
		type   		: 'select',
		event		: event,
		submit 		: submit,
		onblur 		: blur,
		tooltip		: tooltip,
		indicator	: indicator,
		data   		: {'0':jedit_no,'1':jedit_yes}
	});

	// Dynamically Loaded Select Boxes
	$('.edit_select_order_status').editable('index.php?route=jedit/jedit/jEditSaveOrderStatuses&token='+token, {
		type   		: 'select',
		event		: event,
		onblur 		: blur,
		submit 		: submit,
		loadurl		: 'index.php?route=jedit/jedit/jEditLoadOrderStatuses&token='+token
	});

	$('.edit_select_customer_group').editable('index.php?route=jedit/jedit/jEditSaveCustomerGroups&token='+token, {
		type   		: 'select',
		event		: event,
		onblur 		: blur,
		submit 		: submit,
		loadurl		: 'index.php?route=jedit/jedit/jEditLoadCustomerGroups&token='+token
	});
});