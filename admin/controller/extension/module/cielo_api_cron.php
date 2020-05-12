<?php
class ControllerExtensionModuleCieloApiCron extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/cielo_api_cron');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cielo_api_cron', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] == '1')) {
                $this->response->redirect($this->url->link('extension/module/cielo_api_cron', 'token=' . $this->session->data['token'], true));
            } else {
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
            }
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_info_geral'] = $this->language->get('text_info_geral');
        $data['text_url_cron'] = $this->language->get('text_url_cron');

        $data['tab_geral'] = $this->language->get('tab_geral');

        $data['entry_url_cron'] = $this->language->get('entry_url_cron');
        $data['entry_chave_cron'] = $this->language->get('entry_chave_cron');
        $data['entry_notification'] = $this->language->get('entry_notification');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['help_url_cron'] = $this->language->get('help_url_cron');
        $data['help_chave_cron'] = $this->language->get('help_chave_cron');
        $data['help_notification'] = $this->language->get('help_notification');

        $data['button_save_stay'] = $this->language->get('button_save_stay');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['token'] = $this->session->data['token'];

        $erros = array(
            'warning',
            'chave_cron'
        );

        foreach ($erros as $erro) {
            if (isset($this->error[$erro])) {
                $data['error_'.$erro] = $this->error[$erro];
            } else {
                $data['error_'.$erro] = '';
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/cielo_api_cron', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/cielo_api_cron', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        $chave_cron = substr(sha1(time()), -30);

        $campos = array(
            'chave_cron' => $chave_cron,
            'notification' => '',
            'status' => ''
        );

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                if (isset($this->request->post['cielo_api_cron_'.$campo])) {
                    $data['cielo_api_cron_'.$campo] = $this->request->post['cielo_api_cron_'.$campo];
                } else if ($this->config->get('cielo_api_cron_'.$campo)) {
                    $data['cielo_api_cron_'.$campo] = $this->config->get('cielo_api_cron_'.$campo);
                } else {
                    $data['cielo_api_cron_'.$campo] = $valor;
                }
            } else {
                if (isset($this->request->post['cielo_api_cron_'.$campo])) {
                    $data['cielo_api_cron_'.$campo] = $this->request->post['cielo_api_cron_'.$campo];
                } else {
                    $data['cielo_api_cron_'.$campo] = $this->config->get('cielo_api_cron_'.$campo);
                }
            }
        }

        $data['url_cron'] = HTTPS_CATALOG . 'index.php?route=extension/module/cielo_api_cron&key='.$data['cielo_api_cron_chave_cron'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/cielo_api_cron', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/cielo_api_cron')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $campos = array(
            'chave_cron'
        );

        foreach ($campos as $campo) {
            if (!($this->request->post['cielo_api_cron_'.$campo])) {
                $this->error[$campo] = $this->language->get('error_'.$campo);
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }
}