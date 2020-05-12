<?php

 
class ControllerExtensionTotalDiscountorder extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/total/discountorder');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('discountorder', $this->request->post);

			//print_r($this->request->post);
			//die();
			
			$this->session->data['success'] = $this->language->get('text_success_order_discount');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');		
		
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_order_price_qunatity'] = $this->language->get('entry_order_price_qunatity');
		$data['entry_order_discount_type'] = $this->language->get('entry_order_discount_type');
		$data['entry_order_discount_label'] = $this->language->get('entry_order_discount_label');
		$data['entry_order_discount_value'] = $this->language->get('entry_order_discount_value');
		$data['entry_discountorder_sort_order'] = $this->language->get('entry_discountorder_sort_order');
		
		$data['text_edit_order_discount'] = $this->language->get('text_edit_order_discount');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_percent_order_discount'] = $this->language->get('text_percent_order_discount');
		$data['text_fix_order_discount'] = $this->language->get('text_fix_order_discount');		
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total_order_discount'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/discountorder', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/total/discountorder', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', true);

		if (isset($this->request->post['discountorder_status'])) {
			$data['discountorder_status'] = $this->request->post['discountorder_status'];
		} else {
			$data['discountorder_status'] = $this->config->get('discountorder_status');
		}
		
		if (isset($this->request->post['discountorder_pricequantity'])) {
			$data['discountorder_pricequantity'] = $this->request->post['discountorder_pricequantity'];
		} else {
			$data['discountorder_pricequantity'] = $this->config->get('discountorder_pricequantity');
		}

		
		if (isset($this->request->post['discountorder_distype'])) {
			$data['discountorder_distype'] = $this->request->post['discountorder_distype'];
		} else {
			$data['discountorder_distype'] = $this->config->get('discountorder_distype');
		}
		
		if (isset($this->request->post['discountorder_on_pr_qu'])) {
			$data['discountorder_on_pr_qu'] = $this->request->post['discountorder_on_pr_qu'];
		} else {
			$data['discountorder_on_pr_qu'] = $this->config->get('discountorder_on_pr_qu');
		}
		
		
		if (isset($this->request->post['discountorder_disvalue'])) {
			$data['discountorder_disvalue'] = $this->request->post['discountorder_disvalue'];
		} else {
			$data['discountorder_disvalue'] = $this->config->get('discountorder_disvalue');
		}
		
		
		if (isset($this->request->post['discountorder_sort_order'])) {
			$data['discountorder_sort_order'] = $this->request->post['discountorder_sort_order'];
		} else {
			$data['discountorder_sort_order'] = $this->config->get('discountorder_sort_order');
		}
		
		
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/discountorder.tpl', $data));
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/total/discountorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}