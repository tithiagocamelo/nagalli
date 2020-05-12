<?php
class ControllerLocalisationMensagem extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('localisation/mensagem');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/mensagem');

		$this->getList();
	}

	public function add() {
		$this->load->language('localisation/mensagem');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/mensagem');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_mensagem->addMensagem($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('localisation/mensagem');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/mensagem');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_mensagem->editMensagem($this->request->get['mensagem_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function get() {
		
		$this->load->model('localisation/mensagem');

		$mensagem_id = $this->request->post['mensagem_id'];

		if($mensagem_id) {
			$json['data'] = $this->model_localisation_mensagem->getMensagem($mensagem_id);
		} else {
			$json['error'] = true;
			$json['message'] = 'mensagem_id não informado.';
		}
		
		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('localisation/mensagem');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/mensagem');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $mensagem_id) {
				$this->model_localisation_mensagem->deleteMensagem($mensagem_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'mensagem';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('localisation/mensagem/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('localisation/mensagem/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['mensagens'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$mensagem_total = $this->model_localisation_mensagem->getTotalMensagens();

		$results = $this->model_localisation_mensagem->getMensagens($filter_data);

		foreach ($results as $result) {
			$data['mensagens'][] = array(
				'mensagem_id' => $result['mensagem_id'],
				'titulo'            => $result['titulo'],
				'edit'            => $this->url->link('localisation/mensagem/edit', 'token=' . $this->session->data['token'] . '&mensagem_id=' . $result['mensagem_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_mensagem'] = $this->language->get('column_mensagem');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_mensagem'] = $this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . '&sort=mensagem' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $mensagem_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($mensagem_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($mensagem_total - $this->config->get('config_limit_admin'))) ? $mensagem_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $mensagem_total, ceil($mensagem_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/mensagem_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['mensagem_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_titulo'] = $this->language->get('entry_titulo');
		$data['entry_mensagem'] = $this->language->get('entry_mensagem');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['mensagem'])) {
			$data['error_mensagem'] = $this->error['mensagem'];
		} else {
			$data['error_mensagem'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['mensagem_id'])) {
			$data['action'] = $this->url->link('localisation/mensagem/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('localisation/mensagem/edit', 'token=' . $this->session->data['token'] . '&mensagem_id=' . $this->request->get['mensagem_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('localisation/mensagem', 'token=' . $this->session->data['token'] . $url, true);

		$this->load->model('localisation/language');

		if(isset($this->request->get['mensagem_id'])) {
			$mensagem_info = $this->model_localisation_mensagem->getMensagem($this->request->get['mensagem_id']);
		}

		if (isset($this->request->post['titulo'])) {
			$data['titulo'] = $this->request->post['titulo'];
		} elseif (isset($this->request->get['mensagem_id'])) {
			$data['titulo'] = $mensagem_info['titulo'];
		} else {
			$data['titulo'] = '';
		}

		if (isset($this->request->post['mensagem'])) {
			$data['mensagem'] = $this->request->post['mensagem'];
		} elseif (isset($this->request->get['mensagem_id'])) {
			$data['mensagem'] = $mensagem_info['mensagem'];
		} else {
			$data['mensagem'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/mensagem_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/mensagem')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['titulo']) < 3) {
			$this->error['titulo'] = $this->language->get('error_titulo');
		}
		
		if (utf8_strlen($this->request->post['mensagem']) < 3) {
			$this->error['mensagem'] = $this->language->get('error_mensagem');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/mensagem')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $mensagem_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByMensagemId($mensagem_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		return !$this->error;
	}


}