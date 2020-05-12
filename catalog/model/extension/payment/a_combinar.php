<?php
class ModelExtensionPaymentACombinar extends Model {
	public function getMethod($address, $total) {

		$this->load->language('extension/payment/a_combinar');

		$valor_minimo = 0.00;

		if ($total >= $valor_minimo) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'a_combinar',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('a_combinar_sort_order')
			);
		}

		return $method_data;
	}
}