<?php


class ControllerExtensionModuleCorreios extends Controller {
	
	public function index($return) {

		$this->load->model('account/return');

		$return_id = $return['return_id'];
		
		// buscar codigo via curl

		// gerar historico
		$data['return_status_id'] = '3';
		$data['notify'] = '1';
		$data['comment'] = 'Teste: 0aw3d5a1wd35aw1d3';

		if(isset($return_id) and $return_id > 0) {
			$this->load->model_account_return->addReturnHistory($return_id, $data);
		}

		// retornar codigo
	}
}