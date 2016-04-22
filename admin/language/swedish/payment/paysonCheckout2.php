<?php

// Example field added (see related part in admin/controller/module/my_module.php)
$_['paysonCheckout2_example'] = 'Example Extra Text';

// Heading Goes here:
$_['heading_title'] = 'Payson Checkout 2.0';
// Text
$_['text_modul_name'] = 'Payson Checkout 2.0';
$_['text_modul_version'] = '1.0.1.1';
$_['text_payment'] = 'Payment';
$_['text_success'] = 'Success: Du har &auml;ndrat Payson Checkout 2.0 modulen!';
$_['text_paysonCheckout2'] = '<a onclick="window.open(\'https://www.payson.se/tj%C3%A4nster/ta-betalt\');"><img src="view/image/payment/paysonCheckout2.png" alt="payson Checkout 2.0" title="payson Checkout 2.0" /></a>';
$_['text_edit'] = 'Uppdatera Payson Invoice';

// Entry
$_['entry_method_mode'] = 'Mode';
$_['text_method_mode_live'] = 'Produktionsmilj&ouml;';
$_['text_method_mode_sandbox'] = 'Testmilj&ouml;';

$_['merchant_id'] = 'Merchant id';
$_['api_key'] = 'API-key';

$_['secure_word'] = 'Hemligt ord';

$_['entry_total'] = 'Totalt';
$_['entry_order_status'] = 'Order Status';
$_['entry_geo_zone'] = 'Geo Zone';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sorteringsordning';
$_['entry_logg'] = 'Loggar';
$_['entry_totals_to_ignore'] = 'Ignorerade ordertillägg';

$_['text_request_phone'] = 'Aktivera telefonnummer';
$_['entry_phone'] = 'Telefonnummer';
$_['text_phone_yes'] = 'yes';
$_['text_phone_no'] = 'no';
$_['entry_verification'] = 'Verification';
$_['text_verification_none'] = 'None';
$_['text_verification_bankid'] = 'BankId';
$_['entry_color_scheme'] = 'Color scheme';
$_['text_color_scheme_blue'] = 'blå';
$_['text_color_scheme_gray'] = 'grå';
$_['text_color_scheme_white'] = 'vit';
$_['text_color_scheme_graysemi'] = 'graysemi';
$_['text_color_scheme_pitchblack'] = 'kolsvart';
$_['text_color_scheme_bright'] = 'ljust';
$_['entry_iframe_size_width'] = 'Storlek av iframe (bredd)';
$_['entry_iframe_size_height'] = 'Storlek av iframe (höjd)';
$_['entry_iframe_size_width_type'] = 'Percent or px';
$_['text_iframe_size_width_percent'] = '%';
$_['text_iframe_size_width_px'] = 'px';
$_['entry_iframe_size_height_type'] = 'Percent or px';
$_['text_iframe_size_height_percent'] = '%';
$_['text_iframe_size_height_px'] = 'px';
$_['entry_order_item_details_to_ignore'] = 'Ignorerade ordertillägg vid Payson';
$_['entry_show_receipt_page']           = 'Visa Kvittosidan';
$_['entry_show_receipt_page_yes']           = 'Ja';
$_['entry_show_receipt_page_no']           = 'Nej';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify payment Payson module!';
$_['error_merchant_id'] = 'Merchant ID saknas!';
$_['error_api_key'] = 'API-nyckel saknas!';
$_['error_ignored_order_totals'] = 'Ange en kommaseparerad lista med ordertillägg som ej skall skickas till Payson';

//help
$_['help_method_mode'] = 'V&auml;lj l&auml;get (Produktionsmilj&ouml; eller testmilj&ouml;)';
$_['help_merchant_id'] = 'Ange ditt merchantID f&ouml;r ditt Paysonkonto';
$_['help_api_key'] = 'Ange din API-nyckel f&ouml;r ditt Paysonkonto';
$_['help_secure_word'] = 'Ange ett hemligt ord';
$_['help_logg'] = 'Du hittar dina loggar i Admin | System -> Error Log';
$_['help_gui_verification'] = 'Kan användas som en extra verifikation';
$_['help_request_phone'] = 'Enable telefonnummer';
$_['help_color_scheme'] = 'Ange färgen av schema';
$_['help_iframe_size_height'] = 'Ange höjden av iframe';
$_['help_iframe_size_width'] = 'Ange bredden av iframe';
$_['help_iframe_size_height_type'] = 'Ange höjden av iframe';
$_['help_iframe_size_width_type'] = 'Ange bredden av iframe';
$_['help_total'] = 'Kassan totala ordern m&aring;ste uppn&aring; innan betalningsmetod blir aktiv';
$_['help_receipt'] = 'Välj Ja för Paysons kvittosidan eller Nej for Opencarts kvittosidan';
$_['help_totals_to_ignore'] = 'Kommaseparerad lista med ordertillägg som ej skall skickas till Payson';
?>