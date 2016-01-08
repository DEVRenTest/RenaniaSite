<?php 
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkoliar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

// Heading
$_['heading_title']							= 'Newsletter Create and Send';

// Entry 
$_['entry_template']						= 'Template:';
$_['entry_language']						= 'Language:';
$_['entry_currency']						= 'Currency:';
$_['entry_yes']								= 'Yes';
$_['entry_no']								= 'No';
$_['entry_defined']							= 'Include selected products:';
$_['entry_special']							= 'Include special offer products:';
$_['entry_product']							= 'Product to add:';
$_['entry_latest']							= 'Include latest products:';
$_['entry_popular']							= 'Include popular products:';
$_['entry_defined_categories']				= 'Include products from categories:';
$_['entry_attachments']						= 'Attachments:';
$_['entry_marketing']						= 'Marketing lists:';
$_['entry_section_name']					= 'Selected products section name:';
$_['entry_text_message']					= 'Plain text version:';
$_['entry_text_message_products']			= 'Append link to web version:';

// Text
$_['text_clear_warning']					= '<span style="color:red;font-weight:bold;">Important!</span> When changing template, language, currency or store - subject and message changes will be lost!';
$_['text_message_info']						= 'Subject and message personalization tags: <pre>{name}, {lastname}, {email}</pre> will be replaced with corresponding values. <pre>{reward}</pre> tag only for recipients "Reward points: All/Subscribed customers".';
$_['text_marketing']						= 'All Marketing Subscribers';
$_['text_marketing_all']					= 'All Marketing';
$_['text_subscriber_all']					= 'All Newsletter Subscribers & Marketing Subscribers';
$_['text_all']								= 'All Customers & Marketing';
$_['text_throttle_sent']     				= '<img src="view/image/loading.gif" alt="" /> %d emails added to queue. Please wait till adding process is not finished!';
$_['text_sent']     						= '<img src="view/image/loading.gif" alt="" /> Sent %d emails. Please wait till sending process is not finished!';
$_['text_success_save']						= 'Success: Newsletter successfully saved in draft!';
$_['text_throttle_success']   				= 'Emails added to queue. You may check progress in stats section.';
$_['text_loading']							= 'Loading...';
$_['text_success_check']					= 'Your Newsletter has been sent to <a href="http://isnotspam.com" target="_blank">isNotSpam.com</a>. The following checks will be done: SPF Check, Sender-ID Check, DomainKeys Check, DKIM Check, SpamAssassin Check. Results can be viewed <a href="http://isnotspam.com/newlatestreport.php?email=%s" target="_blank">here</a>.';
$_['text_only_subscribers']					= 'Only subscribers';
$_['text_only_selected_language']			= 'Send only to customers who selected this language. <span class="help">If customer have not choosed preferred language and current language is store default language - customer anyway will get newsletter.</span>';
$_['text_rewards']							= 'Reward points: Subscribed customers';
$_['text_rewards_all']						= 'Reward points: All customers';

// Button 
$_['button_add_file']						= 'Add attachment';
$_['button_save']							= 'Save in draft';
$_['button_reset']							= 'Reset';
$_['button_back']							= 'Back';
$_['button_update']							= 'Save';
$_['button_preview']						= 'Preview';
$_['button_check']							= 'Check if spam';
$_['button_add_defined_section']			= 'Add new selected products section';