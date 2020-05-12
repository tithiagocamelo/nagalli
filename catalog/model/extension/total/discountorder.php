<?php

 
class ModelExtensionTotalDiscountorder extends Model {
	
	public function getTotal($total) {
		
		$this->load->language('extension/total/discountorder');
		
		$discountorder = 0;
		$get_sub_total = $this->cart->getSubTotal();
		$total_qunatity_cart =  $this->cart->countProducts();

		if( isset($this->session->data['payment_method']['code']) and ($this->session->data['payment_method']['code'] == 'bank_transfer' )) {
		
			// if($get_sub_total > 2000) {
			// 	// 25%
			// 	$discountorder = $get_sub_total * 25 / 100;
			// } else if($get_sub_total > 1500) {
			// 	// 20%
			// 	$discountorder = $get_sub_total * 20 / 100;
			// } else if($get_sub_total > 1300) {
			// 	// 15%
			// 	$discountorder = $get_sub_total * 15 / 100;
			// } else if($get_sub_total > 300) {
			// 	// 10%
			// 	$discountorder = $get_sub_total * 10 / 100;
			// } else {
			// 	// 0%
			// 	$discountorder = 0;
			// }

			if($this->config->get('discountorder_distype') == 'percent') {
				$discountorder = $get_sub_total * $this->config->get('discountorder_disvalue') / 100;
			} else {
				$discountorder = $this->config->get('discountorder_disvalue');
			}

		}
		
		
		$total['totals'][] = array(
			'code'       => 'discountorder',
			'title'      => $this->language->get('text_discountorder'),
			'value'      => $discountorder,
			'sort_order' => $this->config->get('discountorder_sort_order')
		);

		$total['total'] -= $discountorder;
	}
}