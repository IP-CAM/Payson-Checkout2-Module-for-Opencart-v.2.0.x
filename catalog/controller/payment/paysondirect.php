<?php

class ControllerPaymentPaysondirect extends Controller {

    private $testMode;
    private $api;
    private $data = array();

    const MODULE_VERSION = 'paysonEmbedded_1.0.0.0';

    function __construct($registry) {
        parent::__construct($registry);
        $this->testMode = ($this->config->get('paysondirect_mode') == 0);
        //$this->api = $this->getAPIInstance();
    }

    public function index() {
        $this->load->language('payment/paysondirect');

        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['text_wait'] = $this->language->get('text_wait');

        $this->setupPurchaseData();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paysondirect.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/paysondirect.tpl', $this->data);
        } else {
            $this->template = 'default/template/payment/paysondirect.tpl';
            return $this->load->view('default/template/payment/paysondirect.tpl', $this->data);
        }
    }

    public function confirm() {
        if ($this->session->data['payment_method']['code'] == 'paysondirect') {
            $this->setupPurchaseData();
        }
    }

    private function setupPurchaseData() {
        $this->load->language('payment/paysondirect');
        $this->load->model('checkout/order');

        $order_data = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $this->data['store_name'] = html_entity_decode($order_data['store_name'], ENT_QUOTES, 'UTF-8');
        //Payson send the responds to the shop
        $this->data['ok_url'] = $this->url->link('payment/paysondirect/returnFromPayson');
        $this->data['cancel_url'] = $this->url->link('checkout/checkout');
        $this->data['ipn_url'] = $this->url->link('payment/paysondirect/paysonIpn&order_id=' . $this->session->data['order_id']);
        $this->data['checkout_url'] = $this->url->link('checkout/checkout');
        $this->data['terms_url'] = $this->url->link('information/information/agree&information_id=5');

        $this->data['order_id'] = $order_data['order_id'];
        $this->data['amount'] = $this->currency->format($order_data['total'] * 100, $order_data['currency_code'], $order_data['currency_value'], false) / 100;
        $this->data['currency_code'] = $order_data['currency_code'];
        $this->data['language_code'] = $order_data['language_code'];
        $this->data['salt'] = md5($this->config->get('paysondirect_secure_word')) . '1-' . $this->data['order_id'];
        //Customer info
        $this->data['sender_email'] = $order_data['email'];
        $this->data['sender_first_name'] = html_entity_decode($order_data['payment_firstname'], ENT_QUOTES, 'UTF-8');
        $this->data['sender_last_name'] = html_entity_decode($order_data['payment_lastname'], ENT_QUOTES, 'UTF-8');
        $this->data['sender_telephone'] = html_entity_decode($order_data['telephone'], ENT_QUOTES, 'UTF-8');
        $this->data['sender_address'] = html_entity_decode($order_data['payment_address_1'], ENT_QUOTES, 'UTF-8');
        $this->data['sender_postcode'] = html_entity_decode($order_data['payment_postcode'], ENT_QUOTES, 'UTF-8');
        $this->data['sender_city'] = html_entity_decode($order_data['payment_city'], ENT_QUOTES, 'UTF-8');
        $this->data['sender_countrycode'] = html_entity_decode($order_data['payment_country'], ENT_QUOTES, 'UTF-8');

        //Call PaysonAPI        
        $result = $this->getPaymentURL();

        $returnData = array();
        if ($result->status == "created") {
            $this->data['checkoutId'] = $result->id;
            $this->data['width'] = (int) $this->config->get('paysondirect_iframe_size_width');
            $this->data['height'] = (int) $this->config->get('paysondirect_iframe_size_height');
            $this->data['width_type'] = $this->config->get('paysondirect_iframe_size_width_type');
            $this->data['height_type'] = $this->config->get('paysondirect_iframe_size_height_type');
            $this->data['testMode'] = !$this->testMode ? TRUE : FALSE;
            $this->data['snippet'] = $result->snippet;
            
        } else {
            $returnData["error"] = $this->language->get("text_payson_payment_error");
        }

        //$this->response->setOutput(json_encode($returnData));
    }

    private function getPaymentURL() {
        require_once 'paysonEmbedded/paysonapi.php';
        $this->load->language('payment/paysondirect');

        $callPaysonApi = $this->getAPIInstanceMultiShop();
        $paysonMerchant = new PaysonEmbedded\PaysonMerchant($callPaysonApi->getMerchantId(), $this->data['checkout_url'], $this->data['ok_url'], $this->data['ipn_url'], "http://www.google.se/#q=terms", null, 'payson_opencart|' . $this->config->get('paysondirect_modul_version') . '|' . VERSION);
        
        $payData = new PaysonEmbedded\PayData();
        $payData->setCurrencyCode(PaysonEmbedded\CurrencyCode::ConstantToString($this->currencyPaysondirect()));
        $payData->setOrderItems($this->getOrderItems());
        $callPaysonApi->setPayData($payData);
        
        $callPaysonApi->setPaysonMerchant($paysonMerchant);
        
        $callPaysonApi->setCustomer(new PaysonEmbedded\Customer(
                $this->data['sender_first_name'], 
                $this->data['sender_last_name'], 
                $this->data['sender_email'],
                $this->data['sender_telephone'], 
                '',
                $this->data['sender_city'], 
                $this->data['sender_countrycode'], 
                $this->data['sender_postcode'],
                $this->data['sender_address'])
        );

        $callPaysonApi->setGui(new PaysonEmbedded\Gui($this->languagePaysondirect(), $this->config->get('paysondirect_color_scheme'), $this->config->get('paysondirect_gui_verification'), (int) $this->config->get('paysondirect_request_phone')));

        $paysonEmbeddedStatus = '';
        if ($this->getCheckoutIdPayson($this->session->data['order_id']) != Null) {

            $callPaysonApi->doRequest('GET', $this->getCheckoutIdPayson($this->session->data['order_id']));
            $paysonEmbeddedStatus = $callPaysonApi->getResponsObject()->status;
        }
        if ($this->getCheckoutIdPayson($this->session->data['order_id']) != Null AND $paysonEmbeddedStatus == 'readyToShip') {
           //$this->response->redirect($this->url->link('checkout/success'));
        }
        
        if ($this->getCheckoutIdPayson($this->session->data['order_id']) != Null AND $paysonEmbeddedStatus == 'created') {
            //$callPaysonApi->doRequest("PUT", $this->getCheckoutIdPayson($this->session->data['order_id']));
            //update order to denied and update the database
            $callPaysonApi->doRequest("POST");
            if ($callPaysonApi->getCheckoutId() != null) {
                $this->storePaymentResponseDatabase($callPaysonApi->getCheckoutId(), $this->session->data['order_id']);
            }
        } else {
            $callPaysonApi->doRequest("POST");
            if ($callPaysonApi->getCheckoutId() != null) {
                $this->storePaymentResponseDatabase($callPaysonApi->getCheckoutId(), $this->session->data['order_id']);
            }
        }

        if (count($callPaysonApi->getpaysonResponsErrors()) == 0) {
            //if checkoutId not null else write a log /TODO
            $callPaysonApi->doRequest();
            return $callPaysonApi->getResponsObject();
        } else {
            foreach ($callPaysonApi->getpaysonResponsErrors() as $value) {
                $message = '<Payson Embedded> ErrorId: ' . $value->getErrorId() . '  -- Message: ' . $value->getMessage() . '  -- Parameter: ' . $value->getParameter();
                $this->writeToLog($message);
            }
        }
        $this->paysonApiError('ERROR');
    }

    //Returns from Payson after the transaction has ended.
    public function returnFromPayson() {
        require_once 'paysonEmbedded/paysonapi.php';
        $this->load->model('checkout/order');
        $this->load->language('payment/paysondirect');

        $callPaysonApi = $this->getAPIInstanceMultiShop();

        if (count($callPaysonApi->getpaysonResponsErrors()) == 0) {
            $orderId = $this->session->data['order_id'];
            //Check if the checkoutid exist in the database.
            if ($this->getCheckoutIdPayson($orderId) != Null) {
                $callPaysonApi->doRequest('GET', $this->getCheckoutIdPayson($orderId));
                //This row update database with info from the return object.
                $this->updatePaymentResponseDatabase($callPaysonApi->getResponsObject(), $this->getCheckoutIdPayson($orderId), 'returnCall');
                //Create the order or
                $this->handlePaymentDetails($callPaysonApi->getResponsObject(), $orderId, 'returnCall');
            } else {
                $this->response->redirect($this->url->link('checkout/success'));
            }
        } else
            foreach ($callPaysonApi->getpaysonResponsErrors() as $value) {
                $message = '<Payson Embedded> ErrorId: ' . $value->getErrorId() . '  -- Message: ' . $value->getMessage() . '  -- Parameter: ' . $value->getParameter();
                $this->writeToLog('The IPN response from Payson:', $message);
            }
    }

    function paysonIpn() {
        require_once 'paysonEmbedded/paysonapi.php';
        $this->load->model('checkout/order');
        
        $callPaysonApi = $this->getAPIInstanceMultiShop();

        if (count($callPaysonApi->getpaysonResponsErrors()) == 0) {

            //Check if the checkoutid exist in the database.
            if (isset($this->request->get['checkout'])) {
                $callPaysonApi->doRequest('GET', $this->request->get['checkout']);
                //This row update database with info from the return object.
                $this->updatePaymentResponseDatabase($callPaysonApi->getResponsObject(), $this->request->get['checkout'], 'ipnCall');
                //Create, canceled or dinaid the order.
                $this->handlePaymentDetails($callPaysonApi->getResponsObject(), $this->request->get['order_id'], 'ipnCall');
            }
        } else
            foreach ($callPaysonApi->getpaysonResponsErrors() as $value) {
                $message = '<Payson Embedded> ErrorId: ' . $value->getErrorId() . '  -- Message: ' . $value->getMessage() . '  -- Parameter: ' . $value->getParameter();
                $this->writeToLog('The IPN response from Payson:', $message);
            }
    }

    /**
     * 
     * @param PaymentDetails $paymentDetails
     */
    private function handlePaymentDetails($paymentResponsObject, $orderId = 0, $ReturnCallUrl = Null) {
        $this->load->language('payment/paysondirect');
        $this->load->model('checkout/order');
        
        $orderIdTemp = $orderId ? $orderId : $this->session->data['order_id'];
        $paymentStatus = $paymentResponsObject->status;
        $paymentCheckoutId = $paymentResponsObject->id;

        $order_info = $this->model_checkout_order->getOrder($orderIdTemp);
        if (!$order_info) {
            return false;
        }

        $succesfullStatus = null;

        switch ($paymentStatus) {
            case "readyToShip":
                $succesfullStatus = $this->config->get('paysondirect_order_status_id');
                
                $comment = "Checkout ID: " . $paymentCheckoutId . "\n\n";
                $comment .= "Payson status: " . $paymentStatus . "\n\n";
                $comment .= "Paid Order: " . $orderIdTemp;
                $this->testMode ? $comment .= "\n\nPayment mode: " . 'TEST MODE' : '';
                
                $this->db->query("UPDATE `" . DB_PREFIX . "order` SET 
                                shipping_firstname  = '" . $paymentResponsObject->customer->firstName . "',
                                shipping_lastname   = '" . $paymentResponsObject->customer->lastName . "',
                                email               = '" . $paymentResponsObject->customer->email . "',
                                shipping_address_1  = '" . $paymentResponsObject->customer->street . "',
                                shipping_city       = '" . $paymentResponsObject->customer->city . "', 
                                shipping_country    = '" . $paymentResponsObject->customer->countryCode . "', 
                                shipping_postcode   = '" . $paymentResponsObject->customer->postalCode . "',
                                payment_code        = 'paysondirect'
                                WHERE order_id      = '" . $orderIdTemp . "'");

                $this->writeArrayToLog($comment);
                $this->model_checkout_order->addOrderHistory($orderIdTemp, $succesfullStatus, $comment, TRUE);
                $this->response->redirect($this->url->link('checkout/success'));
                break;
            case "denied":
                $this->paysonApiError($this->language->get('text_denied'));
                $this->updatePaymentResponseDatabase($paymentResponsObject, $orderId, $ReturnCallUrl);
                $this->response->redirect($this->url->link('checkout/cart'));
                break;
            case "canceled":
                $this->updatePaymentResponseDatabase($paymentResponsObject, $orderId, $ReturnCallUrl);
                $this->response->redirect($this->url->link('checkout/cart'));
                break;
            case "Expired":
                $this->writeToLog('Order was Expired by payson.&#10;Checkout status:&#9;&#9;' . $paymentStatus . '&#10;Checkout id:&#9;&#9;&#9;&#9;' . $paymentCheckoutId, $paymentResponsObject);
                return false;
                break;
            default:
                $this->writeToLog("Error status RetrunUrl");
                $this->response->redirect($this->url->link('checkout/cart'));
        }
    }

    function logErrorsAndReturnThem($response) {
        $errors = $response->getResponseEnvelope()->getErrors();

        if ($this->config->get('paysondirect_logg') == 1) {
            $this->writeToLog(print_r($errors, true));
        }

        return $errors;
    }
    private function getCredentials() {
        $storesInShop = $this->db->query("SELECT store_id FROM `" . DB_PREFIX . "store`");

        $numberOfStores = $storesInShop->rows;

        $keys = array_keys($numberOfStores);
        //Since the store table do not contain the fist storeID this must be entered manualy in the $shopArray below
        $shopArray = array(0 => 0);
        for ($i = 0; $i < count($numberOfStores); $i++) {

            foreach ($numberOfStores[$keys[$i]] as $value) {
                array_push($shopArray, $value);
            }
        }
        return $shopArray;
    }

    private function getAPIInstanceMultiShop() {
        require_once 'paysonEmbedded/paysonapi.php';
        /* Every interaction with Payson goes through the PaysonApi object which you set up as follows.  
            * For the use of our test or live environment use one following parameters:
            * TRUE: Use test environment, FALSE: use live environment */
        if (!$this->testMode) {
            $merchant = explode('##', $this->config->get('paysondirect_merchant_id'));
            $key = explode('##', $this->config->get('paysondirect_api_key'));
            
            $storeID = $this->config->get('config_store_id');
            $shopArray = $this->getCredentials();
            $multiStore = array_search($storeID, $shopArray);

            $merchant_id = $merchant[$multiStore];
            $api_key = $key[$multiStore];

            return new PaysonEmbedded\PaysonApi($merchant_id, $api_key, FALSE);
        }else {
            return new PaysonEmbedded\PaysonApi('4', '2acab30d-fe50-426f-90d7-8c60a7eb31d4', TRUE);
        }

        //return $callPaysonApi;
    }

    private function getOrderItems() {
        require_once 'paysonEmbedded/paysonapi.php';

        $this->load->language('payment/paysondirect');

        $orderId = $this->session->data['order_id'];

        $order_data = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $query = "SELECT `order_product_id`, `name`, `model`, `price`, `quantity`, `tax` / `price` as 'tax_rate' FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = " . (int) $orderId . " UNION ALL SELECT 0, '" . $this->language->get('text_gift_card') . "', `code`, `amount`, '1', 0.00 FROM `" . DB_PREFIX . "order_voucher` WHERE `order_id` = " . (int) $orderId;
        $product_query = $this->db->query($query)->rows;

        foreach ($product_query as $product) {

            $productOptions = $this->db->query("SELECT name, value FROM " . DB_PREFIX . 'order_option WHERE order_id = ' . (int) $orderId . ' AND order_product_id=' . (int) $product['order_product_id'])->rows;
            $optionsArray = array();
            if ($productOptions) {
                foreach ($productOptions as $option) {
                    $optionsArray[] = $option['name'] . ': ' . $option['value'];
                }
            }

            $productTitle = $product['name'];

            if (!empty($optionsArray))
                $productTitle .= ' | ' . join('; ', $optionsArray);

            $productTitle = (strlen($productTitle) > 80 ? substr($productTitle, 0, strpos($productTitle, ' ', 80)) : $productTitle);

            //$product_price = $this->currency->format($product['price'] * 100, $order_data['currency_code'], $order_data['currency_value'], false) / 100;
			$product_price = $this->currency->format(($product['price'] + ($product['price']*$product['tax_rate'])), $order_data['currency_code'], $order_data['currency_value'], false);

            $this->data['order_items'][] = new PaysonEmbedded\OrderItem(html_entity_decode($productTitle, ENT_QUOTES, 'UTF-8'), $product_price, $product['quantity'], $product['tax_rate']);
        }

        $orderTotals = $this->getOrderTotals();
        foreach ($orderTotals as $orderTotal) {
            $orderTotalAmount = $this->currency->format($orderTotal['value'] * 100, $order_data['currency_code'], $order_data['currency_value'], false) / 100;
            if ($orderTotalAmount == null || $orderTotalAmount == 0) {
                break;
            }
            $orderTotalTemp = new PaysonEmbedded\OrderItem(html_entity_decode($orderTotal['title'], ENT_QUOTES, 'UTF-8'), $orderTotalAmount * (1 + $orderTotal['tax_rate'] / 100), 1, $orderTotal['tax_rate'] / 100);

            if ($orderTotal['code'] == 'coupon') {
                $orderTotalTemp->setType('discount');
            }

            if ($orderTotal['code'] == 'voucher') {
                $orderTotalTemp->setType('discount');
            }

            if ($orderTotal['code'] == 'shipping') {
                $orderTotalTemp->setType('service');
            }

            $this->data['order_items'][] = $orderTotalTemp;
        }
        return $this->data['order_items'];
    }

    private function getOrderTotals() {
        $total_data = array();
        $total = 0;
        $payson_tax = array();

        $cartTax = $this->cart->getTaxes();


        $this->load->model('extension/extension');

        $sort_order = array();

        $results = $this->model_extension_extension->getExtensions('total');

        foreach ($results as $key => $value) {
            $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
        }

        array_multisort($sort_order, SORT_ASC, $results);

        foreach ($results as $result) {

            if ($this->config->get($result['code'] . '_status')) {
                $amount = 0;
                $taxes = array();
                foreach ($cartTax as $key => $value) {
                    $taxes[$key] = 0;
                }
                $this->load->model('total/' . $result['code']);

                $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);

                foreach ($taxes as $tax_id => $value) {
                    $amount += $value;
                }

                $payson_tax[$result['code']] = $amount;
            }
        }

        $sort_order = array();

        foreach ($total_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $total_data);

        foreach ($total_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];

            if (isset($payson_tax[$value['code']])) {
                if ($payson_tax[$value['code']]) {
                    $total_data[$key]['tax_rate'] = abs($payson_tax[$value['code']] / $value['value'] * 100);
                } else {
                    $total_data[$key]['tax_rate'] = 0;
                }
            } else {
                $total_data[$key]['tax_rate'] = '0';
            }
        }
        $ignoredTotals = $this->config->get('paysondirect_ignored_order_totals');
        if ($ignoredTotals == null)
            $ignoredTotals = 'sub_total, total, taxes';

        $ignoredOrderTotals = array_map('trim', explode(',', $ignoredTotals));
        foreach ($total_data as $key => $orderTotal) {
            if (in_array($orderTotal['code'], $ignoredOrderTotals)) {
                unset($total_data[$key]);
            }
        }

        return $total_data;
    }

    /**
     * 
     * @param PaymentDetails $paymentDetails
     * @param checkout_id int $id
     */
    private function updatePaymentResponseDatabase($paymentDetails, $id, $call = 'returnCall') {
        $this->db->query("UPDATE `" . DB_PREFIX . "payson_embedded_order` SET 
                        payment_status  = '" . $paymentDetails->status . "',
                        updated                       = NOW(), 
                        sender_email                  = 'sender_email', 
                        currency_code                 = 'currency_code',
                        tracking_id                   = 'tracking_id',
                        type                          = 'type',
                        shippingAddress_name          = '" . $paymentDetails->customer->firstName . "', 
                        shippingAddress_lastname      = '" . $paymentDetails->customer->lastName . "', 
                        shippingAddress_street_ddress = '" . $paymentDetails->customer->street . "',
                        shippingAddress_postal_code   = '" . $paymentDetails->customer->postalCode . "',
                        shippingAddress_city          = '" . $paymentDetails->customer->city . "', 
                        shippingAddress_country       = '" . $paymentDetails->customer->countryCode . "'
			WHERE  checkout_id            = '" . $id . "'"
        );
    }

    private function storePaymentResponseDatabase($checkoutId, $orderId) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "payson_embedded_order SET 
                            payson_embedded_id  = '',
                            order_id            = '" . $orderId . "', 
                            checkout_id         = '" . $checkoutId . "', 
                            purchase_id         = '" . $checkoutId . "',
                            payment_status      = 'created', 
                            added               = NOW(), 
                            updated             = NOW()"
        );
    }

    private function getCheckoutIdPayson($order_id) {
        $query = $this->db->query("SELECT `checkout_id` FROM `" . DB_PREFIX . "payson_embedded_order` WHERE order_id = '" . (int) $order_id . "' AND payment_status = 'created'ORDER BY `added` DESC");
        if ($query->num_rows && $query->row['checkout_id']) {
            return $query->row['checkout_id'];
        } else {
            return null;
        }
    }

    private function getOrderIdPayson($checkout_id) {
        $query = $this->db->query("SELECT `order_id` FROM `" . DB_PREFIX . "payson_embedded_order` WHERE checkout_id = '" . (int) $order_id . "' AND payment_status = 'created'");
        if ($query->num_rows && $query->row['checkout_id']) {
            return $query->row['order_id'];
        } else {
            return null;
        }
    }

    public function languagePaysondirect() {
        switch (strtoupper($this->data['language_code'])) {
            case "SE":
            case "SV":
                return "SE";
            case "FI":
                return "FI";
            case "DK":
                return "DK";
            case "NO":
                return "NO";
            default:
                return "EN";
        }
    }

    public function currencyPaysondirect() {
        switch (strtoupper($this->data['currency_code'])) {
            case "SEK":
                return "SEK";
            default:
                return "EUR";
        }
    }

    /**
     * 
     * @param string $message
     * @param PaymentDetails $paymentDetails
     */
    function writeToLog($message, $paymentResponsObject = False) {
        $paymentDetailsFormat = "Payson reference:&#9;%s&#10;Correlation id:&#9;%s&#10;";
        if ($this->config->get('paysondirect_logg') == 1) {

            $this->log->write('PAYSON&#10;' . $message . '&#10;' . ($paymentResponsObject != false ? sprintf($paymentDetailsFormat, $paymentResponsObject->status, $paymentResponsObject->id) : '') . $this->writeModuleInfoToLog());
        }
    }

    private function writeArrayToLog($array, $additionalInfo = "") {
        if ($this->config->get('paysondirect_logg') == 1) {
            $this->log->write('PAYSON&#10;Additional information:&#9;' . $additionalInfo . '&#10;&#10;' . print_r($array, true) . '&#10;' . $this->writeModuleInfoToLog());
        }
    }

    private function writeModuleInfoToLog() {
        return 'Module version: ' . $this->config->get('paysondirect_modul_version') . '&#10;------------------------------------------------------------------------&#10;';
    }

    public function paysonApiError($error) {
        $this->load->language('payment/paysondirect');
        $error_code = '<html>
                            <head>
                                <script type="text/javascript"> 
                                    alert("' . $error . $this->language->get('text_payson_payment_method') . '");
                                    window.location="' . (HTTPS_SERVER . 'index.php?route=checkout/cart') . '";
                                </script>
                            </head>
                    </html>';
        echo ($error_code);
        exit;
    }
}
?>