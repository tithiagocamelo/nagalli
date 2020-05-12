<?php
/*
@idiotique
jssorslider.v.1.0.1
- Random Caption Translation
*/
class Controllerextensionmodulejssorslider extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
		
		$this->document->addStyle('catalog/view/javascript/jquery/jssorslider/jssor.css');
		$this->document->addScript('catalog/view/javascript/jquery/jssorslider/jssor.js');
		$this->document->addScript('catalog/view/javascript/jquery/jssorslider/jssor.slider.js');
		$this->document->addScript('catalog/view/javascript/jquery/jssorslider/jssorsetting.js');

		$data['width'] = isset($setting['width']) ? $setting['width'] : 1140;
		$data['height'] = isset($setting['height']) ? $setting['height'] : 350;

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner(isset($setting['banner_id']) ? $setting['banner_id'] : 7);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], 1140, 350)
				);
			}
		}

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/jssor_slider.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/extension/module/jssor_slider.tpl', $data);
		} else {
			return $this->load->view('extension/module/jssor_slider.tpl', $data);
		}
	}
}