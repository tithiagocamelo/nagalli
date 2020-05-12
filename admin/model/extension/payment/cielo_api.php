<?php
class ModelExtensionPaymentCieloApi extends Model {
    public function install_table() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "order_cielo_api` (
                `order_cielo_api_id` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` INT(11) NULL,
                `paymentId` VARCHAR(36) NULL,
                `status` VARCHAR(2) NULL,
                `tipo` VARCHAR(20) NULL,
                `antifraude` INT(1) NULL,
                `tid` VARCHAR(20) NULL,
                `authorizationCode` VARCHAR(6) NULL,
                `bandeira` VARCHAR(10) NULL,
                `eci` VARCHAR(1) NULL,
                `parcelas` VARCHAR(2) NULL,
                `autorizacaoData` VARCHAR(20) NULL,
                `autorizacaoValor` VARCHAR(15) NULL,
                `capturaData` VARCHAR(20) NULL,
                `capturaValor` VARCHAR(15) NULL,
                `cancelaData` VARCHAR(20) NULL,
                `cancelaValor` VARCHAR(15) NULL,
                `boletoData` VARCHAR(20) NULL,
                `boletoVencimento` VARCHAR(20) NULL,
                `boletoPagamento` VARCHAR(20) NULL,
                `boletoValor` VARCHAR(15) NULL,
                `transferenciaData` VARCHAR(20) NULL,
                `transferenciaPagamento` VARCHAR(20) NULL,
                `transferenciaValor` VARCHAR(15) NULL,
                `json` TEXT NULL,
                PRIMARY KEY (`order_cielo_api_id`)
            );
        ");
    }

    public function update_table() {
        $this->install_table();

        $fields = array(
            'order_cielo_api_id' => 'int(11)',
            'order_id' => 'int(11)',
            'paymentId' => 'varchar(36)',
            'status' => 'varchar(2)',
            'tipo' => 'varchar(20)',
            'antifraude' => 'int(1)',
            'tid' => 'varchar(20)',
            'authorizationCode' => 'varchar(6)',
            'bandeira' => 'varchar(10)',
            'eci' => 'varchar(1)',
            'parcelas' => 'varchar(2)',
            'autorizacaoData' => 'varchar(20)',
            'autorizacaoValor' => 'varchar(15)',
            'capturaData' => 'varchar(20)',
            'capturaValor' => 'varchar(15)',
            'cancelaData' => 'varchar(20)',
            'cancelaValor' => 'varchar(15)',
            'boletoData' => 'varchar(20)',
            'boletoVencimento' => 'varchar(20)',
            'boletoPagamento' => 'varchar(20)',
            'boletoValor' => 'varchar(15)',
            'transferenciaData' => 'varchar(20)',
            'transferenciaPagamento' => 'varchar(20)',
            'transferenciaValor' => 'varchar(15)',
            'json' => 'text'
        );

        $table = DB_PREFIX . "order_cielo_api";

        $field_query = $this->db->query("SHOW COLUMNS FROM `" . $table . "`");
        foreach ($field_query->rows as $field) {
            $field_data[$field['Field']] = $field['Type'];
        }

        foreach ($field_data as $key => $value) {
            if (!array_key_exists($key, $fields)) {
                $this->db->query("ALTER TABLE `" . $table . "` DROP COLUMN `" . $key . "`");
            }
        }

        $after_column = 'order_cielo_api_id';
        foreach ($fields as $key => $value) {
            if (!array_key_exists($key, $field_data)) {
                $this->db->query("ALTER TABLE `" . $table . "` ADD `" . $key . "` " . $value . " AFTER `" . $after_column . "`");
            }
            $after_column = $key;
        }

        foreach ($fields as $key => $value) {
            if ($key == 'order_cielo_api_id') {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $key . "` `" . $key . "` " . $value . " NOT NULL AUTO_INCREMENT");
            } else {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $key . "` `" . $key . "` " . $value);
            }
        }
    }

    public function uninstall_table() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "order_cielo_api`;");
    }

    public function getTransactions() {
        $query = $this->db->query("
            SELECT oc.order_id, oc.order_cielo_api_id, o.date_added, CONCAT(o.firstname, ' ', o.lastname) as customer, oc.tipo, oc.status FROM `" . DB_PREFIX . "order_cielo_api` oc
            INNER JOIN `" . DB_PREFIX . "order` o ON (o.order_id = oc.order_id)
            WHERE oc.order_id > '0' ORDER BY oc.order_id DESC;
        ");

        return $query->rows;
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
            UPDATE `" . DB_PREFIX . "order_cielo_api`
            SET status = '" . $this->db->escape($data['status']) . "',
                eci = '" . $this->db->escape($data['eci']) . "',
                autorizacaoData = '" . $this->db->escape($data['autorizacaoData']) . "',
                autorizacaoValor = '" . $this->db->escape($data['autorizacaoValor']) . "',
                capturaData = '" . $this->db->escape($data['capturaData']) . "',
                capturaValor = '" . $this->db->escape($data['capturaValor']) . "',
                cancelaData = '" . $this->db->escape($data['cancelaData']) . "',
                cancelaValor = '" . $this->db->escape($data['cancelaValor']) . "',
                boletoPagamento = '" . $this->db->escape($data['boletoPagamento']) . "',
                boletoValor = '" . $this->db->escape($data['boletoValor']) . "',
                transferenciaPagamento = '" . $this->db->escape($data['transferenciaPagamento']) . "',
                transferenciaValor = '" . $this->db->escape($data['transferenciaValor']) . "'
            WHERE order_cielo_api_id = '" . (int) $data['order_cielo_api_id'] . "'
        ");
    }

    public function updateTransactionStatus($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_cielo_api`
            SET status = '" . $this->db->escape($data['status']) . "'
            WHERE order_cielo_api_id = '" . (int) $data['order_cielo_api_id'] . "'
        ");
    }

    public function captureTransaction($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_cielo_api`
            SET status = '" . $this->db->escape($data['status']) . "',
                json = '" . $data['json'] . "'
            WHERE order_cielo_api_id = '" . (int) $data['order_cielo_api_id'] . "'
        ");
    }

    public function cancelTransaction($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_cielo_api`
            SET status = '" . $this->db->escape($data['status']) . "',
                json = '" . $data['json'] . "'
            WHERE order_cielo_api_id = '" . (int) $data['order_cielo_api_id'] . "'
        ");
    }

    public function deleteTransaction($order_cielo_api_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "order_cielo_api` WHERE order_cielo_api_id = '" . (int) $order_cielo_api_id . "'");
    }

    public function getOrder($data, $order_id) {
        $columns = implode(", ", array_values($data));

        $query = $this->db->query("
            SELECT " . $columns . " 
            FROM `" . DB_PREFIX . "order` 
            WHERE `order_id` = '" . (int) $order_id . "'
        ");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function getOrderShipping($order_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int) $order_id . "' ORDER BY sort_order ASC");

        $shipping = array();
        foreach ($query->rows as $total) {
            if ($total['value'] > 0) {
                if ($total['code'] == "shipping") {
                    $shipping[] = array(
                        'code' => $total['code'],
                        'title' => $total['title'],
                        'value' => $total['value']
                    );
                }
            }
        }

        return $shipping;
    }

    public function getOrderColumns($data = array()) {
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order`");

        return $query->rows;
    }
}