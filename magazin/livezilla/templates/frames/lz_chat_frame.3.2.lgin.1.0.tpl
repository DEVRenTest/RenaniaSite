<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--html-->
<head>
	<META NAME="robots" CONTENT="noindex,follow">
	<title><!--config_gl_site_name--></title>
	<link rel="stylesheet" type="text/css" href="<!--server-->templates/style_chat.css">
</head>
<body style="padding-bottom:38px;">
	<!--alert-->
	<div id="lz_chat_loading"><!--lang_client_loading--> ...<div><img src="<!--server-->images/chat_loading.gif" alt="" border="0"></div></div>
	<!--errors-->
    <div id="lz_chat_navigation">
        <div id="lz_chat_navigation_status" class="lz_chat_navigation_status_offline">
            <!--lang_client_tab_chat-->
        </div>
        <table width="100%" height="100%" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="15"></td>
                <td>
                    <ul class="lz_chat_navigation_tabs">
                        <li id="lz_tab_chat" class="lz_chat_navigation_tab" onclick="parent.parent.lz_chat_tab_set_active('chat',true);">
                            <!--lang_client_tab_chat-->
                        </li>
                        <li id="lz_tab_callback" class="lz_chat_navigation_tab" onclick="parent.parent.lz_chat_tab_set_active('callback',true);">
                            <!--lang_client_tab_callback-->
                        </li>
                        <li id="lz_tab_ticket" class="lz_chat_navigation_tab" onclick="parent.parent.lz_chat_tab_set_active('ticket',true);">
                            <!--lang_client_tab_ticket-->
                        </li>
                    </ul>
                </td>
                <td width="5"></td>
            </tr>
        </table>
    </div>
	<div id="lz_chat_login" onmousemove="parent.parent.lz_chat_capture_mouse_position(event);">
        <form name="lz_login_form" method="post" action="./<!--file_chat-->?template=lz_chat_frame.3.2.chat&amp;<!--url_get_params-->" target="lz_chat_frame.3.2" style="padding:0px;margin:0px;">
		<table align="center" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
                    <div class="lz_input_header" id="lz_input_header_box">
                        <table cellpadding="5" cellspacing="3" width="100%">
                            <tr>
                                <td style="width:5px;"></td>
                                <td style="vertical-align:top;" id="lz_header_type_icon">
                                    <img src="<!--server-->images/icon_close.png" id="lz_header_icon_operator_close" alt="" onclick="parent.parent.lz_chat_unset_operator();">
                                    <img src="" id="lz_header_icon_operator" alt="">
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td id="lz_header_title"></td>
                                        </tr>
                                        <tr>
                                            <td><div id="lz_form_info_field" style="overflow:auto;height:48px;max-height:48px;"></div></td>
                                        </tr>
                                    </table>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div id="lz_chat_ticket_success" style="display:none;"><br><br><br><br><br><br><br><br><br><br><!--lang_client_message_received--></div>
                    <div id="lz_form_details" style="display:none;">
						<!--chat_login_inputs-->
						<table cellpadding="0" cellspacing="0" class="lz_input" id="lz_group_selection_box">
							<tr>
								<td class="lz_form_field"><strong><!--lang_client_group-->:</strong></td>
								<td valign="middle"><select id="lz_form_groups" class="lz_form_box" name="intgroup" onChange="parent.parent.lz_chat_change_group(this,true);" onKeyUp="this.blur();" onclick="parent.parent.lz_chat_pre_change_group(this);"></select></td>
                                <td class="lz_form_icon"></td>
                            </tr>
						</table>
                        <div style="width:100%;max-width:450px;text-align:center;">
                            <table cellpadding="3" cellspacing="2" align="center" style="margin-top:15px;width:100%;">
                                <tr>
                                    <td style="width:115px;">
                                        <div style="display:none;" id="lz_form_mandatory">
                                            <table><tr><td style="vertical-align:top;"><div class="lz_input_icon lz_required"></div></td><td><span class="lz_index_help_text"><!--lang_client_required_field--></span></td></tr></table>
                                        </div>
                                    </td>
                                    <td style="width:5px;"></td>
                                    <td>
                                        <input type="button" id="lz_action_button" class="lz_form_button" disabled>
                                        <input type="button" value="<!--lang_client_voucher_checkout-->" id="buy_voucher_button" onclick="parent.parent.lz_chat_buy_voucher_navigate('voucher_select',false);" class="lz_form_button">
                                    </td>
                                </tr>
                            </table>
                        </div>
					</div>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div style="position:absolute;left:20px;bottom:10px;<!--ssl_secured-->;z-index:-1;">
		<img src="<!--server-->images/lz_ssl_secured_chat.gif" alt="" width="123" height="45" border="0">
	</div>
	<!--com_chats-->
	<input type="hidden" name="form_chat_call_me_back">
</body>
</html>
