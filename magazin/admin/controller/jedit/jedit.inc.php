<?php
//-----------------------------------------
// Author: Qphoria@gmail.com
// Web: http://www.theQdomain.com/
//-----------------------------------------
$this->load->language('jedit/jedit');
$_SESSION["jedit_tooltip"] 		= $this->language->get('text_tooltip');
$_SESSION["jedit_submit"]  		= $this->language->get('text_submit');
$_SESSION["jedit_indicator"]  	= $this->language->get('text_indicator');
$_SESSION["jedit_enabled"]  	= $this->language->get('text_enabled');
$_SESSION["jedit_disabled"]  	= $this->language->get('text_disabled');
$_SESSION["jedit_enabled"]  	= $this->language->get('text_enabled');
$_SESSION["jedit_disabled"]  	= $this->language->get('text_disabled');
$_SESSION["jedit_yes"]  		= $this->language->get('text_yes');
$_SESSION["jedit_no"]  			= $this->language->get('text_no');
print '<br/><script type="text/javascript" src="view/javascript/jquery/jquery.jeditable.mini.js"></script><br/>';
print '<script type="text/javascript" src="view/javascript/jquery/jedit.js.php"></script><br/>';
?>