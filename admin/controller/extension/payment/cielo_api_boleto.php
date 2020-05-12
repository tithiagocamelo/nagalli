<?php
class ControllerExtensionPaymentCieloApiBoleto extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/cielo_api_boleto');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cielo_api_boleto', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/payment/cielo_api_boleto', 'token=' . $this->session->data['token'], true));
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
        $data['text_campo'] = $this->language->get('text_campo');
        $data['text_coluna'] = $this->language->get('text_coluna');
        $data['text_razao'] = $this->language->get('text_razao');
        $data['text_cnpj'] = $this->language->get('text_cnpj');
        $data['text_cpf'] = $this->language->get('text_cpf');
        $data['text_numero_fatura'] = $this->language->get('text_numero_fatura');
        $data['text_complemento_fatura'] = $this->language->get('text_complemento_fatura');

        $data['tab_geral'] = $this->language->get('tab_geral');
        $data['tab_api'] = $this->language->get('tab_api');
        $data['tab_situacoes'] = $this->language->get('tab_situacoes');
        $data['tab_campos'] = $this->language->get('tab_campos');
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
        $data['entry_vencimento'] = $this->language->get('entry_vencimento');
        $data['entry_demonstrativo'] = $this->language->get('entry_demonstrativo');
        $data['entry_instrucoes'] = $this->language->get('entry_instrucoes');
        $data['entry_situacao_gerado'] = $this->language->get('entry_situacao_gerado');
        $data['entry_situacao_pendente'] = $this->language->get('entry_situacao_pendente');
        $data['entry_situacao_pago'] = $this->language->get('entry_situacao_pago');
        $data['entry_situacao_cancelado'] = $this->language->get('entry_situacao_cancelado');
        $data['entry_custom_razao_id'] = $this->language->get('entry_custom_razao_id');
        $data['entry_custom_cnpj_id'] = $this->language->get('entry_custom_cnpj_id');
        $data['entry_custom_cpf_id'] = $this->language->get('entry_custom_cpf_id');
        $data['entry_custom_numero_id'] = $this->language->get('entry_custom_numero_id');
        $data['entry_custom_complemento_id'] = $this->language->get('entry_custom_complemento_id');
        $data['entry_titulo'] = $this->language->get('entry_titulo');
        $data['entry_imagem'] = $this->language->get('entry_imagem');
        $data['entry_one_checkout'] = $this->language->get('entry_one_checkout');
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
        $data['help_vencimento'] = $this->language->get('help_vencimento');
        $data['help_demonstrativo'] = $this->language->get('help_demonstrativo');
        $data['help_instrucoes'] = $this->language->get('help_instrucoes');
        $data['help_situacao_gerado'] = $this->language->get('help_situacao_gerado');
        $data['help_situacao_pendente'] = $this->language->get('help_situacao_pendente');
        $data['help_situacao_pago'] = $this->language->get('help_situacao_pago');
        $data['help_situacao_cancelado'] = $this->language->get('help_situacao_cancelado');
        $data['help_custom_razao_id'] = $this->language->get('help_custom_razao_id');
        $data['help_custom_cnpj_id'] = $this->language->get('help_custom_cnpj_id');
        $data['help_custom_cpf_id'] = $this->language->get('help_custom_cpf_id');
        $data['help_custom_numero_id'] = $this->language->get('help_custom_numero_id');
        $data['help_custom_complemento_id'] = $this->language->get('help_custom_complemento_id');
        $data['help_campo'] = $this->language->get('help_campo');
        $data['help_razao'] = $this->language->get('help_razao');
        $data['help_cnpj'] = $this->language->get('help_cnpj');
        $data['help_cpf'] = $this->language->get('help_cpf');
        $data['help_numero_fatura'] = $this->language->get('help_numero_fatura');
        $data['help_numero_entrega'] = $this->language->get('help_numero_entrega');
        $data['help_complemento_fatura'] = $this->language->get('help_complemento_fatura');
        $data['help_complemento_entrega'] = $this->language->get('help_complemento_entrega');
        $data['help_titulo'] = $this->language->get('help_titulo');
        $data['help_imagem'] = $this->language->get('help_imagem');
        $data['help_one_checkout'] = $this->language->get('help_one_checkout');
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
            'vencimento',
            'razao',
            'cnpj',
            'cpf',
            'numero_fatura',
            'complemento_fatura',
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
            'href' => $this->url->link('extension/payment/cielo_api_boleto', 'token=' . $this->session->data['token'], true),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/payment/cielo_api_boleto', 'token=' . $this->session->data['token'], true);

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
            'vencimento' => '',
            'demonstrativo' => '',
            'instrucoes' => '',
            'situacao_gerado_id' => '',
            'situacao_pendente_id' => '',
            'situacao_pago_id' => '',
            'situacao_cancelado_id' => '',
            'custom_razao_id' => '',
            'razao_coluna' => '',
            'custom_cnpj_id' => '',
            'cnpj_coluna' => '',
            'custom_cpf_id' => '',
            'cpf_coluna' => '',
            'custom_numero_id' => '',
            'numero_fatura_coluna' => '',
            'custom_complemento_id' => '',
            'complemento_fatura_coluna' => '',
            'titulo' => 'Boleto bancário',
            'imagem' => '',
            'one_checkout' => '',
            'cor_normal_texto' => '#FFFFFF',
            'cor_normal_fundo' => '#33b0f0',
            'cor_normal_borda' => '#33b0f0',
            'cor_efeito_texto' => '#FFFFFF',
            'cor_efeito_fundo' => '#0487b0',
            'cor_efeito_borda' => '#0487b0'
        );

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                if (isset($this->request->post['cielo_api_boleto_'.$campo])) {
                    $data['cielo_api_boleto_'.$campo] = $this->request->post['cielo_api_boleto_'.$campo];
                } else if ($this->config->get('cielo_api_boleto_'.$campo)) {
                    $data['cielo_api_boleto_'.$campo] = $this->config->get('cielo_api_boleto_'.$campo);
                } else {
                    $data['cielo_api_boleto_'.$campo] = $valor;
                }
            } else {
                if (isset($this->request->post['cielo_api_boleto_'.$campo])) {
                    $data['cielo_api_boleto_'.$campo] = $this->request->post['cielo_api_boleto_'.$campo];
                } else {
                    $data['cielo_api_boleto_'.$campo] = $this->config->get('cielo_api_boleto_'.$campo);
                }
            }
        }

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['bancos'] = array(
            'Bradesco2' => $this->language->get('text_bradesco'),
            'BancodoBrasil2' => $this->language->get('text_banco_brasil')
        );

        $data['custom_fields'] = array();
        $this->load->model('customer/custom_field');
        $custom_fields = $this->model_customer_custom_field->getCustomFields();
        foreach ($custom_fields as $custom_field) {
            $data['custom_fields'][] = array(
                'custom_field_id' => $custom_field['custom_field_id'],
                'name' => $custom_field['name'],
                'type' => $custom_field['type'],
                'location' => $custom_field['location']
            );
        }

        $this->load->model('extension/payment/cielo_api');
        $data['columns'] = $this->model_extension_payment_cielo_api->getOrderColumns();

        $this->load->model('tool/image');
        if (isset($this->request->post['cielo_api_boleto_imagem']) && is_file(DIR_IMAGE . $this->request->post['cielo_api_boleto_imagem'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['cielo_api_boleto_imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get('cielo_api_boleto_imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('cielo_api_boleto_imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $this->update();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/cielo_api_boleto', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/cielo_api_boleto')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (strlen($this->request->post['cielo_api_boleto_merchantid']) != 36) {
            $this->error['merchantid'] = $this->language->get('error_merchantid');
        }

        if (strlen($this->request->post['cielo_api_boleto_merchantkey']) != 40) {
            $this->error['merchantkey'] = $this->language->get('error_merchantkey');
        }

        $erros = array(
            'chave',
            'vencimento',
            'titulo'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post['cielo_api_boleto_'.$erro]))) {
                $this->error[$erro] = $this->language->get('error_'.$erro);
            }
        }

        $erros_campos = array(
            'razao',
            'cnpj',
            'cpf'
        );

        foreach ($erros_campos as $erro) {
            if ($this->request->post['cielo_api_boleto_custom_'.$erro.'_id'] == 'N') {
                if (!(trim($this->request->post['cielo_api_boleto_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros_campos_numero = array(
            'numero_fatura',
        );

        if ($this->request->post['cielo_api_boleto_custom_numero_id'] == 'N') {
            foreach ($erros_campos_numero as $erro) {
                if (!(trim($this->request->post['cielo_api_boleto_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros_campos_complemento = array(
            'complemento_fatura',
        );

        if ($this->request->post['cielo_api_boleto_custom_complemento_id'] == 'N') {
            foreach ($erros_campos_complemento as $erro) {
                if (!(trim($this->request->post['cielo_api_boleto_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
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