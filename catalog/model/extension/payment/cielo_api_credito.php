<?php
class ModelExtensionPaymentCieloApiCredito extends Model {
    public function getMethod($address, $total) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cielo_api_credito_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('cielo_api_credito_total') > 0 && $this->config->get('cielo_api_credito_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('cielo_api_credito_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $currencies = array('BRL');
        $currency_code = $this->session->data['currency'];
        if (!in_array(strtoupper($currency_code), $currencies)) {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            if (strlen(trim($this->config->get('cielo_api_credito_imagem'))) > 0) {
                $title = '<img src="'. HTTPS_SERVER .'image/'.$this->config->get('cielo_api_credito_imagem').'" alt="'.$this->config->get('cielo_api_credito_titulo').'" title="'.$this->config->get('cielo_api_credito_titulo').'" />';
            } else {
                $title = $this->config->get('cielo_api_credito_titulo');
            }

            $method_data = array(
                'code' => 'cielo_api_credito',
                'title' => $title,
                'terms' => '',
                'sort_order' => $this->config->get('cielo_api_credito_sort_order')
            );
        }

        return $method_data;
    }

    public function getOrder($data, $order_id) {
        $columns = implode(", ", array_values($data));

        $query = $this->db->query("SELECT " . $columns . " FROM `" . DB_PREFIX . "order` WHERE `order_id` = '" . (int)$order_id . "'");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT op.name, op.price, op.tax, op.quantity, p.sku FROM `" . DB_PREFIX . "order_product` op INNER JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) WHERE op.order_id = '" . (int)$order_id . "'");

        return $query->rows;
    }

    public function getOrderShipping($order_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' AND code = 'shipping'");

        return $query->row;
    }

    public function getOrderShippingValue($order_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

        $value = 0;
        foreach ($query->rows as $total) {
            if ($total['value'] > 0) {
                if ($total['code'] == "shipping") {
                    $value += $total['value'];
                }
            }
        }

        return $value;
    }

    public function addTransaction($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'".implode("', '", array_values($data))."'";
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_cielo_api` ($columns) VALUES ($values)");
    }
}