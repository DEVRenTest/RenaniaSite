<?php
// Heading
$_['heading_title']       		= 'Abandoned Cart Reminder Pro';

// Tab
$_['tab_overview']        		= 'Overview';
$_['tab_setting']         		= 'General Settings';
$_['tab_coupon']          		= 'Coupon Settings';
$_['tab_email']           		= 'Email Template';
$_['tab_abandoned_cart']  		= 'Abandoned Carts';
$_['tab_history']         		= 'Reminders History';
$_['tab_help']            		= 'Help';

// Column
$_['column_customer']     		= 'Customer';
$_['column_cart_content'] 		= 'Cart Content';
$_['column_last_visit']   		= 'Last Action';
$_['column_reminder_sent']		= 'Reminders sent';
$_['column_reward_sent']  		= 'Rewards sent';
$_['column_coupon_code']  		= 'Coupon code<span class="help">sent to customer</span>';
$_['column_coupon_used']  		= 'Used?';
$_['column_email']        		= 'Reminder';
$_['column_date_sent']    		= 'Date sent<span class="help">YYYY-MM-DD</span>';
$_['column_action']       		= 'Action';

// Button
$_['button_preview']      		= 'Preview';
$_['button_send']         		= 'Send now';
$_['button_view_reminder']		= 'View reminder message';
$_['button_send_all']     		= 'Send to all';

// Text
$_['text_module']               = 'Modules';
$_['text_success']              = 'Success: You have modified module Abandoned Cart Reminder Pro!';
$_['text_total_recovered']      = 'Until now Abandoned Cart Reminder recovered <strong>%s</strong> from your customers';
$_['text_coupon_fixed']         = 'Fixed Amount';
$_['text_coupon_percent']       = 'Percentage';
$_['text_coupon_all_products']  = 'Any product';
$_['text_coupon_cart_products'] = 'ONLY for products from abandoned cart';
$_['text_content_top']          = 'Content Top';
$_['text_content_bottom']       = 'Content Bottom';
$_['text_column_left']          = 'Column Left';
$_['text_column_right']         = 'Column Right';
$_['text_preview_info']         = 'Important: Press Save (before Preview) if you changed settings, otherwise will use old setting. Preview function choose random an reminder (from reminders that need to be delivered).';
$_['text_special_keyword']      = '<strong>{firstname}</strong> = customer firstname<br /><strong>{lastname}</strong> = customer lastname<br /><strong>{shopping_cart_content}</strong> = content of customer shopping cart<br /><strong>{coupon_code}</strong> = coupon code generated for customer<br /><strong>{discount}</strong> = value of coupon (EX: $10 or 10%)<br /><strong>{total_amount}</strong> = required order value before coupon is valid<br /><strong>{validity_days}</strong> = how many days coupon is valid<br /><strong>{store_name}</strong> = your store name';
$_['text_send_all']             = 'To send reminders (manually) to all customer you can use button "Send to all".';

// Entry
$_['entry_secret_code']         = 'Secret code: <span class="help">at least 5 characters! ( a-z, A-Z, 0-9 ) <br />Required for Cron Job</span>';
$_['entry_delay']               = 'Delay (hours): <span class="help">number of hours after cart is considered inactive and can be sent an reminder</span>';
$_['entry_max_reminders']       = 'No. max reminders: <span class="help">maximum number of reminders that can be sent if customer don\'t read/react.<br /> Recommended max = 3 </span>';
$_['entry_hide_out_stock']    	= 'Hide Out of stock product:<span class="help">hide in reminder (email) products with stock (quantity) = 0</span>';
$_['entry_use_html_email']    	= 'Send Reminder with <a href="http://www.oc-extensions.com/HTML-Email">HTML Email Extension</a>:<span class="help"><br />If HTML Email Extension is not installed on your store then is used default html mail (like in old versions of this extensions)</span>';
$_['entry_log_admin']        	= 'Send Log to admin:<span class="help">admin receive an email with list of customers informed about abandoned cart</span>';
$_['entry_add_coupon']        	= 'Add coupon: <span class="help">add coupon to encourage customer to buy</span>';
$_['entry_coupon_type']       	= 'Coupon type:';
$_['entry_coupon_amount']     	= 'Discount amount:<span class="help">if Percentage = X% <br />if fixed = X [your currency]</span>'; 
$_['entry_coupon_total']      	= 'Required order total:<span class="help">Order total amount that must reached before the coupon is valid.<br />- leave blank to ignore this option</span>'; 
$_['entry_coupon_expire']     	= 'Coupon expire in (days):';
$_['entry_coupon_usage']      	= 'Coupon usage:';
$_['entry_reward_limit']      	= 'How many times customer can be rewarded with coupons?<span class="help">leave blank = unlimited</span>';
$_['entry_subject']           	= 'Subject:';
$_['entry_special_keyword']   	= 'Special Keywords:<span class="help">for email message you can use special keywords</span>';
$_['entry_message_reward']    	= 'Message (with discount):<span class="help">message used when coupon is attached</span>';
$_['entry_message_no_reward'] 	= 'Message (without discount):<span class="help">message used when customer is just notified about his cart<br /><br />Add coupon = Disabled OR customer already received max number of rewards</span>';


// Error
$_['error_permission']        	= 'Warning: You do not have permission to modify module Abandoned Cart Reminder Pro!';
$_['error_secret_code']       	= 'Secret code: at least 5 characters! ( a-z, A-Z, 0-9 )';
$_['error_delay']             	= 'Delay - required';
$_['error_html_email_not_installed'] = 'Review Invitation Emails can\'t be sent with <a href="http://www.oc-extensions.com/HTML-Email">HTML Email Extension</a> because this extension is not available on your store. Please set option to Disabled!';
$_['error_max_reminders']     	= 'Max reminder - required';
$_['error_coupon_amount']     	= 'Coupon amount - required';
$_['error_coupon_expire']     	= 'Coupon expire - required';
$_['error_subject']           	= 'Email subject - required';
$_['error_message']           	= 'Email message - required';
?>