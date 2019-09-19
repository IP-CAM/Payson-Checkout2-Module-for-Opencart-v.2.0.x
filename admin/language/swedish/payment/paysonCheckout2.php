<?php

// Example field added (see related part in admin/controller/module/my_module.php)
$_['paysonCheckout2_example'] = 'Example Extra Text';

// Heading Goes here:
$_['heading_title'] = 'Payson Checkout 2.0';
// Text
$_['text_modul_name'] = 'Payson Checkout 2.0';
$_['text_modul_version'] = '1.0.2.1';
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
$_['entry_order_status_shipped'] = 'Orderstatus fÃ¶r skickad order';
$_['entry_order_status_canceled'] = 'Orderstatus fÃ¶r avbruten order';
$_['entry_order_status_refunded'] = 'Orderstatus fÃ¶r krediterad order';
$_['entry_geo_zone'] = 'Geo Zone';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sorteringsordning';
$_['entry_logg'] = 'Loggar';
$_['entry_totals_to_ignore'] = 'Ignorerade ordertillÃ¤gg';

$_['text_request_phone'] = 'Aktivera telefonnummer';
$_['entry_phone'] = 'Telefonnummer';
$_['text_phone_yes'] = 'Ja';
$_['text_phone_no'] = 'Nej';
$_['entry_registered_customer'] = 'Aktivera bara registrerade kunder';
$_['text_registered_customer_yes'] = 'Ja';
$_['text_registered_customer_no'] = 'Nej';
$_['entry_verification'] = 'Verification';
$_['text_verification_none'] = 'None';
$_['text_verification_bankid'] = 'BankId';
$_['entry_color_scheme'] = 'Color scheme';
$_['text_color_scheme_blue'] = 'blÃ¥';
$_['text_color_scheme_gray'] = 'grÃ¥';
$_['text_color_scheme_white'] = 'vit';
$_['text_color_scheme_graysemi'] = 'graysemi';
$_['text_color_scheme_pitchblack'] = 'kolsvart';
$_['text_color_scheme_bright'] = 'ljust';
$_['entry_iframe_size_width'] = 'Storlek av iframe (bredd)';
$_['entry_iframe_size_height'] = 'Storlek av iframe (hÃ¶jd)';
$_['entry_iframe_size_width_type'] = 'Percent or px';
$_['text_iframe_size_width_percent'] = '%';
$_['text_iframe_size_width_px'] = 'px';
$_['entry_iframe_size_height_type'] = 'Percent or px';
$_['text_iframe_size_height_percent'] = '%';
$_['text_iframe_size_height_px'] = 'px';
$_['entry_order_item_details_to_ignore'] = 'Ignorerade ordertillÃ¤gg vid Payson';
$_['entry_show_receipt_page']           = 'Visa Kvittosidan';
$_['entry_show_receipt_page_yes']           = 'Ja';
$_['entry_show_receipt_page_no']           = 'Nej';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify payment Payson module!';
$_['error_merchant_id'] = 'Merchant ID saknas!';
$_['error_api_key'] = 'API-nyckel saknas!';
$_['error_ignored_order_totals'] = 'Ange en kommaseparerad lista med ordertillÃ¤gg som ej skall skickas till Payson';

//help
$_['help_method_mode'] = 'V&auml;lj l&auml;get (Produktionsmilj&ouml; eller testmilj&ouml;)';
$_['help_merchant_id'] = 'Ange ditt merchantID f&ouml;r ditt Paysonkonto';
$_['help_api_key'] = 'Ange din API-nyckel f&ouml;r ditt Paysonkonto';
$_['help_secure_word'] = 'Ange ett hemligt ord';
$_['help_logg'] = 'Du hittar dina loggar i Admin | System -> Error Log';
$_['help_gui_verification'] = 'Kan anvÃ¤ndas som en extra verifikation';
$_['help_request_phone'] = 'Enable telefonnummer';
$_['help_request_registered_customer'] = 'Kan anvÃ¤ndas fÃ¶r att aktivera enbart registrerade kunder vid anvÃ¤ndning av modulen Ajax Quick Checkout';
$_['help_color_scheme'] = 'Ange fÃ¤rgen av schema';
$_['help_iframe_size_height'] = 'Ange hÃ¶jden av iframe';
$_['help_iframe_size_width'] = 'Ange bredden av iframe';
$_['help_iframe_size_height_type'] = 'Ange hÃ¶jden av iframe';
$_['help_iframe_size_width_type'] = 'Ange bredden av iframe';
$_['help_total'] = 'Kassan totala ordern m&aring;ste uppn&aring; innan betalningsmetod blir aktiv';
$_['help_receipt'] = 'Välj Ja för Paysons kvittosidan eller Nej for Opencarts kvittosidan';
$_['help_totals_to_ignore'] = 'Kommaseparerad lista med ordertillägg som ej skall skickas till Payson';
$_['help_order_status'] = 'Ange efter OpenCart efter att kunden har slutfört en betalning eller när en faktura kan skickas';
$_['help_order_status_shipped'] = 'Meddela Payson att ordern har skickats.<br />Vänligen kontrollera under Admin | Verktyg -> Logs att ordern har fått status skickad i Payson innan den skickas till kunden.';
$_['help_order_status_canceled'] = 'Meddela Payson att ordern har avbrutits.<br />Vänligen kontrollera under Admin | Verktyg -> Logs att ordern har fått status cancelled  i Payson.';
$_['help_order_status_refunded'] = 'Meddela Payson att ordern ska krediteras.<br />Vänligen kontrollera under Admin | Verktyg -> Logs att ordern har fått status paidToAccount/Krediterad  i Payson.'; 