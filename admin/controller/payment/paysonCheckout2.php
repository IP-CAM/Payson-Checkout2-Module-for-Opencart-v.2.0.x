<?php

class ControllerPaymentPaysonCheckout2 extends Controller {

    private $error = array();
    private $data = array();

    public function index() {
        //Load the language file for this module
        $this->load->language('payment/paysonCheckout2');

        //Set the title from the language file $_['heading_title'] string
        $this->document->setTitle($this->language->get('heading_title'));

        //create the table payson_order in the database
        $this->load->model('module/paysonCheckout2');
        $this->model_module_paysonCheckout2->createModuleTables();

        //Load the settings model. You can also add any other models you want to load here.
        $this->load->model('setting/setting');
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).		
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paysonCheckout2', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_modul_name'] = $this->language->get('text_modul_name');
        $this->data['text_modul_version'] = $this->language->get('text_modul_version');
        //$this->data['modul_version'] = $this->language->get('text_modul_version');

        $this->data['text_edit'] = $this->language->get('text_edit');
        $this->data['merchant_id'] = $this->language->get('merchant_id');
        $this->data['api_key'] = $this->language->get('api_key');

        $this->data['secure_word'] = $this->language->get('secure_word');
        $this->data['entry_logg'] = $this->language->get('entry_logg');

        $this->data['entry_method_mode'] = $this->language->get('entry_method_mode');
        $this->data['paysonCheckout2_mode'] = $this->language->get('payment_mode');
        $this->data['text_method_mode_live'] = $this->language->get('text_method_mode_live');
        $this->data['text_method_mode_sandbox'] = $this->language->get('text_method_mode_sandbox');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');

        $this->data['entry_order_status'] = $this->language->get('entry_order_status'); 
        $this->data['entry_order_status_shipped'] = $this->language->get('entry_order_status_shipped'); 
        $this->data['entry_order_status_canceled'] = $this->language->get('entry_order_status_canceled'); 
        $this->data['entry_order_status_refunded'] = $this->language->get('entry_order_status_refunded'); 
        
        $this->data['entry_status'] = $this->language->get('entry_status');
        
        $this->data['entry_total'] = $this->language->get('entry_total');
        $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        
        $this->data['entry_order_item_details_to_ignore'] = $this->language->get('entry_order_item_details_to_ignore');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_totals_to_ignore'] = $this->language->get('entry_totals_to_ignore');
        
        $this->data['entry_color_scheme'] = $this->language->get('entry_color_scheme');
        $this->data['text_color_scheme_blue'] = $this->language->get('text_color_scheme_blue');
        $this->data['text_color_scheme_gray'] = $this->language->get('text_color_scheme_gray');
        $this->data['text_color_scheme_white'] = $this->language->get('text_color_scheme_white');
        $this->data['text_color_scheme_graysemi'] = $this->language->get('text_color_scheme_graysemi');
        $this->data['text_color_scheme_pitchblack'] = $this->language->get('text_color_scheme_pitchblack');
        $this->data['text_color_scheme_bright'] = $this->language->get('text_color_scheme_bright');
           
        $this->data['entry_verification'] = $this->language->get('entry_verification');
        $this->data['text_verification_bankid'] = $this->language->get('text_verification_bankid');
        $this->data['text_verification_none'] = $this->language->get('text_verification_none');
              
        $this->data['entry_phone'] = $this->language->get('entry_phone');
        $this->data['text_phone_yes'] = $this->language->get('text_phone_yes');
        $this->data['text_phone_no'] = $this->language->get('text_phone_no');
 
        $this->data['entry_registered_customer'] = $this->language->get('entry_registered_customer');
        $this->data['text_registered_customer_yes'] = $this->language->get('text_registered_customer_yes');
        $this->data['text_registered_customer_no'] = $this->language->get('text_registered_customer_no');

        $this->data['entry_iframe_size_width'] = $this->language->get('entry_iframe_size_width');
        $this->data['entry_iframe_size_width_type'] = $this->language->get('entry_iframe_size_width_type');
        $this->data['text_iframe_size_width_percent'] = $this->language->get('text_iframe_size_width_percent');
        $this->data['text_iframe_size_width_px'] = $this->language->get('text_iframe_size_width_px');
        
        $this->data['entry_iframe_size_height'] = $this->language->get('entry_iframe_size_height');  
        $this->data['entry_iframe_size_height_type'] = $this->language->get('entry_iframe_size_height_type');
        $this->data['text_iframe_size_height_percent'] = $this->language->get('text_iframe_size_height_percent');
        $this->data['text_iframe_size_height_px'] = $this->language->get('text_iframe_size_height_px');  

        $this->data['entry_show_receipt_page'] = $this->language->get('entry_show_receipt_page');
        $this->data['entry_show_receipt_page_yes'] = $this->language->get('entry_show_receipt_page_yes');
        $this->data['entry_show_receipt_page_no'] = $this->language->get('entry_show_receipt_page_no');
        
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['help_merchant_id'] = $this->language->get('help_merchant_id');
        $this->data['help_api_key'] = $this->language->get('help_api_key');
        $this->data['help_secure_word'] = $this->language->get('help_secure_word');
        $this->data['help_logg'] = $this->language->get('help_logg');
        $this->data['help_total'] = $this->language->get('help_total');
        $this->data['help_verification'] = $this->language->get('help_verification');
        $this->data['help_request_phone'] = $this->language->get('help_request_phone');
        $this->data['help_request_registered_customer'] = $this->language->get('help_request_registered_customer');
        $this->data['help_color_scheme'] = $this->language->get('help_color_scheme');
        $this->data['help_iframe_size_height'] = $this->language->get('help_iframe_size_height');
        $this->data['help_iframe_size_width'] = $this->language->get('help_iframe_size_width');
        $this->data['help_iframe_size_height_type'] = $this->language->get('help_iframe_size_height_type');
        $this->data['help_iframe_size_width_type'] = $this->language->get('help_iframe_size_width_type'); 
		$this->data['help_receipt'] = $this->language->get('help_receipt');		
        $this->data['help_totals_to_ignore'] = $this->language->get('help_totals_to_ignore');
        $this->data['help_method_mode'] = $this->language->get('help_method_mode');
        $this->data['help_order_status_shipped'] = $this->language->get('help_order_status_shipped');
        $this->data['help_order_status_canceled'] = $this->language->get('help_order_status_canceled');
        $this->data['help_order_status_refunded'] = $this->language->get('help_order_status_refunded');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['merchant_id'])) {
            $this->data['error_merchant_id'] = $this->error['merchant_id'];
        } else {
            $this->data['error_merchant_id'] = '';
        }

        if (isset($this->error['api_key'])) {
            $this->data['error_api_key'] = $this->error['api_key'];
        } else {
            $this->data['error_api_key'] = '';
        }

        if (isset($this->error['ignored_order_totals'])) {
            $this->data['error_ignored_order_totals'] = $this->error['ignored_order_totals'];
        } else {
            $this->data['error_ignored_order_totals'] = '';
        }

        $this->data['error_invoiceFeeError'] = (isset($this->error['invoiceFeeError']) ? $this->error['invoiceFeeError'] : '');


        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/paysonCheckout2', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('payment/paysonCheckout2', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');


        if (isset($this->request->post['paysonCheckout2_modul_version'])) {
            $this->data['paysonCheckout2_modul_version'] = $this->request->post['paysonCheckout2_modul_version'];
        } else {
            $this->data['paysonCheckout2_modul_version'] = $this->config->get('paysonCheckout2_modul_version');
        }

        if (isset($this->request->post['paysonCheckout2_merchant_id'])) {
            $this->data['paysonCheckout2_merchant_id'] = $this->request->post['paysonCheckout2_merchant_id'];
        } else {
            $this->data['paysonCheckout2_merchant_id'] = $this->config->get('paysonCheckout2_merchant_id');
        }
        if (isset($this->request->post['paysonCheckout2_api_key'])) {
            $this->data['paysonCheckout2_api_key'] = $this->request->post['paysonCheckout2_api_key'];
        } else {
            $this->data['paysonCheckout2_api_key'] = $this->config->get('paysonCheckout2_api_key');
        }

        if (isset($this->request->post['paysonCheckout2_mode'])) {
            $this->data['paysonCheckout2_mode'] = $this->request->post['paysonCheckout2_mode'];
        } else {
            $this->data['paysonCheckout2_mode'] = $this->config->get('paysonCheckout2_mode');
        }

        if (isset($this->request->post['paysonCheckout2_secure_word'])) {
            $this->data['paysonCheckout2_secure_word'] = $this->request->post['paysonCheckout2_secure_word'];
        } else {
            $this->data['paysonCheckout2_secure_word'] = $this->config->get('paysonCheckout2_secure_word');
        }

        if (isset($this->request->post['paysonCheckout2_logg'])) {
            $this->data['paysonCheckout2_logg'] = $this->request->post['paysonCheckout2_logg'];
        } else {
            $this->data['paysonCheckout2_logg'] = $this->config->get('paysonCheckout2_logg');
        }

        if (isset($this->request->post['paysonCheckout2_total'])) {
            $this->data['paysonCheckout2_total'] = $this->request->post['paysonCheckout2_total'];
        } else {
            $this->data['paysonCheckout2_total'] = $this->config->get('paysonCheckout2_total');
        }

        if (isset($this->request->post['paysonCheckout2_order_status_id'])) {
            $this->data['paysonCheckout2_order_status_id'] = $this->request->post['paysonCheckout2_order_status_id'];
        } elseif ($this->config->get('paysonCheckout2_order_status_id') !== null) {
            $this->data['paysonCheckout2_order_status_id'] = $this->config->get('paysonCheckout2_order_status_id');
        } else {
            $this->data['paysonCheckout2_order_status_id'] = 5;
        }
        
        if (isset($this->request->post['paysonCheckout2_order_status_shipped_id'])) {
            $this->data['paysonCheckout2_order_status_shipped_id'] = $this->request->post['paysonCheckout2_order_status_shipped_id'];
        } elseif ($this->config->get('paysonCheckout2_order_status_shipped_id') !== null) {
            $this->data['paysonCheckout2_order_status_shipped_id'] = $this->config->get('paysonCheckout2_order_status_shipped_id');
        } else {
            $this->data['paysonCheckout2_order_status_shipped_id'] = 1; //Pending
        }

        if (isset($this->request->post['paysonCheckout2_order_status_canceled_id'])) {
            $this->data['paysonCheckout2_order_status_canceled_id'] = $this->request->post['paysonCheckout2_order_status_canceled_id'];
        } elseif ($this->config->get('paysonCheckout2_order_status_canceled_id') !== null) {
            $this->data['paysonCheckout2_order_status_canceled_id'] = $this->config->get('paysonCheckout2_order_status_canceled_id');
        }else {
            $this->data['paysonCheckout2_order_status_canceled_id'] = 1; //Pending
        }

        if (isset($this->request->post['paysonCheckout2_order_status_refunded_id'])) {
            $this->data['paysonCheckout2_order_status_refunded_id'] = $this->request->post['paysonCheckout2_order_status_refunded_id'];
        } elseif($this->config->get('paysonCheckout2_order_status_refunded_id') !== null) {
            $this->data['paysonCheckout2_order_status_refunded_id'] = $this->config->get('paysonCheckout2_order_status_refunded_id');
        } else {
            $this->data['paysonCheckout2_order_status_refunded_id'] = 1; ////Pending
        }

        $this->load->model('localisation/order_status');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['paysonCheckout2_geo_zone_id'])) {
            $this->data['paysonCheckout2_geo_zone_id'] = $this->request->post['paysonCheckout2_geo_zone_id'];
        } else {
            $this->data['paysonCheckout2_geo_zone_id'] = $this->config->get('paysonCheckout2_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['paysonCheckout2_status'])) {
            $this->data['paysonCheckout2_status'] = $this->request->post['paysonCheckout2_status'];
        } else {
            $this->data['paysonCheckout2_status'] = $this->config->get('paysonCheckout2_status');
        }

        if (isset($this->request->post['paysonCheckout2_sort_order'])) {
            $this->data['paysonCheckout2_sort_order'] = $this->request->post['paysonCheckout2_sort_order'];
        } else {
            $this->data['paysonCheckout2_sort_order'] = $this->config->get('paysonCheckout2_sort_order');
        }  
                
        if (isset($this->request->post['paysonCheckout2_gui_verification'])) {
            $this->data['paysonCheckout2_gui_verification'] = $this->request->post['paysonCheckout2_gui_verification'];
        } else {
            $this->data['paysonCheckout2_gui_verification'] = $this->config->get('PaysonCheckout2_gui_verification');
        }

        if (isset($this->request->post['paysonCheckout2_request_phone'])) {
            $this->data['paysonCheckout2_request_phone'] = $this->request->post['paysonCheckout2_request_phone'];
        } else {
            $this->data['paysonCheckout2_request_phone'] = $this->config->get('paysonCheckout2_request_phone');
        }

        if (isset($this->request->post['paysonCheckout2_request_registered_customer'])) {
            $this->data['paysonCheckout2_request_registered_customer'] = $this->request->post['paysonCheckout2_request_registered_customer'];
        } else {
            $this->data['paysonCheckout2_request_registered_customer'] = $this->config->get('paysonCheckout2_request_registered_customer');
        }        
        
        if (isset($this->request->post['paysonCheckout2_color_scheme'])) {
            $this->data['paysonCheckout2_color_scheme'] = $this->request->post['paysonCheckout2_color_scheme'];
        } else {
            $this->data['paysonCheckout2_color_scheme'] = $this->config->get('paysonCheckout2_color_scheme');
        }
        
        if (isset($this->request->post['paysonCheckout2_iframe_size_width'])) {
            $this->data['paysonCheckout2_iframe_size_width'] = $this->request->post['paysonCheckout2_iframe_size_width'];
        } else {
            if($this->config->get('paysonCheckout2_iframe_size_width') == Null){
                $this->data['paysonCheckout2_iframe_size_width'] = '100';
            }else{
                $this->data['paysonCheckout2_iframe_size_width'] = $this->config->get('paysonCheckout2_iframe_size_width');
            }
        }
        
        if (isset($this->request->post['paysonCheckout2_iframe_size_width_type'])) {
            $this->data['paysonCheckout2_iframe_size_width_type'] = $this->request->post['paysonCheckout2_iframe_size_width_type'];
        } else {
            $this->data['paysonCheckout2_iframe_size_width_type'] = $this->config->get('paysonCheckout2_iframe_size_width_type');
        }
        
        if (isset($this->request->post['paysonCheckout2_iframe_size_height'])) {
            $this->data['paysonCheckout2_iframe_size_height'] = $this->request->post['paysonCheckout2_iframe_size_height'];
        } else {
            if($this->config->get('paysonCheckout2_iframe_size_height') == Null){
                $this->data['paysonCheckout2_iframe_size_height'] = '900';
            }else{
                $this->data['paysonCheckout2_iframe_size_height'] = $this->config->get('paysonCheckout2_iframe_size_height');
            }
        }
        
        if (isset($this->request->post['paysonCheckout2_iframe_size_height_type'])) {
            $this->data['paysonCheckout2_iframe_size_height_type'] = $this->request->post['paysonCheckout2_iframe_size_height_type'];
        } else {
            $this->data['paysonCheckout2_iframe_size_height_type'] = $this->config->get('paysonCheckout2_iframe_size_height_type');
        }
        if (isset($this->request->post['paysonCheckout2_receipt'])) {
            $this->data['paysonCheckout2_receipt'] = $this->request->post['paysonCheckout2_receipt'];
        } else {
            $this->data['paysonCheckout2_receipt'] = $this->config->get('paysonCheckout2_receipt');
        }
        
        if (isset($this->request->post['paysonCheckout2_ignored_order_totals'])) {
            $this->data['paysonCheckout2_ignored_order_totals'] = $this->request->post['paysonCheckout2_ignored_order_totals'];
        } else {
            if ($this->config->get('paysonCheckout2_ignored_order_totals') == null) {
                $this->data['paysonCheckout2_ignored_order_totals'] = 'sub_total, total, taxes, tax';
            } else
                $this->data['paysonCheckout2_ignored_order_totals'] = $this->config->get('paysonCheckout2_ignored_order_totals');
        }

        $this->data['header'] = $this->load->controller('common/header');
        $this->data['column_left'] = $this->load->controller('common/column_left');
        $this->data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/paysonCheckout2.tpl', $this->data));
    }

    private function validate() {

        if (!$this->user->hasPermission('modify', 'payment/paysonCheckout2')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (isset($this->request->post['paysonCheckout2_mode']) and $this->request->post['paysonCheckout2_mode'] != 0) {
            
            if (!isset($this->request->post['paysonCheckout2_merchant_id']) || !$this->request->post['paysonCheckout2_merchant_id']) {
                $this->error['merchant_id'] = $this->language->get('error_merchant_id');
            }

            if (!isset($this->request->post['paysonCheckout2_api_key']) || !$this->request->post['paysonCheckout2_api_key']) {
                $this->error['api_key'] = $this->language->get('error_api_key');
            }
        }
        if (isset($this->request->post['paysonCheckout2_ignored_order_totals']) and !$this->request->post['paysonCheckout2_ignored_order_totals']) {
            $this->error['ignored_order_totals'] = $this->language->get('error_ignored_order_totals');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
?>