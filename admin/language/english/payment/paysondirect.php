<?php

$_['paysondirect_example'] = 'Example Extra Text';

// Heading Goes here:
$_['heading_title'] = 'Payson Express';

// Text
$_['text_modul_name'] = 'PaysonExpress';
$_['text_modul_version'] = '1.0.0.0';

$_['text_payment'] = 'Payment';
$_['text_success'] = 'Success: You have modified Payson Express module!';
$_['text_paysondirect'] = '<a onclick="window.open(\'https://www.payson.se/tj%C3%A4nster/ta-betalt\');"><img src="view/image/payment/payson.png" alt="Payson" title="Payson" /></a>';
$_['text_edit'] = 'Edit Payson Direct';

// Entry
$_['entry_method_mode'] = 'Mode';
$_['text_method_mode_live'] = 'Production';
$_['text_method_mode_sandbox'] = 'Test';

$_['merchant_id'] = 'Merchant id';
$_['api_key'] = 'API-key';

$_['secure_word'] = 'Secure word';

$_['entry_total'] = 'Total';
$_['entry_order_status'] = 'Order Status';
$_['entry_geo_zone'] = 'Geo Zone';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sort Order';
$_['entry_logg'] = 'Logs';
$_['entry_totals_to_ignore'] = 'Order totals to ignore';

$_['text_request_phone'] = 'Enable request phone';
$_['entry_phone'] = 'Phone';
$_['text_phone_yes'] = 'yes';
$_['text_phone_no'] = 'no';
$_['entry_verification'] = 'Verification';
$_['text_verification_none'] = 'None';
$_['text_verification_bankid'] = 'BankId';
$_['entry_color_scheme'] = 'Color scheme';
$_['text_color_scheme_blue'] = 'blue';
$_['text_color_scheme_gray'] = 'gray';
$_['text_color_scheme_white'] = 'white';
$_['text_color_scheme_graysemi'] = 'graysemi';
$_['text_color_scheme_pitchblack'] = 'pitchblack';
$_['text_color_scheme_bright'] = 'bright';
$_['entry_iframe_size_width'] = 'Size of iframe (Width)';
$_['entry_iframe_size_height'] = 'Size of iframe (height)';
$_['entry_iframe_size_width_type'] = 'Percent or px';
$_['text_iframe_size_width_percent'] = '%';
$_['text_iframe_size_width_px'] = 'px';
$_['entry_iframe_size_height_type'] = 'Percent or px';
$_['text_iframe_size_height_percent'] = '%';
$_['text_iframe_size_height_px'] = 'px';
$_['entry_order_item_details_to_ignore'] = 'Order Item Details to ignore by PaysonExpress';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify payment Payson module!';
$_['error_merchant_id'] = 'Agent ID Required!';
$_['error_api_key'] = 'API-key Required!';
$_['error_ignored_order_totals'] = 'Enter a comma separated list with order totals not to send to payson';

//help
$_['help_method_mode'] = 'Select environment (Production or Test)';
$_['help_merchant_id'] = 'Enter your merchant ID for Payson';
$_['help_api_key'] = 'Enter your API-key for Payson';
$_['help_secure_word'] = 'Enter a secure word';
$_['help_logg'] = 'You can find your logs in Admin | System -> Error Log';
$_['help_verification'] = 'Can be used to add extra customer verification';
$_['help_request_phone'] = 'Select phone';
$_['help_color_scheme'] = 'Select color scheme';
$_['help_iframe_size_height'] = 'Select the height of iframe';
$_['help_iframe_size_width'] = 'Select the width of iframe';
$_['help_iframe_size_height_type'] = 'Select the height XXXX of iframe';
$_['help_iframe_size_width_type'] = 'Select the width XXXX of iframe';
$_['help_total'] = 'The checkout total the order must reach before this payment method becomes active';
$_['help_totals_to_ignore'] = 'Comma separated list with order totals not to send to payson';
?>