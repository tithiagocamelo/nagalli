<?php
class ControllerExtensionPaymentCieloApiCredito extends Controller {
    private $valorTotal = 0;

    public function index() {
        $this->load->language('extension/payment/cielo_api_credito');

        $data['text_sandbox'] = $this->language->get('text_sandbox');
        $data['text_detalhes'] = $this->language->get('text_detalhes');
        $data['text_ate'] = $this->language->get('text_ate');
        $data['text_de'] = $this->language->get('text_de');
        $data['text_total'] = $this->language->get('text_total');
        $data['text_sem_juros'] = $this->language->get('text_sem_juros');
        $data['text_com_juros'] = $this->language->get('text_com_juros');
        $data['text_juros'] = $this->language->get('text_juros');
        $data['text_mes'] = $this->language->get('text_mes');
        $data['text_ano'] = $this->language->get('text_ano');
        $data['text_carregando'] = $this->language->get('text_carregando');
        $data['text_autorizando'] = $this->language->get('text_autorizando');
        $data['text_autorizou'] = $this->language->get('text_autorizou');

        $data['button_pagar'] = $this->language->get('button_pagar');

        $data['entry_bandeira'] = $this->language->get('entry_bandeira');
        $data['entry_cartao'] = $this->language->get('entry_cartao');
        $data['entry_titular'] = $this->language->get('entry_titular');
        $data['entry_parcelas'] = $this->language->get('entry_parcelas');
        $data['entry_validade_mes'] = $this->language->get('entry_validade_mes');
        $data['entry_validade_ano'] = $this->language->get('entry_validade_ano');
        $data['entry_codigo'] = $this->language->get('entry_codigo');
        $data['entry_captcha'] = $this->language->get('entry_captcha');

        $data['error_parcelas'] = $this->language->get('error_parcelas');
        $data['error_cartao'] = $this->language->get('error_cartao');
        $data['error_titular'] = $this->language->get('error_titular');
        $data['error_mes'] = $this->language->get('error_mes');
        $data['error_ano'] = $this->language->get('error_ano');
        $data['error_codigo'] = $this->language->get('error_codigo');

        $data['error_bandeiras'] = $this->language->get('error_bandeiras');
        $data['error_configuracao'] = $this->language->get('error_configuracao');

        $data['ambiente'] = $this->config->get('cielo_api_credito_ambiente');

        $data['exibir_juros'] = $this->config->get('cielo_api_credito_exibir_juros');

        $data['cor_normal_texto'] = $this->config->get('cielo_api_credito_cor_normal_texto');
        $data['cor_normal_fundo'] = $this->config->get('cielo_api_credito_cor_normal_fundo');
        $data['cor_normal_borda'] = $this->config->get('cielo_api_credito_cor_normal_borda');
        $data['cor_efeito_texto'] = $this->config->get('cielo_api_credito_cor_efeito_texto');
        $data['cor_efeito_fundo'] = $this->config->get('cielo_api_credito_cor_efeito_fundo');
        $data['cor_efeito_borda'] = $this->config->get('cielo_api_credito_cor_efeito_borda');

        $data['bandeiras'] = array();
        foreach ($this->getBandeiras() as $bandeira => $parcelamento) {
            ($this->config->get('cielo_api_credito_' . $bandeira)) ? array_push($data['bandeiras'], $bandeira) : '';
        }

        $meses = array();
        for ($i = 1; $i <= 12; $i++) {
            $meses[] = array(
                'text' => sprintf('%02d', $i),
                'value' => sprintf('%02d', $i)
            );
        }
        $data['meses'] = json_encode($meses);

        $anos = array();
        $hoje = getdate();
        for ($i = $hoje['year']; $i < $hoje['year'] + 12; $i++) {
            $anos[] = array(
                'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
            );
        }
        $data['anos'] = json_encode($anos);

        $data['captcha'] = $this->config->get('cielo_api_credito_recaptcha_status');
        if ($data['captcha']) {
            $data['site_key'] = $this->config->get('cielo_api_credito_recaptcha_site_key');
        }

        if (isset($this->session->data['attempts'])) { unset($this->session->data['attempts']); }
        $this->session->data['attempts'] = 3;

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        return $this->load->view('extension/payment/cielo_api_credito', $data);
    }

    public function bandeiras() {
        $json = array();

        if (isset($this->session->data['order_id']) && isset($this->session->data['attempts']) && $this->session->data['payment_method']['code'] == 'cielo_api_credito') {
            foreach ($this->getBandeiras() as $bandeira => $parcelas) {
                ($this->config->get('cielo_api_credito_' . $bandeira)) ? $json[] = array('bandeira' => $bandeira, 'titulo' => strtoupper($bandeira), 'imagem' => HTTPS_SERVER .'image/catalog/cielo_api/'. $bandeira .'.png', 'parcelas' => $parcelas) : '';
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function parcelas() {
        $json = array();

        if (isset($this->session->data['order_id']) && isset($this->session->data['attempts']) && isset($this->request->get['bandeira']) && $this->session->data['payment_method']['code'] == 'cielo_api_credito') {
            $valorMinimo = ($this->config->get('cielo_api_credito_minimo') > 0) ? $this->config->get('cielo_api_credito_minimo') : '0';

            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

            $this->valorTotal = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

            $total = $this->valorTotal;
            $desconto = ($this->config->get('cielo_api_credito_desconto')) ? (float)$this->config->get('cielo_api_credito_desconto') : 0;

            $bandeira = $this->request->get['bandeira'];

            $currency_code = $this->session->data['currency'];

            if ((strtolower($bandeira) != 'discover') && (strtoupper($currency_code) == 'BRL')) {
                $parcelas = $this->config->get('cielo_api_credito_'. strtolower($bandeira) .'_parcelas');
                $sem_juros = $this->config->get('cielo_api_credito_'. strtolower($bandeira) .'_sem_juros');
                $juros = $this->config->get('cielo_api_credito_'. strtolower($bandeira) .'_juros');

                for ($i = 1; $i <= $parcelas; $i++) {
                    if ($i <= $sem_juros) {
                        if ($i == 1) {
                            if ($desconto > 0) {
                                $this->load->model('extension/payment/cielo_api_credito');
                                $shipping = $this->model_extension_payment_cielo_api_credito->getOrderShippingValue($this->session->data['order_id']);

                                $shipping = $this->currency->format($shipping, $order_info['currency_code'], $order_info['currency_value'], false);
                                $subtotal = $total-$shipping;
                                $desconto = ($subtotal*$desconto)/100;
                                $valorParcela = ($subtotal-$desconto)+$shipping;
                                $desconto = $this->currency->format($desconto, $order_info['currency_code'], '1.00', true);
                            } else {
                                $valorParcela = $total;
                            }

                            $json[] = array(
                                'parcela' => 1,
                                'desconto' => $desconto,
                                'valor' => $this->currency->format($valorParcela, $order_info['currency_code'], '1.00', true),
                                'juros' => 0,
                                'total' => $this->currency->format($valorParcela, $order_info['currency_code'], '1.00', true)
                            );
                        } else {
                            $valorParcela = ($total/$i);
                            if ($valorParcela >= $valorMinimo) {
                                $json[] = array(
                                    'parcela' => $i,
                                    'desconto' => 0,
                                    'valor' => $this->currency->format($valorParcela, $order_info['currency_code'], '1.00', true),
                                    'juros' => 0,
                                    'total' => $this->currency->format($total, $order_info['currency_code'], '1.00', true)
                                );
                            }
                        }
                    } else {
                        $total = $this->getParcelar($bandeira, $i);
                        if ($total['valorParcela'] >= $valorMinimo) {
                            $json[] = array(
                                'parcela' => $i,
                                'desconto' => 0,
                                'valor' => $this->currency->format($total['valorParcela'], $order_info['currency_code'], '1.00', true),
                                'juros' => $juros,
                                'total' => $this->currency->format($total['valorTotal'], $order_info['currency_code'], '1.00', true)
                            );
                        }
                    }
                }
            } else {
                if ($desconto > 0) {
                    $this->load->model('extension/payment/cielo_api_credito');
                    $shipping = $this->model_extension_payment_cielo_api_credito->getOrderShippingValue($this->session->data['order_id']);

                    $shipping = $this->currency->format($shipping, $order_info['currency_code'], $order_info['currency_value'], false);
                    $total = $total-$shipping;
                    $desconto = ($total*$desconto)/100;
                    $valorParcela = ($total-$desconto)+$shipping;
                    $desconto = $this->currency->format($desconto, $order_info['currency_code'], '1.00', true);
                } else {
                    $valorParcela = $total;
                }

                $json[] = array(
                    'parcela' => 1,
                    'desconto' => $desconto,
                    'valor' => $this->currency->format($valorParcela, $order_info['currency_code'], '1.00', true),
                    'juros' => 0,
                    'total' => $this->currency->format($valorParcela, $order_info['currency_code'], '1.00', true)
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function comprovante() {
        if (isset($this->session->data['comprovante'])) {
            if (isset($this->session->data['order_id'])) {
                $this->cart->clear();

                $this->load->model('account/activity');

                if ($this->customer->isLogged()) {
                    $activity_data = array(
                        'customer_id' => $this->customer->getId(),
                        'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                        'order_id' => $this->session->data['order_id']
                    );

                    $this->model_account_activity->addActivity('order_account', $activity_data);
                } else {
                    $activity_data = array(
                        'name' => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
                        'order_id' => $this->session->data['order_id']
                    );

                    $this->model_account_activity->addActivity('order_guest', $activity_data);
                }

                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
                unset($this->session->data['guest']);
                unset($this->session->data['comment']);
                unset($this->session->data['order_id']);
                unset($this->session->data['coupon']);
                unset($this->session->data['reward']);
                unset($this->session->data['voucher']);
                unset($this->session->data['vouchers']);
                unset($this->session->data['totals']);
            }

            $this->load->language('extension/payment/cielo_api_comprovante');

            $this->document->setTitle($this->language->get('heading_title'));

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home')
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_basket'),
                'href' => $this->url->link('checkout/cart')
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_checkout'),
                'href' => $this->url->link('checkout/checkout', '', true)
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_success'),
                'href' => $this->url->link('extension/payment/cielo_api_credito/comprovante')
            );

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_importante'] = $this->language->get('text_importante');
            $data['text_comprovante'] =  $this->session->data['comprovante'];

            $data['button_imprimir'] = $this->language->get('button_imprimir');
            $data['button_historico'] = $this->language->get('button_historico');

            $data['imprimir'] = $this->url->link('extension/payment/cielo_api_credito/imprimir');
            $data['historico'] = $this->url->link('account/order');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('extension/payment/cielo_api_comprovante', $data));
        } else {
            $this->response->redirect($this->url->link('error/not_found'));
        }
    }

    public function imprimir() {
        if (isset($this->session->data['comprovante'])) {
            $this->load->language('extension/payment/cielo_api_imprimir');

            $this->document->setTitle($this->config->get('config_name') . ' - ' . $this->language->get('text_title'));

            if ($this->request->server['HTTPS']) {
                $server = $this->config->get('config_ssl');
            } else {
                $server = $this->config->get('config_url');
            }

            if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
                $this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
            }

            $data['title'] = $this->document->getTitle();

            $data['links'] = $this->document->getLinks();
            $data['lang'] = $this->language->get('code');
            $data['direction'] = $this->language->get('direction');
            $data['name'] = $this->config->get('config_name');

            $data['text_title'] = $this->language->get('text_title');
            $data['text_comprovante'] = $this->session->data['comprovante'];

            $this->response->setOutput($this->load->view('extension/payment/cielo_api_imprimir', $data));
        } else {
            $this->response->redirect($this->url->link('error/not_found'));
        }
    }

    private function getBandeiras() {
        $bandeiras = array(
            "visa" => $this->config->get('cielo_api_credito_visa_parcelas'),
            "mastercard" => $this->config->get('cielo_api_credito_mastercard_parcelas'),
            "diners" => $this->config->get('cielo_api_credito_diners_parcelas'),
            "discover" => '1',
            "elo" => $this->config->get('cielo_api_credito_elo_parcelas'),
            "amex" => $this->config->get('cielo_api_credito_amex_parcelas'),
            "hipercard" => $this->config->get('cielo_api_credito_hipercard_parcelas'),
            "jcb" => $this->config->get('cielo_api_credito_jcb_parcelas'),
            "aura" => $this->config->get('cielo_api_credito_aura_parcelas')
        );

        return $bandeiras;
    }

    private function getParcelar($bandeira, $parcelas) {
        $currency_code = $this->session->data['currency'];

        if ((strtolower($bandeira) != 'discover') && (strtoupper($currency_code == 'BRL'))) {
            $parcelar = $this->config->get('cielo_api_credito_'. strtolower($bandeira) .'_parcelas');
            $juros = $this->config->get('cielo_api_credito_'. strtolower($bandeira) .'_juros')/100;
            $calculo  = $this->config->get('cielo_api_credito_calculo');

            if ($parcelas > $parcelar) {
                $parcelas = $parcelar;
            }

            if ($calculo) {
                $valorParcela = ($this->valorTotal*$juros)/(1-(1/pow(1+$juros, $parcelas)));
            } else {
                $valorParcela = ($this->valorTotal*pow(1+$juros, $parcelas))/$parcelas;
            }

            $valorParcela = round($valorParcela, 2);
            $valorTotal = $parcelas * $valorParcela;
        } else {
            $valorParcela = $this->valorTotal;
            $valorTotal = $this->valorTotal;
        }

        return array(
            'valorParcela' => $valorParcela,
            'valorTotal' => $valorTotal
        );
    }

    public function setTransacao() {
        $json = array();

        $this->language->load('extension/payment/cielo_api_credito');

        if (isset($this->session->data['order_id']) && isset($this->session->data['attempts']) && $this->setValidarPost() && $this->session->data['payment_method']['code'] == 'cielo_api_credito') {
            if ($this->setValidarCaptcha()) {
                if (($this->session->data['attempts'] > 0) && ($this->session->data['attempts'] <= 3)) {
                    $bandeiraCartao = trim($this->request->post['bandeira']);
                    $parcelasCartao = preg_replace("/[^0-9]/", '', $this->request->post['parcelas']);
                    $titularCartao = trim($this->request->post['titular']);
                    $numeroCartao = preg_replace("/[^0-9]/", '', $this->request->post['cartao']);
                    $mesCartao = preg_replace("/[^0-9]/", '', $this->request->post['mes']);
                    $anoCartao = preg_replace("/[^0-9]/", '', $this->request->post['ano']);
                    $codigoCartao = preg_replace("/[^0-9]/", '', $this->request->post['codigo']);

                    $campos = array($bandeiraCartao, $parcelasCartao, $titularCartao, $numeroCartao, $mesCartao, $anoCartao, $codigoCartao);
                    $bandeiras = $this->getBandeiras();

                    if ($this->setValidarCampos($campos) && array_key_exists(strtolower($bandeiraCartao), $bandeiras) && ($parcelasCartao <= '12')) {
                        $this->session->data['attempts']--;

                        $order_id = $this->session->data['order_id'];
                        $this->load->model('checkout/order');
                        $order_info = $this->model_checkout_order->getOrder($order_id);

                        $this->load->model('extension/payment/cielo_api_credito');

                        $Customer = $order_info['firstname'].' '.$order_info['lastname'];

                        $antifraude = $this->config->get('cielo_api_credito_antifraude_status');
                        if ($antifraude) {
                            $order_shipping = $this->model_extension_payment_cielo_api_credito->getOrderShipping($order_id);   

                            $Identity = '';
                            $PaymentNumber = '';
                            $PaymentComplement = '';
                            $ShippingNumber = '';
                            $ShippingComplement = '';

                            $colunas = array();
                            if ($this->config->get('cielo_api_credito_custom_razao_id') == 'N') {
                                array_push($colunas, $this->config->get('cielo_api_credito_razao_coluna'));
                            }

                            if ($this->config->get('cielo_api_credito_custom_cnpj_id') == 'N') {
                                array_push($colunas, $this->config->get('cielo_api_credito_cnpj_coluna'));
                            }
                
                            if ($this->config->get('cielo_api_credito_custom_cpf_id') == 'N') {
                                array_push($colunas, $this->config->get('cielo_api_credito_cpf_coluna'));
                            }

                            if ($this->config->get('cielo_api_credito_custom_numero_id') == 'N') {
                                array_push($colunas, $this->config->get('cielo_api_credito_numero_fatura_coluna'));
                            }

                            if ($this->config->get('cielo_api_credito_custom_complemento_id') == 'N') {
                                array_push($colunas, $this->config->get('cielo_api_credito_complemento_fatura_coluna'));
                            }

                            if ($order_shipping) {
                                if ($this->config->get('cielo_api_credito_custom_numero_id') == 'N') {
                                    array_push($colunas, $this->config->get('cielo_api_credito_numero_entrega_coluna'));
                                }

                                if ($this->config->get('cielo_api_credito_custom_complemento_id') == 'N') {
                                    array_push($colunas, $this->config->get('cielo_api_credito_complemento_entrega_coluna'));
                                }
                            }

                            $colunas_info = array();
                            if (count($colunas)) {
                                $colunas_info = $this->model_extension_payment_cielo_api_credito->getOrder($colunas, $order_id);
                            }

                            /** INICIO::pegar customer pelo OC */
                            if ($this->customer->isLogged()) {
                                
                                $_customer_id = $this->customer->getId();

                                $this->load->model('account/customer');
                                $customer_dados = $this->model_account_customer->getCustomer($_customer_id);

                                if(isset($customer_dados['custom_field'])) {
                                    $order_info['custom_field'] = json_decode($customer_dados['custom_field'], true);
                                    
                                    // $order_info['custom_field'] = !is_array($order_info['custom_field']) ? $order_info['custom_field'] : json_decode($order_info['custom_field']);
                                }

                            }

                            /** FIM::pegar customer pelo OC */

                            if ($this->config->get('cielo_api_credito_custom_razao_id') == 'N') {
                                if (isset($colunas_info[$this->config->get('cielo_api_credito_razao_coluna')])) {
                                    $Customer = $colunas_info[$this->config->get('cielo_api_credito_razao_coluna')];
                                }
                            } else {
                                if (is_array($order_info['custom_field'])) {
                                    foreach ($order_info['custom_field'] as $key => $value) {
                                        if ((int)$this->config->get('cielo_api_credito_custom_razao_id') == (int)$key) {
                                            $Customer = $value;
                                        }
                                    }
                                }
                            }

                            if ($this->config->get('cielo_api_credito_custom_cnpj_id') == 'N') {
                                if (!empty($colunas_info[$this->config->get('cielo_api_credito_cnpj_coluna')])) {
                                    $Identity = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_credito_cnpj_coluna')]);
                                }
                            } else {
                                if (is_array($order_info['custom_field'])) {
                                    foreach ($order_info['custom_field'] as $key => $value) {
                                        if ((int)$this->config->get('cielo_api_credito_custom_cnpj_id') == (int)$key) {
                                            $Identity = preg_replace("/[^0-9]/", '', $value);
                                        }
                                    }
                                }
                            }

                            if (empty($Customer)) {
                                $Customer = $order_info['firstname'].' '.$order_info['lastname'];
                            }

                            

                            if (empty($Identity)) {
                                if ($this->config->get('cielo_api_credito_custom_cpf_id') == 'N') {
                                    if (!empty($colunas_info[$this->config->get('cielo_api_credito_cpf_coluna')])) {
                                        $Identity = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_credito_cpf_coluna')]);
                                    }
                                } else {
                                    if (is_array($order_info['custom_field'])) {
                                        foreach ($order_info['custom_field'] as $key => $value) {
                                            if ((int)$this->config->get('cielo_api_credito_custom_cpf_id') == (int)$key) {
                                                $Identity = preg_replace("/[^0-9]/", '', $value);
                                            }
                                        }
                                    }
                                }
                            }

                            if ($this->config->get('cielo_api_credito_custom_numero_id') == 'N') {
                                if (isset($colunas_info[$this->config->get('cielo_api_credito_numero_fatura_coluna')])) {
                                    $PaymentNumber = $colunas_info[$this->config->get('cielo_api_credito_numero_fatura_coluna')];
                                }
                            } else {
                                if (is_array($order_info['payment_custom_field'])) {
                                    foreach ($order_info['payment_custom_field'] as $key => $value) {
                                        if ((int)$this->config->get('cielo_api_credito_custom_numero_id') == (int)$key) {
                                            $PaymentNumber = $value;
                                        }
                                    }
                                }
                            }

                            if ($this->config->get('cielo_api_credito_custom_complemento_id') == 'N') {
                                if (isset($colunas_info[$this->config->get('cielo_api_credito_complemento_fatura_coluna')])) {
                                    $PaymentComplement = $colunas_info[$this->config->get('cielo_api_credito_complemento_fatura_coluna')];
                                }
                            } else {
                                if (is_array($order_info['payment_custom_field'])) {
                                    foreach ($order_info['payment_custom_field'] as $key => $value) {
                                        if ((int)$this->config->get('cielo_api_credito_custom_complemento_id') == (int)$key) {
                                            $PaymentComplement = $value;
                                        }
                                    }
                                }
                            }

                            if ($order_shipping) {
                                if ($this->config->get('cielo_api_credito_custom_numero_id') == 'N') {
                                    if (isset($colunas_info[$this->config->get('cielo_api_credito_numero_entrega_coluna')])) {
                                        $ShippingNumber = $colunas_info[$this->config->get('cielo_api_credito_numero_entrega_coluna')];
                                    }
                                } else {
                                    if (is_array($order_info['shipping_custom_field'])) {
                                        foreach ($order_info['shipping_custom_field'] as $key => $value) {
                                            if ((int)$this->config->get('cielo_api_credito_custom_numero_id') == (int)$key) {
                                                $ShippingNumber = $value;
                                            }
                                        }
                                    }
                                }

                                if ($this->config->get('cielo_api_credito_custom_complemento_id') == 'N') {
                                    if (isset($colunas_info[$this->config->get('cielo_api_credito_complemento_entrega_coluna')])) {
                                        $ShippingComplement = $colunas_info[$this->config->get('cielo_api_credito_complemento_entrega_coluna')];
                                    }
                                } else {
                                    if (is_array($order_info['shipping_custom_field'])) {
                                        foreach ($order_info['shipping_custom_field'] as $key => $value) {
                                            if ((int)$this->config->get('cielo_api_credito_custom_complemento_id') == (int)$key) {
                                                $ShippingComplement = $value;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $this->valorTotal = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
                        $desconto = ($this->config->get('cielo_api_credito_desconto')) ? (float)$this->config->get('cielo_api_credito_desconto') : 0;
                        if ($parcelasCartao <= '1') {
                            if ($desconto > 0) {
                                $shipping = $this->model_extension_payment_cielo_api_credito->getOrderShippingValue($this->session->data['order_id']);

                                $shipping = $this->currency->format($shipping, $order_info['currency_code'], $order_info['currency_value'], false);
                                $total = $this->valorTotal;
                                $total = $total-$shipping;
                                $desconto = ($total*$desconto)/100;
                                $total = ($total-$desconto)+$shipping;
                            } else {
                                $total = $this->valorTotal;
                            }
                        } else {
                            $sem_juros = $this->config->get('cielo_api_credito_'. strtolower($bandeiraCartao) .'_sem_juros');
                            if ($parcelasCartao <= $sem_juros) {
                                $total = $this->valorTotal;
                            } else {
                                $resultado = $this->getParcelar($bandeiraCartao, $parcelasCartao);
                                $total = $resultado['valorTotal'];
                            }
                        }
                        $total = number_format($total, 2, '', '');

                        $bandeirasCielo = array(
                            'visa' => 'Visa',
                            'mastercard' => 'Master',
                            'diners' => 'Diners',
                            'discover' => 'Discover',
                            'elo' => 'Elo',
                            'amex' => 'Amex',
                            'hipercard' => 'Hipercard',
                            'jcb' => 'Jcb',
                            'aura' => 'Aura',
                        );

                        $dados['MerchantOrderId'] = $order_id;
                        $dados['Customer'] = $Customer;

                        if ($antifraude) {
                            $dados['Identity'] = $Identity;
                            $dados['Email'] = $order_info['email'];

                            $dados['PaymentStreet'] = $order_info['payment_address_1'];
                            $dados['PaymentNumber'] = $PaymentNumber;
                            $dados['PaymentComplement'] = $PaymentComplement;
                            $dados['PaymentZipcode'] = $order_info['payment_postcode'];
                            $dados['PaymentCity'] = $order_info['payment_city'];
                            $dados['PaymentState'] = $order_info['payment_zone_code'];

                            if ($order_shipping) {
                                $dados['ShippingStreet'] = $order_info['shipping_address_1'];
                                $dados['ShippingNumber'] = $ShippingNumber;
                                $dados['ShippingComplement'] = $ShippingComplement;
                                $dados['ShippingZipcode'] = $order_info['shipping_postcode'];
                                $dados['ShippingCity'] = $order_info['shipping_city'];
                                $dados['ShippingState'] = $order_info['shipping_zone_code'];

                                if ($order_info['shipping_code'] == 'pickup.pickup') {
                                    $dados['ShippingMethod'] = 'Pickup';
                                } else {
                                    $dados['ShippingMethod'] = 'Other';
                                }
                            } else {
                                $dados['ShippingStreet'] = $order_info['payment_address_1'];
                                $dados['ShippingNumber'] = $PaymentNumber;
                                $dados['ShippingComplement'] = $PaymentComplement;
                                $dados['ShippingZipcode'] = $order_info['payment_postcode'];
                                $dados['ShippingCity'] = $order_info['payment_city'];
                                $dados['ShippingState'] = $order_info['payment_zone_code'];

                                $dados['ShippingMethod'] = 'Other';
                            }

                            $GiftCategory = $this->config->get('cielo_api_credito_antifraude_giftcategory');
                            $HostHedge = $this->config->get('cielo_api_credito_antifraude_hosthedge');
                            $NonSensicalHedge = $this->config->get('cielo_api_credito_antifraude_nonsensicalhedge');
                            $ObscenitiesHedge = $this->config->get('cielo_api_credito_antifraude_obscenitieshedge');
                            $Risk = $this->config->get('cielo_api_credito_antifraude_risk');
                            $TimeHedge = $this->config->get('cielo_api_credito_antifraude_timehedge');
                            $Type = $this->config->get('cielo_api_credito_antifraude_type');
                            $VelocityHedge = $this->config->get('cielo_api_credito_antifraude_velocityhedge');

                            $order_products = $this->model_extension_payment_cielo_api_credito->getOrderProducts($order_id);

                            $dados['Items'] = array();
                            foreach ($order_products as $product) {
                                $dados['Items'][] = array(
                                    'GiftCategory' => $GiftCategory,
                                    'HostHedge' => $HostHedge,
                                    'NonSensicalHedge' => $NonSensicalHedge,
                                    'ObscenitiesHedge' => $ObscenitiesHedge,
                                    'Name' => $product['name'],
                                    'UnitPrice' => number_format(($product['price'] + $product['tax']) * $order_info['currency_value'], 2, '', ''),
                                    'Quantity' => $product['quantity'],
                                    'Sku' => $product['sku'],
                                    'Risk' => $Risk,
                                    'TimeHedge' => $TimeHedge,
                                    'Type' => $Type,
                                    'VelocityHedge' => $VelocityHedge
                                );
                            }

                            if (!empty($this->session->data['vouchers'])) {
                                foreach ($this->session->data['vouchers'] as $voucher) {
                                    $dados['Items'][] = array(
                                        'Name' => $voucher['description'],
                                        'UnitPrice' => number_format($voucher['amount'] * $order_info['currency_value'], 2, '', ''),
                                        'Quantity' => '1',
                                        'Sku' => 'VALE PRESENTES'
                                    );
                                }
                            }

                            $dados['ReturnsAccepted'] = ($this->config->get('cielo_api_credito_antifraude_returnsaccepted')) ? 'true' : 'false';
                        }

                        $dados['Amount'] = $total;
                        $dados['Installments'] = $parcelasCartao;
                        $dados['Capture'] = ($this->config->get('cielo_api_credito_captura')) ? 'true' : 'false';
                        $dados['SoftDescriptor'] = $this->config->get('cielo_api_credito_soft_descriptor');

                        $dados['CardNumber'] = $numeroCartao;
                        $dados['Holder'] = $titularCartao;
                        $dados['ExpirationDate'] = $mesCartao . '/' . $anoCartao;
                        $dados['SecurityCode'] = $codigoCartao;
                        $dados['Brand'] = $bandeirasCielo[$bandeiraCartao];

                        $dados['Chave'] = $this->config->get('cielo_api_credito_chave');
                        $dados['Debug'] = $this->config->get('cielo_api_credito_debug');
                        $dados['Ambiente'] = $this->config->get('cielo_api_credito_ambiente');
                        $dados['Antifraude'] = $antifraude;
                        $dados['MerchantId'] = $this->config->get('cielo_api_credito_merchantid');
                        $dados['MerchantKey'] = $this->config->get('cielo_api_credito_merchantkey');

                        require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
                        require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
                        $cielo = new Cielo();
                        $cielo->setParametros($dados);
                        
                        // var_dump($dados); exit;
                        
                        $resposta = $cielo->setTransacaoCredito();

                        if ($resposta) {
                            if (!empty($resposta->Payment)) {
                                $transacaoStatus = $resposta->Payment->Status;
                                $transacaoPaymentId = $resposta->Payment->PaymentId;
                                $transacaoTipo = $resposta->Payment->Type;
                                $transacaoParcelas = $resposta->Payment->Installments;
                                $transacaoBandeira = $resposta->Payment->CreditCard->Brand;
                                $transacaoValor = $this->currency->format(($resposta->Payment->Amount / 100), $order_info['currency_code'], '1.00', true);

                                if (isset($resposta->Payment->FraudAnalysis)) {
                                    if ($resposta->Payment->FraudAnalysis->StatusDescription == 'Aborted') {
                                        $transacaoAntifraude = 0;
                                    } else {
                                        $transacaoAntifraude = 1;
                                    }
                                } else {
                                    $transacaoAntifraude = 0;
                                }

                                if (!empty($transacaoStatus)) {
                                    if ($transacaoStatus != '13') {
                                        $transacaoData = date('d/m/Y H:i', strtotime($resposta->Payment->ReceivedDate));
                                        $transacaoTid = $resposta->Payment->Tid;
                                    }

                                    switch ($transacaoStatus) {
                                        case '0':
                                            $campos = array(
                                                'order_id' => $order_id,
                                                'paymentId' => $transacaoPaymentId,
                                                'status' => $transacaoStatus,
                                                'tipo' => $transacaoTipo,
                                                'antifraude' => $transacaoAntifraude,
                                                'parcelas' => $transacaoParcelas,
                                                'bandeira' => $transacaoBandeira,
                                                'json' => json_encode($resposta)
                                            );

                                            $this->model_extension_payment_cielo_api_credito->addTransaction($campos);

                                            $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                            $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                            $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_credito') . "\n";
                                            $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                            $comment .= $this->language->get('entry_parcelas') . $transacaoParcelas . 'x ' . $this->language->get('text_total') . $transacaoValor . "\n";
                                            $comment .= $this->language->get('entry_status') . $this->language->get('text_aguardando');

                                            $this->load->model('checkout/order');
                                            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_pendente_id'), $comment, true);

                                            if (isset($this->session->data['comprovante'])) { unset($this->session->data['comprovante']); }
                                            $this->session->data['comprovante'] = $comment;

                                            $json['redirect'] = $this->url->link('extension/payment/cielo_api_credito/comprovante', '', true);
                                            break;
                                        case '1':
                                            $campos = array(
                                                'order_id' => $order_id,
                                                'paymentId' => $transacaoPaymentId,
                                                'status' => $transacaoStatus,
                                                'tipo' => $transacaoTipo,
                                                'antifraude' => $transacaoAntifraude,
                                                'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                                'tid' => $transacaoTid,
                                                'authorizationCode' => $resposta->Payment->AuthorizationCode,
                                                'parcelas' => $transacaoParcelas,
                                                'bandeira' => $transacaoBandeira,
                                                'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                                'autorizacaoValor' => $resposta->Payment->Amount,
                                                'json' => json_encode($resposta)
                                            );

                                            $this->model_extension_payment_cielo_api_credito->addTransaction($campos);

                                            if ($this->config->get('cielo_api_credito_clearsale_status')) {
                                                $status = $this->language->get('text_em_analise');
                                            } else if ($this->config->get('cielo_api_credito_fcontrol_status')) {
                                                $status = $this->language->get('text_em_analise');
                                            } else {
                                                $status = $this->language->get('text_autorizado');
                                            }

                                            $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                            $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                            $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                            $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_credito') . "\n";
                                            $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                            $comment .= $this->language->get('entry_parcelas') . $transacaoParcelas . 'x ' . $this->language->get('text_total') . $transacaoValor . "\n";
                                            $comment .= $this->language->get('entry_status') . $status;

                                            $this->load->model('checkout/order');
                                            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_autorizada_id'), $comment, true);

                                            if (isset($this->session->data['comprovante'])) { unset($this->session->data['comprovante']); }
                                            $this->session->data['comprovante'] = $comment;

                                            $json['redirect'] = $this->url->link('extension/payment/cielo_api_credito/comprovante', '', true);
                                            break;
                                        case '2':
                                            $campos = array(
                                                'order_id' => $order_id,
                                                'paymentId' => $transacaoPaymentId,
                                                'status' => $transacaoStatus,
                                                'tipo' => $transacaoTipo,
                                                'antifraude' => $transacaoAntifraude,
                                                'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                                'tid' => $transacaoTid,
                                                'authorizationCode' => $resposta->Payment->AuthorizationCode,
                                                'parcelas' => $transacaoParcelas,
                                                'bandeira' => $transacaoBandeira,
                                                'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                                'autorizacaoValor' => $resposta->Payment->Amount,
                                                'capturaData' => $resposta->Payment->CapturedDate,
                                                'capturaValor' => $resposta->Payment->CapturedAmount,
                                                'json' => json_encode($resposta)
                                            );

                                            $this->model_extension_payment_cielo_api_credito->addTransaction($campos);

                                            $transacaoData = date('d/m/Y H:i', strtotime($resposta->Payment->CapturedDate));
                                            $transacaoValor = $this->currency->format(($resposta->Payment->CapturedAmount / 100), $order_info['currency_code'], '1.00', true);

                                            $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                            $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                            $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                            $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_credito') . "\n";
                                            $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                            $comment .= $this->language->get('entry_parcelas') . $transacaoParcelas . 'x ' . $this->language->get('text_total') . $transacaoValor . "\n";
                                            $comment .= $this->language->get('entry_status') . $this->language->get('text_capturado');

                                            $this->load->model('checkout/order');
                                            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_capturada_id'), $comment, true);

                                            if (isset($this->session->data['comprovante'])) { unset($this->session->data['comprovante']); }
                                            $this->session->data['comprovante'] = $comment;

                                            $json['redirect'] = $this->url->link('extension/payment/cielo_api_credito/comprovante', '', true);
                                            break;
                                        case '12':
                                            $campos = array(
                                                'order_id' => $order_id,
                                                'paymentId' => $transacaoPaymentId,
                                                'status' => $transacaoStatus,
                                                'tipo' => $transacaoTipo,
                                                'antifraude' => $transacaoAntifraude,
                                                'tid' => $transacaoTid,
                                                'parcelas' => $transacaoParcelas,
                                                'bandeira' => $transacaoBandeira,
                                                'json' => json_encode($resposta)
                                            );

                                            $this->model_extension_payment_cielo_api_credito->addTransaction($campos);

                                            $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                            $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                            $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                            $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_credito') . "\n";
                                            $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                            $comment .= $this->language->get('entry_parcelas') . $transacaoParcelas . 'x ' . $this->language->get('text_total') . $transacaoValor . "\n";
                                            $comment .= $this->language->get('entry_status') . $this->language->get('text_pendente');

                                            $this->load->model('checkout/order');
                                            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_pendente_id'), $comment, true);

                                            if (isset($this->session->data['comprovante'])) { unset($this->session->data['comprovante']); }
                                            $this->session->data['comprovante'] = $comment;

                                            $json['redirect'] = $this->url->link('extension/payment/cielo_api_credito/comprovante', '', true);
                                            break;
                                        case '13':
                                            $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                            $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_credito') . "\n";
                                            $comment .= $this->language->get('entry_parcelas') . $transacaoParcelas . 'x ' . $this->language->get('text_total') . $transacaoValor . "\n";

                                            if (($antifraude) && isset($resposta->Payment->FraudAnalysis)) {
                                                $antifraudeStatus = (isset($resposta->Payment->FraudAnalysis->StatusDescription)) ? $resposta->Payment->FraudAnalysis->StatusDescription : $resposta->Payment->FraudAnalysis->Status;

                                                switch ($antifraudeStatus) {
                                                    case 'Started':
                                                    case 'Pendent':
                                                        $comment .= $this->language->get('entry_status') . $this->language->get('text_em_analise');
                                                        break;
                                                    case 'Review':
                                                        $comment .= $this->language->get('entry_status') . $this->language->get('text_em_revisao');
                                                        break;
                                                    case 'Reject':
                                                        $comment .= $this->language->get('entry_status') . $this->language->get('text_reprovado');
                                                        break;
                                                    default:
                                                        $comment .= $this->language->get('entry_status') . $this->language->get('text_nao_autorizado');
                                                        break;
                                                }

                                                if ($antifraudeStatus == 'Started' || $antifraudeStatus == 'Pendent' || $antifraudeStatus == 'Review') {
                                                    $campos = array(
                                                        'order_id' => $order_id,
                                                        'paymentId' => $transacaoPaymentId,
                                                        'status' => $transacaoStatus,
                                                        'tipo' => (empty($transacaoTipo)) ? 'CreditCard' : $transacaoTipo,
                                                        'antifraude' => $transacaoAntifraude,
                                                        'parcelas' => $transacaoParcelas,
                                                        'json' => json_encode($resposta)
                                                    );

                                                    $this->model_extension_payment_cielo_api_credito->addTransaction($campos);

                                                    $this->load->model('checkout/order');
                                                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_pendente_id'), $comment, true);

                                                    if (isset($this->session->data['comprovante'])) { unset($this->session->data['comprovante']); }
                                                    $this->session->data['comprovante'] = $comment;

                                                    $json['redirect'] = $this->url->link('extension/payment/cielo_api_credito/comprovante', '', true);
                                                } else {
                                                    $this->load->model('checkout/order');
                                                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_nao_autorizada_id'), $comment, true);

                                                    $json['error'] = $this->language->get('error_autorizacao');
                                                }
                                            } else {
                                                $comment .= $this->language->get('entry_status') . $this->language->get('text_nao_autorizado');

                                                $this->load->model('checkout/order');
                                                $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_nao_autorizada_id'), $comment, true);

                                                $json['error'] = $this->language->get('error_autorizacao');
                                            }
                                            break;
                                        default:
                                            $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                            $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                            $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                            $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_credito') . "\n";
                                            $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                            $comment .= $this->language->get('entry_parcelas') . $transacaoParcelas . 'x ' . $this->language->get('text_total') . $transacaoValor . "\n";
                                            $comment .= $this->language->get('entry_status') . $this->language->get('text_nao_autorizado');

                                            $this->load->model('checkout/order');
                                            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_credito_situacao_nao_autorizada_id'), $comment, true);

                                            $json['error'] = $this->language->get('error_autorizacao');
                                            break;
                                    }
                                } else {
                                    $json['error'] = $this->language->get('error_status');
                                }
                            } else {
                                $json['error'] = $this->language->get('error_json');
                            }
                        } else {
                            $json['error'] = $this->language->get('error_configuracao');
                        }
                    } else {
                        $json['error'] = $this->language->get('error_preenchimento');
                    }
                } else {
                    if ($this->session->data['attempts'] == 0) {
                        $this->session->data['attempts']--;

                        $this->load->model('checkout/order');
                        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_credito_situacao_nao_autorizada_id'), $this->language->get('text_tentativas'), true);
                    }

                    unset($this->session->data['payment_method']);

                    $json['error'] = $this->language->get('error_tentativas');
                }
            } else {
                if (($this->session->data['attempts'] < 0) || ($this->session->data['attempts'] > 3)) {
                    $json['error'] = $this->language->get('error_tentativas');
                } else {
                    $json['error'] = $this->language->get('error_captcha');
                }
            }
        } else {
            $json['error'] = $this->language->get('error_permissao');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function setValidarPost() {
        $campos = array('bandeira', 'parcelas', 'titular', 'cartao', 'mes', 'ano', 'codigo');

        $erros = 0;
        foreach ($campos as $campo) {
            if (!isset($this->request->post[$campo])) {
                $erros++;
                break;
            }
        }

        if ($erros == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function setValidarCampos($campos) {
        $erros = 0;

        foreach ($campos as $campo) {
            if (empty($campo)) {
                $erros++;
                break;
            }
        }

        if ($erros == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function setValidarCaptcha() {
        if (!$this->config->get('cielo_api_credito_recaptcha_status')) {
            return true;
        }

        if (!isset($this->session->data['attempts'])) {
            return false;
        }

        if (($this->session->data['attempts'] < 0) || ($this->session->data['attempts'] > 3)) {
            return false;
        }

        if (!isset($this->request->post['g-recaptcha-response'])) {
            return false;
        }

        if (empty($this->request->post['g-recaptcha-response'])) {
            return false;
        }

        $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('cielo_api_credito_recaptcha_secret_key')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);
        $recaptcha = json_decode($recaptcha, true);

        if ($recaptcha['success']) {
            return true;
        } else {
            return false;
        }
    }
}