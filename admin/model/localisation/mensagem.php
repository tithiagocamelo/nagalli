<?php
class ModelLocalisationMensagem extends Model {
	public function addMensagem($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "mensagem SET titulo = '" . $this->db->escape($data['titulo']) . "', mensagem = '" . $this->db->escape($data['mensagem']) . "'");

		$mensagem_id = $this->db->getLastId();

		$this->cache->delete('mensagem');
		
		return $mensagem_id;
	}

	public function editMensagem($mensagem_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "mensagem SET titulo = '" . $this->db->escape($data['titulo']) . "', mensagem = '" . $this->db->escape($data['mensagem']) . "' WHERE mensagem_id = '" . (int)$mensagem_id . "'");
		
		return $mensagem_id;
	}

	public function deleteMensagem($mensagem_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "mensagem WHERE mensagem_id = '" . (int)$mensagem_id . "'");

		$this->cache->delete('mensagem');
	}

	public function getMensagem($mensagem_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mensagem WHERE mensagem_id = '" . (int)$mensagem_id . "'");

		return $query->row;
	}

	public function getMensagens($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "mensagem";

			$sql .= " ORDER BY titulo";

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$mensagem_data = $this->cache->get('mensagem');

			if (!$mensagem_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mensagem ORDER BY titulo");

				$mensagem_data = $query->rows;

				$this->cache->set('mensagem', $mensagem_data);
			}

			return $mensagem_data;
		}
	}

	public function getTotalMensagens() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "mensagem");

		return $query->row['total'];
	}
}