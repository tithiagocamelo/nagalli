<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = sprintf($this->language->get('text_footer'), $this->config->get('config_name'));

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$data['text_version'] = sprintf($this->language->get('text_version'));
		} else {
			$data['text_version'] = '';
		}
		
		return $this->load->view('common/footer', $data);
	}
}
