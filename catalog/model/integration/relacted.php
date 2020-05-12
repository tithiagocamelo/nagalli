<?php

class ModelIntegrationRelacted extends Model {

	public function addRelacted($data) {

		if (isset($data['product_related'])) {

			foreach ($data['product_related'] as $related) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related 
					WHERE 
					product_id = '" . (int)$related['product_id'] . "' AND 
					related_id = '" . (int)$related['relacted_id'] . "'");
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related 
					SET 
					product_id = '" . (int)$related['product_id'] . "', 
					related_id = '" . (int)$related['relacted_id'] . "'");
			}

		}

		$this->cache->delete('related');

	}

}