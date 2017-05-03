<?php

class ModelPaymentPaysonCheckout2 extends Model {

    private $currency_supported_by_p_direct = array('SEK', 'EUR');
    private $minimumAmountSEK = 6;
    private $minimumAmountEUR = 0.6;
    private $maxAmountSEK = 40000;
    private $maxAmountEUR = 3000;


    public function getMethod($address, $total) {
        $this->language->load('payment/paysonCheckout2');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('paysonCheckout2_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('paysonCheckout2_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('paysonCheckout2_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }
        if(strtoupper($this->config->get('config_currency')) == 'SEK' && ($total < $this->minimumAmountSEK || $total > $this->maxAmountSEK)){
            $status = false;
        }
        if(strtoupper($this->config->get('config_currency')) == 'EUR' && ($total < $this->minimumAmountEUR || $total > $this->maxAmountEUR)){
            $status = false;
        }
        if (!in_array(strtoupper($this->session->data['currency']), $this->currency_supported_by_p_direct)) {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'paysonCheckout2',
				'image' => 'https://www.payson.se/sites/all/files/images/external/payson_opencart.png',
                'title' => 'Faktura, kort, bankbetalning<br />',
                'terms' => '',
                'sort_order' => $this->config->get('paysonCheckout2_sort_order')
            );
        }

        return $method_data;
    }

}

?>