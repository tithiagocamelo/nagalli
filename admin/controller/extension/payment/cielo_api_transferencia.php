<?php
class ControllerExtensionPaymentCieloApiTransferencia extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/cielo_api_transferencia');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cielo_api_transferencia', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/payment/cielo_api_transferencia', 'token=' . $this->session->data['token'], true));
            } else {
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
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
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_sandbox'] = $this->language->get('text_sandbox');
        $data['text_producao'] = $this->language->get('text_producao');
        $data['text_botao'] = $this->language->get('text_botao');
        $data['text_texto'] = $this->language->get('text_texto');
        $data['text_fundo'] = $this->language->get('text_fundo');
        $data['text_borda'] = $this->language->get('text_borda');

        $data['tab_geral'] = $this->language->get('tab_geral');
        $data['tab_api'] = $this->language->get('tab_api');
        $data['tab_situacoes'] = $this->language->get('tab_situacoes');
        $data['tab_finalizacao'] = $this->language->get('tab_finalizacao');

        $data['entry_chave'] = $this->language->get('entry_chave');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_merchantid'] = $this->language->get('entry_merchantid');
        $data['entry_merchantkey'] = $this->language->get('entry_merchantkey');
        $data['entry_ambiente'] = $this->language->get('entry_ambiente');
        $data['entry_debug'] = $this->language->get('entry_debug');
        $data['entry_banco'] = $this->language->get('entry_banco');
        $data['entry_situacao_gerada'] = $this->language->get('entry_situacao_gerada');
        $data['entry_situacao_pendente'] = $this->language->get('entry_situacao_pendente');
        $data['entry_situacao_paga'] = $this->language->get('entry_situacao_paga');
        $data['entry_situacao_negada'] = $this->language->get('entry_situacao_negada');
        $data['entry_situacao_cancelada'] = $this->language->get('entry_situacao_cancelada');
        $data['entry_titulo'] = $this->language->get('entry_titulo');
        $data['entry_imagem'] = $this->language->get('entry_imagem');
        $data['entry_botao_normal'] = $this->language->get('entry_botao_normal');
        $data['entry_botao_efeito'] = $this->language->get('entry_botao_efeito');

        $data['help_chave'] = $this->language->get('help_chave');
        $data['help_total'] = $this->language->get('help_total');
        $data['help_status'] = $this->language->get('help_status');
        $data['help_merchantid'] = $this->language->get('help_merchantid');
        $data['help_merchantkey'] = $this->language->get('help_merchantkey');
        $data['help_ambiente'] = $this->language->get('help_ambiente');
        $data['help_debug'] = $this->language->get('help_debug');
        $data['help_banco'] = $this->language->get('help_banco');
        $data['help_situacao_gerada'] = $this->language->get('help_situacao_gerada');
        $data['help_situacao_pendente'] = $this->language->get('help_situacao_pendente');
        $data['help_situacao_paga'] = $this->language->get('help_situacao_paga');
        $data['help_situacao_negada'] = $this->language->get('help_situacao_negada');
        $data['help_situacao_cancelada'] = $this->language->get('help_situacao_cancelada');
        $data['help_titulo'] = $this->language->get('help_titulo');
        $data['help_imagem'] = $this->language->get('help_imagem');
        $data['help_botao_normal'] = $this->language->get('help_botao_normal');
        $data['help_botao_efeito'] = $this->language->get('help_botao_efeito');

        $data['button_save_stay'] = $this->language->get('button_save_stay');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['token'] = $this->session->data['token'];

        $erros = array(
            'warning',
            'chave',
            'merchantid',
            'merchantkey',
            'titulo'
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
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/cielo_api_transferencia', 'token=' . $this->session->data['token'], true),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/payment/cielo_api_transferencia', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        $lib = DIR_SYSTEM . 'library/cielo_api/cielo.php';
        if (is_file($lib)) {
            if (!is_readable($lib)) {
                chmod($lib, 0644);
            }
        }

        $this->document->addStyle('view/javascript/jquery/cielo_api/colorpicker/css/bootstrap-colorpicker.min.css');
        $this->document->addScript('view/javascript/jquery/cielo_api/colorpicker/js/bootstrap-colorpicker.min.js');

        $campos = array(
            'chave' => '',
            'total' => '',
            'lojas' => array(0),
            'geo_zone_id' => '',
            'status' => '',
            'sort_order' => '',
            'merchantid' => '',
            'merchantkey' => '',
            'ambiente' => '',
            'debug' => '',
            'banco' => '',
            'situacao_gerada_id' => '',
            'situacao_pendente_id' => '',
            'situacao_paga_id' => '',
            'situacao_negada_id' => '',
            'situacao_cancelada_id' => '',
            'titulo' => 'Transferencia eletrônica',
            'imagem' => '',
            'cor_normal_texto' => '#FFFFFF',
            'cor_normal_fundo' => '#33b0f0',
            'cor_normal_borda' => '#33b0f0',
            'cor_efeito_texto' => '#FFFFFF',
            'cor_efeito_fundo' => '#0487b0',
            'cor_efeito_borda' => '#0487b0'
        );

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                if (isset($this->request->post['cielo_api_transferencia_'.$campo])) {
                    $data['cielo_api_transferencia_'.$campo] = $this->request->post['cielo_api_transferencia_'.$campo];
                } else if ($this->config->get('cielo_api_transferencia_'.$campo)) {
                    $data['cielo_api_transferencia_'.$campo] = $this->config->get('cielo_api_transferencia_'.$campo);
                } else {
                    $data['cielo_api_transferencia_'.$campo] = $valor;
                }
            } else {
                if (isset($this->request->post['cielo_api_transferencia_'.$campo])) {
                    $data['cielo_api_transferencia_'.$campo] = $this->request->post['cielo_api_transferencia_'.$campo];
                } else {
                    $data['cielo_api_transferencia_'.$campo] = $this->config->get('cielo_api_transferencia_'.$campo);
                }
            }
        }

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['bancos'] = array(
            'Bradesco' => $this->language->get('text_bradesco'),
            'BancodoBrasil' => $this->language->get('text_banco_brasil')
        );

        $this->load->model('tool/image');
        if (isset($this->request->post['cielo_api_transferencia_imagem']) && is_file(DIR_IMAGE . $this->request->post['cielo_api_transferencia_imagem'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['cielo_api_transferencia_imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get('cielo_api_transferencia_imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('cielo_api_transferencia_imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $this->update();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/cielo_api_transferencia', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/cielo_api_transferencia')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (strlen($this->request->post['cielo_api_transferencia_merchantid']) != 36) {
            $this->error['merchantid'] = $this->language->get('error_merchantid');
        }

        if (strlen($this->request->post['cielo_api_transferencia_merchantkey']) != 40) {
            $this->error['merchantkey'] = $this->language->get('error_merchantkey');
        }

        $erros = array(
            'chave',
            'titulo'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post['cielo_api_transferencia_'.$erro]))) {
                $this->error[$erro] = $this->language->get('error_'.$erro);
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/payment/cielo_api');
        $this->model_extension_payment_cielo_api->install_table();
    }

    public function uninstall() {
        $this->load->model('extension/payment/cielo_api');
        $this->model_extension_payment_cielo_api->uninstall_table();

        $this->load->model('user/user_group');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/cielo_api/list');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/cielo_api/list');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/cielo_api/log');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/cielo_api/log');
    }

    public function update() {
        $this->load->model('extension/payment/cielo_api');
        $this->model_extension_payment_cielo_api->update_table();

        $this->load->model('user/user_group');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/cielo_api/list');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/cielo_api/list');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/cielo_api/log');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/cielo_api/log');
    }
}