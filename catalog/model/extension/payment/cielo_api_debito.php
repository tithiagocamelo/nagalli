<?php
class ModelExtensionPaymentCieloApiDebito extends Model {
    public function getMethod($address, $total) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cielo_api_debito_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('cielo_api_debito_total') > 0 && $this->config->get('cielo_api_debito_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('cielo_api_debito_geo_zone_id')) {
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
            if (strlen(trim($this->config->get('cielo_api_debito_imagem'))) > 0) {
                $title = '<img src="'.HTTPS_SERVER.'image/'.$this->config->get('cielo_api_debito_imagem').'" alt="'.$this->config->get('cielo_api_debito_titulo').'" title="'.$this->config->get('cielo_api_debito_titulo').'" />';
            } else {
                $title = $this->config->get('cielo_api_debito_titulo');
            }

            $method_data = array(
                'code' => 'cielo_api_debito',
                'title' => $title,
                'terms' => '',
                'sort_order' => $this->config->get('cielo_api_debito_sort_order')
            );
        }

        return $method_data;
    }

    public function getTransaction($order_cielo_api_id) {
        $query = $this->db->query("
            SELECT * 
            FROM `" . DB_PREFIX . "order_cielo_api` 
            WHERE `order_cielo_api_id` = '" . (int)$order_cielo_api_id . "'
        ");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function addTransaction($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'".implode("', '", array_values($data))."'";
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_cielo_api` ($columns) VALUES ($values)");

        return $this->db->getLastId();
    }

    public function updateTransaction($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_cielo_api` 
            SET status = '" . $this->db->escape($data['status']) . "',
                autorizacaoData = '" . $this->db->escape($data['autorizacaoData']) . "',
                autorizacaoValor = '" . $this->db->escape($data['autorizacaoValor']) . "',
                capturaData = '" . $this->db->escape($data['capturaData']) . "',
                capturaValor = '" . $this->db->escape($data['capturaValor']) . "',
                json = '" . $data['json'] . "'
            WHERE order_cielo_api_id = '" . (int)$data['order_cielo_api_id'] . "'
        ");
    }

    public function updateTransactionStatus($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_cielo_api` 
            SET status = '" . $this->db->escape($data['status']) . "',
                json = '" . $data['json'] . "'
            WHERE order_cielo_api_id = '" . (int)$data['order_cielo_api_id'] . "'
        ");
    }
}