<?php
class ModelExtensionPaymentCieloApiTransferencia extends Model {
    public function getMethod($address, $total) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cielo_api_transferencia_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('cielo_api_transferencia_total') > 0 && $this->config->get('cielo_api_transferencia_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('cielo_api_transferencia_geo_zone_id')) {
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
            if (strlen(trim($this->config->get('cielo_api_transferencia_imagem'))) > 0) {
                $title = '<img src="'.HTTPS_SERVER.'image/'.$this->config->get('cielo_api_transferencia_imagem').'" alt="'.$this->config->get('cielo_api_transferencia_titulo').'" title="'.$this->config->get('cielo_api_transferencia_titulo').'" />';
            } else {
                $title = $this->config->get('cielo_api_transferencia_titulo');
            }

            $method_data = array(
                'code' => 'cielo_api_transferencia',
                'title' => $title,
                'terms' => '',
                'sort_order' => $this->config->get('cielo_api_transferencia_sort_order')
            );
        }

        return $method_data;
    }

    public function addTransaction($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'".implode("', '", array_values($data))."'";
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_cielo_api` ($columns) VALUES ($values)");
    }
}
