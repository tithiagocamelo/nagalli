<?php
class ControllerExtensionPaymentCieloApiCredito extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/cielo_api_credito');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cielo_api_credito', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/payment/cielo_api_credito', 'token=' . $this->session->data['token'], true));
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
        $data['text_image_manager'] = $this->language->get('text_image_manager');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_browse'] = $this->language->get('text_browse');
        $data['text_clear'] = $this->language->get('text_clear');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_manual'] = $this->language->get('text_manual');
        $data['text_automatica'] = $this->language->get('text_automatica');
        $data['text_simples'] = $this->language->get('text_simples');
        $data['text_composto'] = $this->language->get('text_composto');
        $data['text_ativar'] = $this->language->get('text_ativar');
        $data['text_parcelas'] = $this->language->get('text_parcelas');
        $data['text_sem_juros'] = $this->language->get('text_sem_juros');
        $data['text_juros'] = $this->language->get('text_juros');
        $data['text_botao'] = $this->language->get('text_botao');
        $data['text_texto'] = $this->language->get('text_texto');
        $data['text_fundo'] = $this->language->get('text_fundo');
        $data['text_borda'] = $this->language->get('text_borda');
        $data['text_recaptcha'] = $this->language->get('text_recaptcha');
        $data['text_recaptcha_registrar'] = $this->language->get('text_recaptcha_registrar');
        $data['text_sandbox'] = $this->language->get('text_sandbox');
        $data['text_homologacao'] = $this->language->get('text_homologacao');
        $data['text_producao'] = $this->language->get('text_producao');
        $data['text_campo'] = $this->language->get('text_campo');
        $data['text_coluna'] = $this->language->get('text_coluna');
        $data['text_razao'] = $this->language->get('text_razao');
        $data['text_cnpj'] = $this->language->get('text_cnpj');
        $data['text_cpf'] = $this->language->get('text_cpf');
        $data['text_numero_fatura'] = $this->language->get('text_numero_fatura');
        $data['text_numero_entrega'] = $this->language->get('text_numero_entrega');
        $data['text_complemento_fatura'] = $this->language->get('text_complemento_fatura');
        $data['text_complemento_entrega'] = $this->language->get('text_complemento_entrega');

        $data['tab_geral'] = $this->language->get('tab_geral');
        $data['tab_api'] = $this->language->get('tab_api');
        $data['tab_parcelamentos'] = $this->language->get('tab_parcelamentos');
        $data['tab_situacoes_pedido'] = $this->language->get('tab_situacoes_pedido');
        $data['tab_finalizacao'] = $this->language->get('tab_finalizacao');
        $data['tab_campos'] = $this->language->get('tab_campos');
        $data['tab_antifraude'] = $this->language->get('tab_antifraude');
        $data['tab_clearsale'] = $this->language->get('tab_clearsale');
        $data['tab_fcontrol'] = $this->language->get('tab_fcontrol');

        $data['entry_chave'] = $this->language->get('entry_chave');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_merchantid'] = $this->language->get('entry_merchantid');
        $data['entry_merchantkey'] = $this->language->get('entry_merchantkey');
        $data['entry_soft_descriptor'] = $this->language->get('entry_soft_descriptor');
        $data['entry_ambiente'] = $this->language->get('entry_ambiente');
        $data['entry_debug'] = $this->language->get('entry_debug');
        $data['entry_captura'] = $this->language->get('entry_captura');
        $data['entry_calculo'] = $this->language->get('entry_calculo');
        $data['entry_minimo'] = $this->language->get('entry_minimo');
        $data['entry_desconto'] = $this->language->get('entry_desconto');
        $data['entry_visa'] = $this->language->get('entry_visa');
        $data['entry_mastercard'] = $this->language->get('entry_mastercard');
        $data['entry_diners'] = $this->language->get('entry_diners');
        $data['entry_discover'] = $this->language->get('entry_discover');
        $data['entry_elo'] = $this->language->get('entry_elo');
        $data['entry_amex'] = $this->language->get('entry_amex');
        $data['entry_hipercard'] = $this->language->get('entry_hipercard');
        $data['entry_jcb'] = $this->language->get('entry_jcb');
        $data['entry_aura'] = $this->language->get('entry_aura');
        $data['entry_situacao_pendente'] = $this->language->get('entry_situacao_pendente');
        $data['entry_situacao_autorizada'] = $this->language->get('entry_situacao_autorizada');
        $data['entry_situacao_nao_autorizada'] = $this->language->get('entry_situacao_nao_autorizada');
        $data['entry_situacao_capturada'] = $this->language->get('entry_situacao_capturada');
        $data['entry_situacao_cancelada'] = $this->language->get('entry_situacao_cancelada');
        $data['entry_titulo'] = $this->language->get('entry_titulo');
        $data['entry_imagem'] = $this->language->get('entry_imagem');
        $data['entry_exibir_juros'] = $this->language->get('entry_exibir_juros');
        $data['entry_botao_normal'] = $this->language->get('entry_botao_normal');
        $data['entry_botao_efeito'] = $this->language->get('entry_botao_efeito');
        $data['entry_recaptcha_site_key'] = $this->language->get('entry_recaptcha_site_key');
        $data['entry_recaptcha_secret_key'] = $this->language->get('entry_recaptcha_secret_key');
        $data['entry_recaptcha_status'] = $this->language->get('entry_recaptcha_status');
        $data['entry_custom_razao_id'] = $this->language->get('entry_custom_razao_id');
        $data['entry_custom_cnpj_id'] = $this->language->get('entry_custom_cnpj_id');
        $data['entry_custom_cpf_id'] = $this->language->get('entry_custom_cpf_id');
        $data['entry_custom_numero_id'] = $this->language->get('entry_custom_numero_id');
        $data['entry_custom_complemento_id'] = $this->language->get('entry_custom_complemento_id');
        $data['entry_antifraude_returnsaccepted'] = $this->language->get('entry_antifraude_returnsaccepted');
        $data['entry_antifraude_giftcategory'] = $this->language->get('entry_antifraude_giftcategory');
        $data['entry_antifraude_hosthedge'] = $this->language->get('entry_antifraude_hosthedge');
        $data['entry_antifraude_nonsensicalhedge'] = $this->language->get('entry_antifraude_nonsensicalhedge');
        $data['entry_antifraude_obscenitieshedge'] = $this->language->get('entry_antifraude_obscenitieshedge');
        $data['entry_antifraude_risk'] = $this->language->get('entry_antifraude_risk');
        $data['entry_antifraude_timehedge'] = $this->language->get('entry_antifraude_timehedge');
        $data['entry_antifraude_type'] = $this->language->get('entry_antifraude_type');
        $data['entry_antifraude_velocityhedge'] = $this->language->get('entry_antifraude_velocityhedge');
        $data['entry_clearsale_codigo'] = $this->language->get('entry_clearsale_codigo');
        $data['entry_clearsale_ambiente'] = $this->language->get('entry_clearsale_ambiente');
        $data['entry_fcontrol_login'] = $this->language->get('entry_fcontrol_login');
        $data['entry_fcontrol_senha'] = $this->language->get('entry_fcontrol_senha');

        $data['help_chave'] = $this->language->get('help_chave');
        $data['help_total'] = $this->language->get('help_total');
        $data['help_merchantid'] = $this->language->get('help_merchantid');
        $data['help_merchantkey'] = $this->language->get('help_merchantkey');
        $data['help_soft_descriptor'] = $this->language->get('help_soft_descriptor');
        $data['help_antifraude'] = $this->language->get('help_antifraude');
        $data['help_ambiente'] = $this->language->get('help_ambiente');
        $data['help_debug'] = $this->language->get('help_debug');
        $data['help_captura'] = $this->language->get('help_captura');
        $data['help_calculo'] = $this->language->get('help_calculo');
        $data['help_minimo'] = $this->language->get('help_minimo');
        $data['help_desconto'] = $this->language->get('help_desconto');
        $data['help_visa'] = $this->language->get('help_visa');
        $data['help_mastercard'] = $this->language->get('help_mastercard');
        $data['help_diners'] = $this->language->get('help_diners');
        $data['help_discover'] = $this->language->get('help_discover');
        $data['help_elo'] = $this->language->get('help_elo');
        $data['help_amex'] = $this->language->get('help_amex');
        $data['help_hipercard'] = $this->language->get('help_hipercard');
        $data['help_jcb'] = $this->language->get('help_jcb');
        $data['help_aura'] = $this->language->get('help_aura');
        $data['help_situacao_pendente'] = $this->language->get('help_situacao_pendente');
        $data['help_situacao_autorizada'] = $this->language->get('help_situacao_autorizada');
        $data['help_situacao_nao_autorizada'] = $this->language->get('help_situacao_nao_autorizada');
        $data['help_situacao_capturada'] = $this->language->get('help_situacao_capturada');
        $data['help_situacao_cancelada'] = $this->language->get('help_situacao_cancelada');
        $data['help_titulo'] = $this->language->get('help_titulo');
        $data['help_imagem'] = $this->language->get('help_imagem');
        $data['help_exibir_juros'] = $this->language->get('help_exibir_juros');
        $data['help_botao_normal'] = $this->language->get('help_botao_normal');
        $data['help_botao_efeito'] = $this->language->get('help_botao_efeito');
        $data['help_recaptcha_site_key'] = $this->language->get('help_recaptcha_site_key');
        $data['help_recaptcha_secret_key'] = $this->language->get('help_recaptcha_secret_key');
        $data['help_recaptcha_status'] = $this->language->get('help_recaptcha_status');
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
        $data['help_clearsale_codigo'] = $this->language->get('help_clearsale_codigo');
        $data['help_fcontrol_login'] = $this->language->get('help_fcontrol_login');
        $data['help_fcontrol_senha'] = $this->language->get('help_fcontrol_senha');

        $data['button_save_stay'] = $this->language->get('button_save_stay');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['token'] = $this->session->data['token'];

        $erros = array(
            'warning',
            'chave',
            'merchantid',
            'merchantkey',
            'soft_descriptor',
            'visa',
            'mastercard',
            'diners',
            'elo',
            'amex',
            'hipercard',
            'jcb',
            'aura',
            'titulo',
            'recaptcha_site_key',
            'recaptcha_secret_key',
            'razao',
            'cnpj',
            'cpf',
            'numero_fatura',
            'numero_entrega',
            'complemento_fatura',
            'complemento_entrega',
            'clearsale_codigo',
            'fcontrol_login',
            'fcontrol_senha'
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
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/cielo_api_credito', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/cielo_api_credito', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        $library = DIR_SYSTEM . 'library/cielo_api/cielo.php';
        if (is_file($library)) {
            if (!is_readable($library)) {
                chmod($library, 0644);
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
            'soft_descriptor' => '',
            'ambiente' => '',
            'debug' => '',
            'captura' => '',
            'calculo' => '',
            'minimo' => '',
            'desconto' => '',
            'visa' => '',
            'visa_parcelas' => '',
            'visa_sem_juros' => '',
            'visa_juros' => '',
            'mastercard' => '',
            'mastercard_parcelas' => '',
            'mastercard_sem_juros' => '',
            'mastercard_juros' => '',
            'diners' => '',
            'diners_parcelas' => '',
            'diners_sem_juros' => '',
            'diners_juros' => '',
            'discover' => '',
            'elo' => '',
            'elo_parcelas' => '',
            'elo_sem_juros' => '',
            'elo_juros' => '',
            'amex' => '',
            'amex_parcelas' => '',
            'amex_sem_juros' => '',
            'amex_juros' => '',
            'hipercard' => '',
            'hipercard_parcelas' => '',
            'hipercard_sem_juros' => '',
            'hipercard_juros' => '',
            'jcb' => '',
            'jcb_parcelas' => '',
            'jcb_sem_juros' => '',
            'jcb_juros' => '',
            'aura' => '',
            'aura_parcelas' => '',
            'aura_sem_juros' => '',
            'aura_juros' => '',
            'situacao_pendente_id' => '',
            'situacao_autorizada_id' => '',
            'situacao_nao_autorizada_id' => '',
            'situacao_capturada_id' => '',
            'situacao_cancelada_id' => '',
            'titulo' => '',
            'imagem' => '',
            'exibir_juros' => '',
            'cor_normal_texto' => '#FFFFFF',
            'cor_normal_fundo' => '#33b0f0',
            'cor_normal_borda' => '#33b0f0',
            'cor_efeito_texto' => '#FFFFFF',
            'cor_efeito_fundo' => '#0487b0',
            'cor_efeito_borda' => '#0487b0',
            'recaptcha_site_key' => '',
            'recaptcha_secret_key' => '',
            'recaptcha_status' => '',
            'custom_razao_id' => '',
            'razao_coluna' => '',
            'custom_cnpj_id' => '',
            'cnpj_coluna' => '',
            'custom_cpf_id' => '',
            'cpf_coluna' => '',
            'custom_numero_id' => '',
            'numero_fatura_coluna' => '',
            'numero_entrega_coluna' => '',
            'custom_complemento_id' => '',
            'complemento_fatura_coluna' => '',
            'complemento_entrega_coluna' => '',
            'antifraude_returnsaccepted' => '',
            'antifraude_giftcategory' => '',
            'antifraude_hosthedge' => '',
            'antifraude_nonsensicalhedge' => '',
            'antifraude_obscenitieshedge' => '',
            'antifraude_risk' => '',
            'antifraude_timehedge' => '',
            'antifraude_type' => '',
            'antifraude_velocityhedge' => '',
            'antifraude_status' => '',
            'clearsale_codigo' => '',
            'clearsale_ambiente' => '',
            'clearsale_status' => '',
            'fcontrol_login' => '',
            'fcontrol_senha' => '',
            'fcontrol_status' => ''
        );

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                if (isset($this->request->post['cielo_api_credito_'.$campo])) {
                    $data['cielo_api_credito_'.$campo] = $this->request->post['cielo_api_credito_'.$campo];
                } else if ($this->config->get('cielo_api_credito_'.$campo)) {
                    $data['cielo_api_credito_'.$campo] = $this->config->get('cielo_api_credito_'.$campo);
                } else {
                    $data['cielo_api_credito_'.$campo] = $valor;
                }
            } else {
                if (isset($this->request->post['cielo_api_credito_'.$campo])) {
                    $data['cielo_api_credito_'.$campo] = $this->request->post['cielo_api_credito_'.$campo];
                } else {
                    $data['cielo_api_credito_'.$campo] = $this->config->get('cielo_api_credito_'.$campo);
                }
            }
        }

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        for ($i = 1; $i <= 12; $i++) {
            $data['parcelas'][] = $i;
        }

        $this->load->model('tool/image');
        if (isset($this->request->post['cielo_api_credito_imagem']) && is_file(DIR_IMAGE . $this->request->post['cielo_api_credito_imagem'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['cielo_api_credito_imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get('cielo_api_credito_imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('cielo_api_credito_imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

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

        $data['giftcategory'] = array(
            'Yes' => $this->language->get('text_giftcategory_yes'),
            'No' => $this->language->get('text_giftcategory_no'),
            'Off' => $this->language->get('text_giftcategory_off')
        );

        $data['hosthedge'] = array(
            'Low' => $this->language->get('text_hosthedge_low'),
            'Normal' => $this->language->get('text_hosthedge_normal'),
            'High' => $this->language->get('text_hosthedge_high'),
            'Off' => $this->language->get('text_hosthedge_off')
        );

        $data['nonsensicalhedge'] = array(
            'Low' => $this->language->get('text_nonsensicalhedge_low'),
            'Normal' => $this->language->get('text_nonsensicalhedge_normal'),
            'High' => $this->language->get('text_nonsensicalhedge_high'),
            'Off' => $this->language->get('text_nonsensicalhedge_off')
        );

        $data['obscenitieshedge'] = array(
            'Low' => $this->language->get('text_obscenitieshedge_low'),
            'Normal' => $this->language->get('text_obscenitieshedge_normal'),
            'High' => $this->language->get('text_obscenitieshedge_high'),
            'Off' => $this->language->get('text_obscenitieshedge_off')
        );

        $data['risk'] = array(
            'Low' => $this->language->get('text_risk_low'),
            'Normal' => $this->language->get('text_risk_normal'),
            'High' => $this->language->get('text_risk_high')
        );

        $data['timehedge'] = array(
            'Low' => $this->language->get('text_timehedge_low'),
            'Normal' => $this->language->get('text_timehedge_normal'),
            'High' => $this->language->get('text_timehedge_high'),
            'Off' => $this->language->get('text_timehedge_off')
        );

        $data['type'] = array(
            'Default' => $this->language->get('text_type_default'),
            'AdultContent' => $this->language->get('text_type_adult_content'),
            'Coupon' => $this->language->get('text_type_coupon'),
            'EletronicGood' => $this->language->get('text_type_eletronic_good'),
            'EletronicSoftware' => $this->language->get('text_type_eletronic_software'),
            'GiftCertificate' => $this->language->get('text_type_gift_certificate'),
            'HandlingOnly' => $this->language->get('text_type_handling_only'),
            'Service' => $this->language->get('text_type_service'),
            'ShippingAndHandling' => $this->language->get('text_type_shipping_and_handling'),
            'ShippingOnly' => $this->language->get('text_type_shipping_only'),
            'Subscription' => $this->language->get('text_type_subscription'),
        );

        $data['velocityhedge'] = array(
            'Low' => $this->language->get('text_velocityhedge_low'),
            'Normal' => $this->language->get('text_velocityhedge_normal'),
            'High' => $this->language->get('text_velocityhedge_high'),
            'Off' => $this->language->get('text_velocityhedge_off')
        );

        $this->update();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/cielo_api_credito', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/cielo_api_credito')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $erros = array(
            'chave',
            'titulo'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post['cielo_api_credito_'.$erro]))) {
                $this->error[$erro] = $this->language->get('error_'.$erro);
            }
        }

        if (strlen($this->request->post['cielo_api_credito_merchantid']) != 36) {
            $this->error['merchantid'] = $this->language->get('error_merchantid');
        }

        if (strlen($this->request->post['cielo_api_credito_merchantkey']) != 40) {
            $this->error['merchantkey'] = $this->language->get('error_merchantkey');
        }

        if (strlen($this->request->post['cielo_api_credito_soft_descriptor']) <= 13) {
            if (!preg_match('/^[A-Z0-9]+$/', $this->request->post['cielo_api_credito_soft_descriptor'])) {
                $this->error['soft_descriptor'] = $this->language->get('error_soft_descriptor');
            }
        } else {
            $this->error['soft_descriptor'] = $this->language->get('error_soft_descriptor');
        }

        $erros_parcelamento = array(
            'visa',
            'mastercard',
            'diners',
            'elo',
            'amex',
            'hipercard',
            'jcb',
            'aura'
        );

        foreach ($erros_parcelamento as $erro) {
            if ($this->request->post['cielo_api_credito_'.$erro]) {
                if ($this->request->post['cielo_api_credito_'.$erro.'_parcelas'] > $this->request->post['cielo_api_credito_'.$erro.'_sem_juros']) {
                    if (!(trim($this->request->post['cielo_api_credito_'.$erro.'_juros']))) {
                        $this->error[$erro] = $this->language->get('error_parcelamento_juros');
                    }
                }
            }
        }

        if ($this->request->post['cielo_api_credito_recaptcha_status']) {
            if (!$this->request->post['cielo_api_credito_recaptcha_site_key']) {
                $this->error['recaptcha_site_key'] = $this->language->get('error_recaptcha_site_key');
            }
            if (!$this->request->post['cielo_api_credito_recaptcha_secret_key']) {
                $this->error['recaptcha_secret_key'] = $this->language->get('error_recaptcha_secret_key');
            }
        }

        $erros_campos = array(
            'razao',
            'cnpj',
            'cpf'
        );

        foreach ($erros_campos as $erro) {
            if ($this->request->post['cielo_api_credito_custom_'.$erro.'_id'] == 'N') {
                if (!(trim($this->request->post['cielo_api_credito_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros_campos_numero = array(
            'numero_fatura',
            'numero_entrega'
        );

        if ($this->request->post['cielo_api_credito_custom_numero_id'] == 'N') {
            foreach ($erros_campos_numero as $erro) {
                if (!(trim($this->request->post['cielo_api_credito_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros_campos_complemento = array(
            'complemento_fatura',
            'complemento_entrega'
        );

        if ($this->request->post['cielo_api_credito_custom_complemento_id'] == 'N') {
            foreach ($erros_campos_complemento as $erro) {
                if (!(trim($this->request->post['cielo_api_credito_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        if ($this->request->post['cielo_api_credito_clearsale_status']) {
            if (!$this->request->post['cielo_api_credito_clearsale_codigo']) {
                $this->error['clearsale_codigo'] = $this->language->get('error_clearsale_codigo');
            }
        }

        if ($this->request->post['cielo_api_credito_fcontrol_status']) {
            if (!$this->request->post['cielo_api_credito_fcontrol_login']) {
                $this->error['fcontrol_login'] = $this->language->get('error_fcontrol_login');
            }

            if (!$this->request->post['cielo_api_credito_fcontrol_senha']) {
                $this->error['fcontrol_senha'] = $this->language->get('error_fcontrol_senha');
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