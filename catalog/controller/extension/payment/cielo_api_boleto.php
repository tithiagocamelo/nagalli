<?php
class ControllerExtensionPaymentCieloAPIBoleto extends Controller {
    private $valorTotal = 0;

    public function index() {
        $this->load->language('extension/payment/cielo_api_boleto');

        $data['text_sandbox'] = $this->language->get('text_sandbox');
        $data['text_confirmando'] = $this->language->get('text_confirmando');
        $data['text_confirmado'] = $this->language->get('text_confirmado');

        $data['button_confirmar'] = $this->language->get('button_confirmar');

        $data['error_configuracao'] = $this->language->get('error_configuracao');

        $data['ambiente'] = $this->config->get('cielo_api_boleto_ambiente');

        $data['cor_normal_texto'] = $this->config->get('cielo_api_boleto_cor_normal_texto');
        $data['cor_normal_fundo'] = $this->config->get('cielo_api_boleto_cor_normal_fundo');
        $data['cor_normal_borda'] = $this->config->get('cielo_api_boleto_cor_normal_borda');
        $data['cor_efeito_texto'] = $this->config->get('cielo_api_boleto_cor_efeito_texto');
        $data['cor_efeito_fundo'] = $this->config->get('cielo_api_boleto_cor_efeito_fundo');
        $data['cor_efeito_borda'] = $this->config->get('cielo_api_boleto_cor_efeito_borda');

        $data['erros'] = '';
        if (!$this->config->get('cielo_api_boleto_one_checkout')) {
            $validacao = $this->getValidacao();
            $data['erros'] = (empty($validacao)) ? '' : sprintf($this->language->get('error_validacao'), $validacao);
        }

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        return $this->load->view('extension/payment/cielo_api_boleto', $data);
    }

    public function setTransacao() {
        $json = array();

        if (isset($this->session->data['order_id']) && $this->session->data['payment_method']['code'] == 'cielo_api_boleto') {
            $this->language->load('extension/payment/cielo_api_boleto');

            $validacao = $this->getValidacao();

            if (empty($validacao)) {
                $order_id = $this->session->data['order_id'];

                $this->load->model('checkout/order');
                $order_info = $this->model_checkout_order->getOrder($order_id);

                $total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
                $total = number_format($total, 2, '', '');

                $object_date = new DateTime($order_info['date_added']);
                $formatted_date = $object_date->format('Y-m-d');
                $split_date = explode("-", $formatted_date);
                $new_date = "86400" * $this->config->get('cielo_api_boleto_vencimento') + mktime(0,0,0,$split_date[1],$split_date[2],$split_date[0]);
                $vencimento = date("d/m/Y", $new_date);

                $Customer = '';
                $Identity = '';
                $Number = '';
                $Complement = '';

                $colunas = array();

                if ($this->config->get('cielo_api_boleto_custom_razao_id') == 'N') {
                    array_push($colunas, $this->config->get('cielo_api_boleto_razao_coluna'));
                }

                if ($this->config->get('cielo_api_boleto_custom_cnpj_id') == 'N') {
                    array_push($colunas, $this->config->get('cielo_api_boleto_cnpj_coluna'));
                }

                if ($this->config->get('cielo_api_boleto_custom_cpf_id') == 'N') {
                    array_push($colunas, $this->config->get('cielo_api_boleto_cpf_coluna'));
                }

                if ($this->config->get('cielo_api_boleto_custom_numero_id') == 'N') {
                    array_push($colunas, $this->config->get('cielo_api_boleto_numero_fatura_coluna'));
                }

                if ($this->config->get('cielo_api_boleto_custom_complemento_id') == 'N') {
                    array_push($colunas, $this->config->get('cielo_api_boleto_complemento_fatura_coluna'));
                }

                if (count($colunas)) {
                    $this->load->model('extension/payment/cielo_api_boleto');
                    $colunas_info = $this->model_extension_payment_cielo_api_boleto->getOrder($colunas, $order_id);
                }

                if ($this->config->get('cielo_api_boleto_custom_razao_id') == 'N') {
                    if (!empty($colunas_info[$this->config->get('cielo_api_boleto_razao_coluna')])) {
                        $Customer = $colunas_info[$this->config->get('cielo_api_boleto_razao_coluna')];
                    }
                } else {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('cielo_api_boleto_custom_razao_id') == $key) {
                            $Customer = $value;
                        }
                    }
                }

                if ($this->config->get('cielo_api_boleto_custom_cnpj_id') == 'N') {
                    if (!empty($colunas_info[$this->config->get('cielo_api_boleto_cnpj_coluna')])) {
                        $Identity = $colunas_info[$this->config->get('cielo_api_boleto_cnpj_coluna')];
                    }
                } else {
                    if (is_array($order_info['custom_field'])) {
                        foreach ($order_info['custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_boleto_custom_cnpj_id') == $key) {
                                $Identity = $value;
                            }
                        }
                    }
                }

                if (empty($Customer)) {
                    $Customer = $order_info['payment_firstname'].' '.$order_info['payment_lastname'];

                    if ($this->config->get('cielo_api_boleto_custom_cpf_id') == 'N') {
                        if (!empty($colunas_info[$this->config->get('cielo_api_boleto_cpf_coluna')])) {
                            $Identity = $colunas_info[$this->config->get('cielo_api_boleto_cpf_coluna')];
                        }
                    } else {
                        if (is_array($order_info['custom_field'])) {
                            foreach ($order_info['custom_field'] as $key => $value) {
                                if ($this->config->get('cielo_api_boleto_custom_cpf_id') == $key) {
                                    $Identity = $value;
                                }
                            }
                        }
                    }
                }

                if ($this->config->get('cielo_api_boleto_custom_numero_id') == 'N') {
                    $Number = $colunas_info[$this->config->get('cielo_api_boleto_numero_fatura_coluna')];
                } else {
                    if (is_array($order_info['payment_custom_field'])) {
                        foreach ($order_info['payment_custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_boleto_custom_numero_id') == $key) {
                                $Number = $value;
                            }
                        }
                    }
                }

                if ($this->config->get('cielo_api_boleto_custom_complemento_id') == 'N') {
                    $Complement = $colunas_info[$this->config->get('cielo_api_boleto_complemento_fatura_coluna')];
                } else {
                    if (is_array($order_info['payment_custom_field'])) {
                        foreach ($order_info['payment_custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_boleto_custom_complemento_id') == $key) {
                                $Complement = $value;
                            }
                        }
                    }
                }

                $dados['MerchantOrderId'] = $order_id;
                $dados['BoletoNumber'] = $order_id;

                $dados['Customer'] = $Customer;
                $dados['Identity'] = $Identity;

                $this->load->model('localisation/zone');
                $State = $this->model_localisation_zone->getZone($order_info['payment_zone_id']);

                $dados['Street'] = $order_info['payment_address_1'];
                $dados['Number'] = $Number;
                $dados['Complement'] = $Complement;
                $dados['ZipCode'] = $order_info['payment_postcode'];
                $dados['District'] = $order_info['payment_address_2'];
                $dados['City'] = $order_info['payment_city']; 
                $dados['State'] = $State['code'];

                $dados['Amount'] = $total;
                $dados['ExpirationDate'] = $vencimento;
                $dados['Provider'] = $this->config->get('cielo_api_boleto_banco');
                $dados['Demonstrative'] = $this->config->get('cielo_api_boleto_demonstrativo');
                $dados['Instructions'] = $this->config->get('cielo_api_boleto_instrucoes');

                $dados['Chave'] = $this->config->get('cielo_api_boleto_chave');
                $dados['Debug'] = $this->config->get('cielo_api_boleto_debug');
                $dados['Ambiente'] = $this->config->get('cielo_api_boleto_ambiente');
                $dados['MerchantId'] = $this->config->get('cielo_api_boleto_merchantid');
                $dados['MerchantKey'] = $this->config->get('cielo_api_boleto_merchantkey');

                require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
                require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
                $cielo = new Cielo();
                $cielo->setParametros($dados);
                $resposta = $cielo->setTransacaoBoleto();

                if ($resposta) {
                    if (isset($resposta->Payment->Url) && isset($resposta->Payment->ReturnCode) && $resposta->Payment->ReturnCode != '-400') {
                        $campos = array(
                            'order_id' => $order_id,
                            'paymentId' => $resposta->Payment->PaymentId,
                            'status' => $resposta->Payment->Status,
                            'tipo' => $resposta->Payment->Type,
                            'boletoData' => $resposta->Payment->ReceivedDate,
                            'boletoVencimento' => $resposta->Payment->ExpirationDate,
                            'boletoValor' => $resposta->Payment->Amount,
                            'json' => json_encode($resposta)
                        );

                        $this->load->model('extension/payment/cielo_api_boleto');
                        $this->model_extension_payment_cielo_api_boleto->addTransaction($campos);

                        $boleto_linha = $resposta->Payment->DigitableLine;
                        $boleto_url = $resposta->Payment->Url;
                        $boleto_vencimento = date('d/m/Y', strtotime($resposta->Payment->ExpirationDate));

                        $comment = $this->language->get('text_mensagem') . "\n\n";
                        $comment .= sprintf($this->language->get('text_segunda_via'), $boleto_linha, $boleto_url, $boleto_vencimento);

                        $this->load->model('checkout/order');
                        $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_boleto_situacao_gerado_id'), $comment, true);

                        if(isset($this->session->data['boleto_cielo_api_url'])) {
                            unset($this->session->data['boleto_cielo_api_url']);
                        }
                        $this->session->data['boleto_cielo_api_url'] = $boleto_url;

                        $json['redirect'] = $this->url->link('extension/payment/cielo_api_boleto/confirmado', '', true);
                    } else {
                        $json['error'] = $this->language->get('error_nao_gerou');
                    }
                } else {
                    $json['error'] = $this->language->get('error_nao_gerou');
                }
            } else {
                $json['error'] = sprintf($this->language->get('error_validacao'), $validacao);
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function confirmado() {
        if (isset($this->session->data['boleto_cielo_api_url'])) {
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

            $this->load->language('extension/payment/cielo_api_boleto');

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
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/payment/cielo_api_boleto/confirmado')
            );

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_mensagem'] = $this->language->get('text_instrucoes');

            $data['text_botao'] = $this->language->get('button_visualizar');

            $data['url'] = $this->session->data['boleto_cielo_api_url'];

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('extension/payment/cielo_api_confirmado', $data));
        } else {
            $this->response->redirect($this->url->link('error/not_found'));
        }
    }

    private function getValidacao() {
        $order_id = $this->session->data['order_id'];
        $colunas = array();
        $cliente = '';
        $documento = '';
        $payment_numero = '';
        $erros = '';

        if ($this->config->get('cielo_api_boleto_one_checkout')) {
            $order_data['custom_field'] = array();

            if ($this->customer->isLogged()) {
                $this->load->model('account/customer');
                $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

                $order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
            } else {
                $order_data['custom_field'] = $this->session->data['guest']['custom_field'];
            }

            $order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']['address']) ? $this->session->data['payment_address']['custom_field']['address'] : array());

            $this->load->model('extension/payment/cielo_api_boleto');
            $order_info = $this->model_extension_payment_cielo_api_boleto->editOrder($order_id, $order_data);
        }

        if ($this->config->get('cielo_api_boleto_custom_razao_id') == 'N') {
            array_push($colunas, $this->config->get('cielo_api_boleto_razao_coluna'));
        }

        if ($this->config->get('cielo_api_boleto_custom_cnpj_id') == 'N') {
            array_push($colunas, $this->config->get('cielo_api_boleto_cnpj_coluna'));
        }

        if ($this->config->get('cielo_api_boleto_custom_cpf_id') == 'N') {
            array_push($colunas, $this->config->get('cielo_api_boleto_cpf_coluna'));
        }

        if ($this->config->get('cielo_api_boleto_custom_numero_id') == 'N') {
            array_push($colunas, $this->config->get('cielo_api_boleto_numero_fatura_coluna'));
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);

        if (count($colunas)) {
            $this->load->model('extension/payment/cielo_api_boleto');
            $colunas_info = $this->model_extension_payment_cielo_api_boleto->getOrder($colunas, $order_id);
        }

        if ($this->config->get('cielo_api_boleto_custom_razao_id') == 'N') {
            if (!empty($colunas_info[$this->config->get('cielo_api_boleto_razao_coluna')])) {
                $cliente = $colunas_info[$this->config->get('cielo_api_boleto_razao_coluna')];
            }
        } else {
            if ($this->config->get('cielo_api_boleto_custom_razao_id')) {
                if (is_array($order_info['custom_field'])) {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('cielo_api_boleto_custom_razao_id') == $key) {
                            $cliente = $value;
                        }
                    }
                }
            }
        }

        if ($this->config->get('cielo_api_boleto_custom_cnpj_id') == 'N') {
            if (!empty($colunas_info[$this->config->get('cielo_api_boleto_cnpj_coluna')])) {
                $documento = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_boleto_cnpj_coluna')]);
            }
        } else {
            if ($this->config->get('cielo_api_boleto_custom_cnpj_id')) {
                if (is_array($order_info['custom_field'])) {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('cielo_api_boleto_custom_cnpj_id') == $key) {
                            $documento = preg_replace("/[^0-9]/", '', $value);
                        }
                    }
                }
            }
        }

        if (empty($cliente)) {
            $cliente = $order_info['payment_firstname'].' '.$order_info['payment_lastname'];

            if ($this->config->get('cielo_api_boleto_custom_cpf_id') == 'N') {
                if (!empty($colunas_info[$this->config->get('cielo_api_boleto_cpf_coluna')])) {
                    $documento = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_boleto_cpf_coluna')]);
                }
            } else {
                if ($this->config->get('cielo_api_boleto_custom_cpf_id')) {
                    if (is_array($order_info['custom_field'])) {
                        foreach ($order_info['custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_boleto_custom_cpf_id') == $key) {
                                $documento = preg_replace("/[^0-9]/", '', $value);
                            }
                        }
                    }
                }
            }
        }

        if ($this->config->get('cielo_api_boleto_custom_numero_id') == 'N') {
            $payment_numero = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_boleto_numero_fatura_coluna')]);
        } else {
            if (is_array($order_info['payment_custom_field'])) {
                foreach ($order_info['payment_custom_field'] as $key => $value) {
                    if ($this->config->get('cielo_api_boleto_custom_numero_id') == $key) {
                        $payment_numero = preg_replace("/[^0-9]/", '', $value);
                    }
                }
            }
        }

        $this->load->language('extension/payment/cielo_api_validacao');

        if (strlen($cliente) < 1) {
            $erros .= $this->language->get('error_cliente');
        }

        if (strlen($documento) == 11 || strlen($documento) == 14) {
        } else {
            $erros .= $this->language->get('error_documento');
        }

        $cep = preg_replace("/[^0-9]/", '', $order_info['payment_postcode']);
        if (strlen($cep) < 8) {
            $erros .= $this->language->get('error_payment_cep');
        }

        if (strlen($order_info['payment_address_1']) < 1) {
            $erros .= $this->language->get('error_payment_endereco');
        }

        if (strlen($payment_numero) < 1) {
            $erros .= $this->language->get('error_payment_numero');
        }

        if (strlen($order_info['payment_address_2']) < 1) {
            $erros .= $this->language->get('error_payment_bairro');
        }

        if (strlen($order_info['payment_city']) < 1) {
            $erros .= $this->language->get('error_payment_cidade');
        }

        $this->load->model('localisation/zone');
        $zone = $this->model_localisation_zone->getZone($order_info['payment_zone_id']);
        if (!isset($zone['code'])) {
            $erros .= $this->language->get('error_payment_estado');
        }

        if (empty($erros)) {
            return false;
        } else {
            return $erros;
        }
    }
}