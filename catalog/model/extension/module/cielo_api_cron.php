<?php
class ModelExtensionModuleCieloApiCron extends Model {
    public function getTransactions($data = array()) {
        $qry = $this->db->query("
            SELECT oca.order_id, oca.order_cielo_api_id FROM `" . DB_PREFIX . "order_cielo_api` oca
            INNER JOIN `" . DB_PREFIX . "order` o ON (o.order_id = oca.order_id)
            WHERE (oca.tipo = 'EletronicTransfer' OR oca.tipo = 'Boleto') AND
               (o.order_status_id = '" . $this->config->get('cielo_api_transferencia_situacao_gerada_id') . "'
               OR o.order_status_id = '" . $this->config->get('cielo_api_boleto_situacao_gerado_id') . "'
               OR o.order_status_id = '" . $this->config->get('cielo_api_transferencia_situacao_pendente_id') . "'
               OR o.order_status_id = '" . $this->config->get('cielo_api_boleto_situacao_pendente_id') . "')
        ");

        return $qry->rows;
    }

    public function getTransaction($order_cielo_api_id) {
        $query = $this->db->query("
            SELECT * 
            FROM `" . DB_PREFIX . "order_cielo_api` 
            WHERE `order_cielo_api_id` = '" . (int) $order_cielo_api_id . "'
        ");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function updateTransaction($data) {
        $this->db->query("
            UPDATE " . DB_PREFIX . "order_cielo_api
            SET status = '" . $this->db->escape($data['status']) . "',
                boletoPagamento = '" . $this->db->escape($data['boletoPagamento']) . "',
                boletoValor = '" . $this->db->escape($data['boletoValor']) . "',
                transferenciaPagamento = '" . $this->db->escape($data['transferenciaPagamento']) . "',
                transferenciaValor = '" . $this->db->escape($data['transferenciaValor']) . "'
            WHERE order_cielo_api_id = '" . (int) $data['order_cielo_api_id'] . "'
        ");
    }

    public function updateTransactionStatus($data) {
        $this->db->query("
            UPDATE " . DB_PREFIX . "order_cielo_api
            SET status = '" . $this->db->escape($data['status']) . "'
            WHERE order_cielo_api_id = '" . (int) $data['order_cielo_api_id'] . "'
        ");
    }
}