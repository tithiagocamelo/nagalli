<?php
class ControllerExtensionCieloApiList extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/cielo_api/list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addStyle('//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css');
        $this->document->addStyle('view/javascript/bootstrap/css/bootstrap-glyphicons.css');
        $this->document->addScript('//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js');
        $this->document->addScript('//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/cielo_api/list', 'token=' . $this->session->data['token'], true)
        );

        $this->load->model('extension/payment/cielo_api');
        $transactions = $this->model_extension_payment_cielo_api->getTransactions();

        $data['transactions'] = array();

        foreach ($transactions as $transaction) {
            switch ($transaction['tipo']) {
                case 'EletronicTransfer':
                    $metodo = $this->language->get('text_transferencia');
                    break;
                case 'Boleto':
                    $metodo = $this->language->get('text_boleto');
                    break;
                case 'DebitCard':
                    $metodo = $this->language->get('text_debito');
                    break;
                case 'CreditCard':
                    $metodo = $this->language->get('text_credito');
                    break;
            }

            switch ($transaction['status']) {
                case '0':
                    if ($transaction['tipo'] == 'EletronicTransfer') {
                        $status = $this->language->get('text_gerada');
                    } else {
                        $status = $this->language->get('text_nao_finalizada');
                    }
                    break;
                case '1':
                    if ($transaction['tipo'] == 'Boleto') {
                        $status = $this->language->get('text_gerado');
                    } else {
                        $status = $this->language->get('text_autorizada');
                    }
                    break;
                case '2':
                    if ($transaction['tipo'] == 'Boleto') {
                        $status = $this->language->get('text_pago');
                    } else if ($transaction['tipo'] == 'EletronicTransfer') {
                        $status = $this->language->get('text_paga');
                    } else {
                        $status = $this->language->get('text_capturada');
                    }
                    break;
                case '3':
                    $status = $this->language->get('text_negada');
                    break;
                case '10':
                    $status = $this->language->get('text_cancelada');
                    break;
                case '11':
                    $status = $this->language->get('text_estornada');
                    break;
                case '12':
                    $status = $this->language->get('text_pendente');
                    break;
                case '13':
                    $status = $this->language->get('text_antifraude');
                    break;
            }

            $data['transactions'][] = array(
                'cielo_api_id' => $transaction['order_cielo_api_id'],
                'order_id' => $transaction['order_id'],
                'date_added' => date('d/m/Y H:i:s', strtotime($transaction['date_added'])),
                'customer' => $transaction['customer'],
                'metodo' => $metodo,
                'status' => $status,
                'view_order' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $transaction['order_id'], true),
                'view_transaction' => $this->url->link('extension/cielo_api/list/info', 'token=' . $this->session->data['token'] . '&cielo_api_id=' . $transaction['order_cielo_api_id'], true)
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirmacao'] = $this->language->get('text_confirmacao');

        $data['column_order_id'] = $this->language->get('column_order_id');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_customer'] = $this->language->get('column_customer');
        $data['column_metodo'] = $this->language->get('column_metodo');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_excluir'] = $this->language->get('button_excluir');
        $data['button_informacoes'] = $this->language->get('button_informacoes');

        $data['token'] = $this->session->data['token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/cielo_api/list', $data));
    }

    public function info() {
        if (isset($this->request->get['cielo_api_id'])) {
            $order_cielo_api_id = $this->request->get['cielo_api_id'];
        } else {
            $order_cielo_api_id = 0;
        }

        $this->load->model('extension/payment/cielo_api');
        $transaction_info = $this->model_extension_payment_cielo_api->getTransaction($order_cielo_api_id);

        if ($transaction_info) {
            $order_id = $transaction_info['order_id'];

            $this->load->model('sale/order');
            $order_info = $this->model_sale_order->getOrder($order_id);

            $this->load->language('extension/cielo_api/info');

            $this->document->setTitle($this->language->get('heading_title'));

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_edit'] = $this->language->get('text_edit');
            $data['text_com_antifraude'] = $this->language->get('text_com_antifraude');
            $data['text_sem_antifraude'] = $this->language->get('text_sem_antifraude');
            $data['text_nao_autenticada'] = $this->language->get('text_nao_autenticada');
            $data['text_falha_autenticao'] = $this->language->get('text_falha_autenticao');
            $data['text_autenticada'] = $this->language->get('text_autenticada');
            $data['text_consultando'] = $this->language->get('text_consultando');
            $data['text_cancelando'] = $this->language->get('text_cancelando');
            $data['text_capturando'] = $this->language->get('text_capturando');
            $data['text_aguarde'] = $this->language->get('text_aguarde');

            $data['tab_details'] = $this->language->get('tab_details');
            $data['tab_json'] = $this->language->get('tab_json');

            $data['button_consultar'] = $this->language->get('button_consultar');
            $data['button_cancelar'] = $this->language->get('button_cancelar');
            $data['button_capturar'] = $this->language->get('button_capturar');
            $data['button_antifraude'] = $this->language->get('button_antifraude');

            $data['entry_order_id'] = $this->language->get('entry_order_id');
            $data['entry_date_added'] = $this->language->get('entry_date_added');
            $data['entry_total'] = $this->language->get('entry_total');
            $data['entry_customer'] = $this->language->get('entry_customer');
            $data['entry_metodo'] = $this->language->get('entry_metodo');
            $data['entry_payment_id'] = $this->language->get('entry_payment_id');
            $data['entry_antifraude'] = $this->language->get('entry_antifraude');
            $data['entry_tid'] = $this->language->get('entry_tid');
            $data['entry_codigo'] = $this->language->get('entry_codigo');
            $data['entry_bandeira'] = $this->language->get('entry_bandeira');
            $data['entry_eci'] = $this->language->get('entry_eci');
            $data['entry_parcelas'] = $this->language->get('entry_parcelas');
            $data['entry_autorizacao'] = $this->language->get('entry_autorizacao');
            $data['entry_valor_autorizado'] = $this->language->get('entry_valor_autorizado');
            $data['entry_captura'] = $this->language->get('entry_captura');
            $data['entry_valor_capturado'] = $this->language->get('entry_valor_capturado');
            $data['entry_cancelamento'] = $this->language->get('entry_cancelamento');
            $data['entry_valor_cancelado'] = $this->language->get('entry_valor_cancelado');
            $data['entry_boleto_data'] = $this->language->get('entry_boleto_data');
            $data['entry_boleto_vencimento'] = $this->language->get('entry_boleto_vencimento');
            $data['entry_boleto_pagamento'] = $this->language->get('entry_boleto_pagamento');
            $data['entry_boleto_valor'] = $this->language->get('entry_boleto_valor');
            $data['entry_boleto_pago'] = $this->language->get('entry_boleto_pago');
            $data['entry_transferencia_data'] = $this->language->get('entry_transferencia_data');
            $data['entry_transferencia_pagamento'] = $this->language->get('entry_transferencia_pagamento');
            $data['entry_transferencia_valor'] = $this->language->get('entry_transferencia_valor');
            $data['entry_status'] = $this->language->get('entry_status');
            $data['entry_clearsale'] = $this->language->get('entry_clearsale');
            $data['entry_fcontrol'] = $this->language->get('entry_fcontrol');

            $data['error_iframe'] = $this->language->get('error_iframe');

            $data['token'] = $this->session->data['token'];

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_list'),
                'href' => $this->url->link('extension/cielo_api/list', 'token=' . $this->session->data['token'], true)
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/cielo_api/list/info', 'token=' . $this->session->data['token'] . '&cielo_api_id=' . $order_cielo_api_id, true)
            );

            switch ($transaction_info['tipo']) {
                case 'EletronicTransfer':
                    $metodo = $this->language->get('text_transferencia');
                    break;
                case 'Boleto':
                    $metodo = $this->language->get('text_boleto');
                    break;
                case 'DebitCard':
                    $metodo = $this->language->get('text_debito');
                    break;
                case 'CreditCard':
                    $metodo = $this->language->get('text_credito');
                    break;
            }

            switch ($transaction_info['status']) {
                case '0':
                    if ($transaction_info['tipo'] == 'EletronicTransfer') {
                        $status = $this->language->get('text_gerada');
                    } else {
                        $status = $this->language->get('text_nao_finalizada');
                    }
                    break;
                case '1':
                    if ($transaction_info['tipo'] == 'Boleto') {
                        $status = $this->language->get('text_gerado');
                    } else {
                        $status = $this->language->get('text_autorizada');
                    }
                    break;
                case '2':
                    if ($transaction_info['tipo'] == 'Boleto') {
                        $status = $this->language->get('text_pago');
                    } else if ($transaction_info['tipo'] == 'EletronicTransfer') {
                        $status = $this->language->get('text_paga');
                    } else {
                        $status = $this->language->get('text_capturada');
                    }
                    break;
                case '3':
                    $status = $this->language->get('text_negada');
                    break;
                case '10':
                    $status = $this->language->get('text_cancelada');
                    break;
                case '11':
                    $status = $this->language->get('text_estornada');
                    break;
                case '12':
                    $status = $this->language->get('text_pendente');
                    break;
                case '13':
                    $status = $this->language->get('text_antifraude');
                    break;
            }

            $data['view_order'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id, true);
            $data['view_customer'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], true);

            $data['order_id'] = $order_id;
            $data['added'] = date('d/m/Y H:i:s', strtotime($order_info['date_added']));
            $data['customer'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
            $data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);
            $data['cielo_api_id'] = $transaction_info['order_cielo_api_id'];
            $data['metodo'] = $metodo;
            $data['payment_id'] = $transaction_info['paymentId'];
            $data['antifraude'] = $transaction_info['antifraude'];
            $data['eci'] = $transaction_info['eci'];
            $data['tid'] = ($transaction_info['tid']) ? $transaction_info['tid'] : '';
            $data['codigo'] = ($transaction_info['authorizationCode']) ? $transaction_info['authorizationCode'] : '';
            $data['bandeira'] = ($transaction_info['bandeira']) ? $transaction_info['bandeira'] : '';
            $data['parcelas'] = ($transaction_info['parcelas']) ? $transaction_info['parcelas'] : '';
            $data['tipo'] = $transaction_info['tipo'];
            $data['data_autorizacao'] = ($transaction_info['autorizacaoData']) ? date('d/m/Y H:i:s', strtotime($transaction_info['autorizacaoData'])) : '';
            $data['valor_autorizado'] = ($transaction_info['autorizacaoValor']) ? $this->currency->format(($transaction_info['autorizacaoValor'] / 100), $this->config->get('config_currency'), '1.00', true) : '';
            $data['data_captura'] = ($transaction_info['capturaData']) ? date('d/m/Y H:i:s', strtotime($transaction_info['capturaData'])) : '';
            $data['valor_capturado'] = ($transaction_info['capturaValor']) ? $this->currency->format(($transaction_info['capturaValor'] / 100), $this->config->get('config_currency'), '1.00', true) : '';
            $data['data_cancelamento'] = ($transaction_info['cancelaData']) ? date('d/m/Y H:i:s', strtotime($transaction_info['cancelaData'])) : '';
            $data['valor_cancelado'] = ($transaction_info['cancelaValor']) ? $this->currency->format(($transaction_info['cancelaValor'] / 100), $this->config->get('config_currency'), '1.00', true) : '';
            $data['boleto_data'] = ($transaction_info['boletoData']) ? date('d/m/Y H:i:s', strtotime($transaction_info['boletoData'])) : '';
            $data['boleto_vencimento'] = ($transaction_info['boletoVencimento']) ? date('d/m/Y H:i:s', strtotime($transaction_info['boletoVencimento'])) : '';
            $data['boleto_pagamento'] = ($transaction_info['boletoPagamento']) ? date('d/m/Y H:i:s', strtotime($transaction_info['boletoPagamento'])) : '';
            $data['boleto_valor'] = ($transaction_info['boletoValor']) ? $this->currency->format(($transaction_info['boletoValor'] / 100), $this->config->get('config_currency'), '1.00', true) : '';
            $data['boleto_pago'] = ($transaction_info['boletoPagamento']) ? $this->currency->format(($transaction_info['boletoPagamento'] / 100), $this->config->get('config_currency'), '1.00', true) : '';
            $data['transferencia_data'] = ($transaction_info['transferenciaData']) ? date('d/m/Y H:i:s', strtotime($transaction_info['transferenciaData'])) : '';
            $data['transferencia_pagamento'] = ($transaction_info['transferenciaPagamento']) ? date('d/m/Y H:i:s', strtotime($transaction_info['transferenciaPagamento'])) : '';
            $data['transferencia_valor'] = ($transaction_info['transferenciaValor']) ? $this->currency->format(($transaction_info['transferenciaValor'] / 100), $this->config->get('config_currency'), '1.00', true) : '';
            $data['status'] = $status;
            $data['clearsale'] = $this->config->get('cielo_api_credito_clearsale_status');
            $data['fcontrol'] = $this->config->get('cielo_api_credito_fcontrol_status');
            $data['json'] = $this->setJson($transaction_info['json']);

            if ($transaction_info['tipo'] == 'CreditCard' || $transaction_info['tipo'] == 'DebitCard') {
                $data['dias_capturar'] = '';
                $data['dias_cancelar'] = '';

                $atual = strtotime(date('Y-m-d'));

                if ($transaction_info['status'] == '1') {
                    if (!empty($transaction_info['autorizacaoData'])) {
                        $inicial = strtotime(date('Y-m-d', strtotime($transaction_info['autorizacaoData'])));
                        $final = strtotime(date('Y-m-d', strtotime('+5 days', $inicial)));
                        if ($atual <= $final) {
                            $dataFinal = date('d/m/Y', $final);
                            $dias = (int)floor(($final - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
                            $desc = ($dias > 1) ? $this->language->get('text_dias') : $this->language->get('text_dia');
                            $data['dias_capturar'] = sprintf($this->language->get('text_dias_capturar'), $dataFinal, $dias, $desc);
                        }
                    }
                }

                if (($transaction_info['status'] == '1') || ($transaction_info['status'] == '2')) {
                    if (!empty($transaction_info['capturaData'])) {
                        $inicial = strtotime(date('Y-m-d', strtotime($transaction_info['capturaData'])));
                        $final = strtotime(date('Y-m-d', strtotime('+89 days', $inicial)));
                    } else {
                        $inicial = strtotime(date('Y-m-d', strtotime($transaction_info['autorizacaoData'])));
                        $final = strtotime(date('Y-m-d', strtotime('+5 days', $inicial)));
                    }
                    if ($atual <= $final) {
                        $dataFinal = date('d/m/Y', $final);
                        $dias = (int) floor(($final - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
                        $desc = ($dias > 1) ? $this->language->get('text_dias') : $this->language->get('text_dia');
                        $data['dias_cancelar'] = sprintf($this->language->get('text_dias_cancelar'), $dataFinal, $dias, $desc);
                    }
                }
            }

            if ($transaction_info['tipo'] == 'CreditCard') {
                $products = $this->model_sale_order->getOrderProducts($order_id);
                $shippings = $this->model_extension_payment_cielo_api->getOrderShipping($order_id);

                $parcelas = $transaction_info['parcelas'];
                $telefone = preg_replace("/[^0-9]/", '', $order_info['telephone']);
                $email = strtolower($order_info['email']);
                $documento = '';

                $cobranca_nome = '';
                $cobranca_logradouro  = $order_info['payment_address_1'];
                $cobranca_numero = '';
                $cobranca_complemento = '';
                $cobranca_bairro = $order_info['payment_address_2'];
                $cobranca_cidade = $order_info['payment_city'];
                $cobranca_estado = $order_info['payment_zone_code'];
                $cobranca_cep = preg_replace("/[^0-9]/", '', $order_info['payment_postcode']);

                $entrega_nome = $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'];
                $entrega_logradouro  = $order_info['shipping_address_1'];
                $entrega_numero = '';
                $entrega_complemento = '';
                $entrega_bairro = $order_info['shipping_address_2'];
                $entrega_cidade = $order_info['shipping_city'];
                $entrega_estado = $order_info['shipping_zone_code'];
                $entrega_cep = preg_replace("/[^0-9]/", '', $order_info['shipping_postcode']);

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
                    array_push($colunas, $this->config->get('cielo_api_credito_numero_entrega_coluna'));
                }

                if ($this->config->get('cielo_api_credito_custom_complemento_id') == 'N') {
                    array_push($colunas, $this->config->get('cielo_api_credito_complemento_fatura_coluna'));
                    array_push($colunas, $this->config->get('cielo_api_credito_complemento_entrega_coluna'));
                }

                if (count($colunas)) {
                    $colunas_info = $this->model_extension_payment_cielo_api->getOrder($colunas, $order_id);
                }

                if ($this->config->get('cielo_api_credito_custom_razao_id') == 'N') {
                    if (!empty($colunas_info[$this->config->get('cielo_api_credito_razao_coluna')])) {
                        $cobranca_nome = $colunas_info[$this->config->get('cielo_api_credito_razao_coluna')];
                    }
                } else {
                    if ($order_info['custom_field']) {
                        foreach ($order_info['custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_credito_custom_razao_id') == $key) {
                                $cobranca_nome = $value;
                            }
                        }
                    }
                }

                if ($this->config->get('cielo_api_credito_custom_cnpj_id') == 'N') {
                    if (!empty($colunas_info[$this->config->get('cielo_api_credito_cnpj_coluna')])) {
                        $documento = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_credito_cnpj_coluna')]);
                    }
                } else {
                    if (is_array($order_info['custom_field'])) {
                        foreach ($order_info['custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_credito_custom_cnpj_id') == $key) {
                                $documento = preg_replace("/[^0-9]/", '', $value);
                            }
                        }
                    }
                }

                if (empty($cobranca_nome)) {
                    $cobranca_nome = $order_info['payment_firstname'].' '.$order_info['payment_lastname'];

                    if ($this->config->get('cielo_api_credito_custom_cpf_id') == 'N') {
                        if (!empty($colunas_info[$this->config->get('cielo_api_credito_cpf_coluna')])) {
                            $documento = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_credito_cpf_coluna')]);
                        }
                    } else {
                        if (is_array($order_info['custom_field'])) {
                            foreach ($order_info['custom_field'] as $key => $value) {
                                if ($this->config->get('cielo_api_credito_custom_cpf_id') == $key) {
                                    $documento = preg_replace("/[^0-9]/", '', $value);
                                }
                            }
                        }
                    }
                }

                if ($this->config->get('cielo_api_credito_custom_numero_id') == 'N') {
                    $cobranca_numero = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_credito_numero_fatura_coluna')]);
                    $entrega_numero = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('cielo_api_credito_numero_entrega_coluna')]);
                } else {
                    if (is_array($order_info['payment_custom_field'])) {
                        foreach ($order_info['payment_custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_credito_custom_numero_id') == $key) {
                                $cobranca_numero = preg_replace("/[^0-9]/", '', $value);
                            }
                        }
                    }
                    if (is_array($order_info['shipping_custom_field'])) {
                        foreach ($order_info['shipping_custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_credito_custom_numero_id') == $key) {
                                $entrega_numero = preg_replace("/[^0-9]/", '', $value);
                            }
                        }
                    }
                }

                if ($this->config->get('cielo_api_credito_custom_complemento_id') == 'N') {
                    $cobranca_complemento = substr($colunas_info[$this->config->get('cielo_api_credito_complemento_fatura_coluna')], 0, 250);
                    $entrega_complemento = substr($colunas_info[$this->config->get('cielo_api_credito_complemento_entrega_coluna')], 0, 250);
                } else {
                    if (is_array($order_info['payment_custom_field'])) {
                        foreach ($order_info['payment_custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_credito_custom_complemento_id') == $key) {
                                $cobranca_complemento = substr($value, 0, 250);
                            }
                        }
                    }
                    if (is_array($order_info['shipping_custom_field'])) {
                        foreach ($order_info['shipping_custom_field'] as $key => $value) {
                            if ($this->config->get('cielo_api_credito_custom_complemento_id') == $key) {
                                $entrega_complemento = substr($value, 0, 250);
                            }
                        }
                    }
                }

                if ($data['clearsale']) {
                    if ($this->config->get('cielo_api_credito_clearsale_ambiente')) {
                        $clearsale_url = "https://www.clearsale.com.br/start/Entrada/EnviarPedido.aspx";
                    } else {
                        $clearsale_url = "https://homolog.clearsale.com.br/start/Entrada/EnviarPedido.aspx";
                    }

                    $clearsale_itens['CodigoIntegracao'] = $this->config->get('cielo_api_credito_clearsale_codigo');
                    $clearsale_itens['PedidoID'] = $order_id;
                    $clearsale_itens['Data'] = date('d/m/Y h:i:s', strtotime($order_info['date_added']));
                    $clearsale_itens['IP'] = $order_info['ip'];
                    $clearsale_itens['TipoPagamento'] = '1';
                    $clearsale_itens['Parcelas'] = $parcelas;
                    $clearsale_itens['Cobranca_Nome'] = substr($cobranca_nome, 0, 500);
                    $clearsale_itens['Cobranca_Email'] = substr($email, 0, 150);
                    $clearsale_itens['Cobranca_Documento'] = substr($documento, 0, 100);
                    $clearsale_itens['Cobranca_Logradouro'] = substr($cobranca_logradouro, 0, 200);
                    $clearsale_itens['Cobranca_Logradouro_Numero'] = substr($cobranca_numero, 0, 15);
                    $clearsale_itens['Cobranca_Logradouro_Complemento'] = substr($cobranca_complemento, 0, 250);
                    $clearsale_itens['Cobranca_Bairro'] = substr($cobranca_bairro, 0, 150);
                    $clearsale_itens['Cobranca_Cidade'] = substr($cobranca_cidade, 0, 150);
                    $clearsale_itens['Cobranca_Estado' ] = substr($cobranca_estado, 0, 2);
                    $clearsale_itens['Cobranca_CEP'] = $cobranca_cep;
                    $clearsale_itens['Cobranca_Pais'] = 'Bra';
                    $clearsale_itens['Cobranca_DDD_Telefone_1'] = substr($telefone, 0, 2);
                    $clearsale_itens['Cobranca_Telefone_1'] = substr($telefone, 2);

                    if (utf8_strlen($order_info['shipping_method']) > 0) {
                        $clearsale_itens['Entrega_Nome'] = substr($entrega_nome, 0, 500);
                        $clearsale_itens['Entrega_Logradouro'] = substr($entrega_logradouro, 0, 200);
                        $clearsale_itens['Entrega_Logradouro_Numero'] = substr($entrega_numero, 0, 15);
                        $clearsale_itens['Entrega_Logradouro_Complemento'] = substr($entrega_complemento, 0, 250);
                        $clearsale_itens['Entrega_Bairro'] = substr($entrega_bairro, 0, 150);
                        $clearsale_itens['Entrega_Cidade'] = substr($entrega_cidade, 0, 150);
                        $clearsale_itens['Entrega_Estado'] = substr($entrega_estado, 0, 2);
                        $clearsale_itens['Entrega_CEP'] = $entrega_cep;
                        $clearsale_itens['Entrega_Pais'] = 'Bra';
                    }

                    $order_total = 0;

                    $i = 1; 
                    foreach ($products as $product) {
                        $item_valor = $this->currency->format($product['price'], $order_info['currency_code'], '1.00', false);

                        $clearsale_itens['Item_ID_'.$i] = substr($product['product_id'], 0, 50);
                        $clearsale_itens['Item_Nome_'.$i] = substr($product['name'], 0, 150);
                        $clearsale_itens['Item_Qtd_'.$i] = $product['quantity'];
                        $clearsale_itens['Item_Valor_'.$i] = $item_valor;
                        $order_total += ($product['quantity'] * $item_valor);
                        $i++;
                    }

                    foreach ($shippings as $shipping) {
                        if ($shipping['value'] > 0) {
                            $item_valor = $this->currency->format($shipping['value'], $order_info['currency_code'], '1.00', false);

                            $clearsale_itens['Item_ID_'.$i] = substr($shipping['code'], 0, 50);
                            $clearsale_itens['Item_Nome_'.$i] = substr($shipping['title'], 0, 150);
                            $clearsale_itens['Item_Qtd_'.$i] = '1';
                            $clearsale_itens['Item_Valor_'.$i] = $item_valor;
                            $order_total += $item_valor;
                            $i++;
                        }
                    }

                    $valor_pago = $transaction_info['autorizacaoValor'] / 100;
                    if ($order_total > $valor_pago) {
                        $desconto = $order_total - $valor_pago;
                        $item_valor = $this->currency->format($desconto, $order_info['currency_code'], '1.00', false);

                        $clearsale_itens['Item_ID_'.$i] = substr('desconto', 0, 50);
                        $clearsale_itens['Item_Nome_'.$i] = substr('Desconto', 0, 150);
                        $clearsale_itens['Item_Qtd_'.$i] = '1';
                        $clearsale_itens['Item_Valor_'.$i] = -$item_valor;
                        $order_total -= $item_valor;
                        $i++;
                    }

                    $clearsale_itens['Total'] = $this->currency->format($order_total, $order_info['currency_code'], '1.00', false);

                    $data['clearsale_url'] = $clearsale_url;
                    $data['clearsale_itens'] = $clearsale_itens;
                    $data['clearsale_src'] = $clearsale_url . '?codigointegracao=' . $this->config->get('cielo_api_credito_clearsale_codigo') . '&PedidoID=' . $order_id;
                }

                if ($data['fcontrol']) {
                    $data['fcontrol_url'] = "https://secure.fcontrol.com.br/validatorframe/validatorframe.aspx?";

                    $data['fcontrol_url'] .= 'login='.$this->config->get('cielo_api_credito_fcontrol_login').
                                            '&Senha='.$this->config->get('cielo_api_credito_fcontrol_senha').
                                            '&nomeComprador='.substr($cobranca_nome, 0, 255).
                                            '&ruaComprador='.substr($cobranca_logradouro, 0, 255).
                                            '&numeroComprador='.substr($cobranca_numero, 0, 8).
                                            '&complementoComprador='.substr($cobranca_complemento, 0, 50).
                                            '&bairroComprador='.substr($cobranca_bairro, 0, 150).
                                            '&cidadeComprador='.substr($cobranca_cidade, 0, 255).
                                            '&ufComprador='.substr($cobranca_estado, 0, 2).
                                            '&paisComprador=Bra'.
                                            '&cepComprador='.substr($cobranca_cep, 0, 5) . '-' . substr($cobranca_cep, 5, 3).
                                            '&cpfComprador='.$documento.
                                            '&dddComprador='.substr($telefone, 0, 2).
                                            '&telefoneComprador='.substr($telefone, 2).
                                            '&emailComprador='.$email.
                                            '&ip='.$order_info['ip'];

                    if (utf8_strlen($order_info['shipping_method']) > 0) {
                        $data['fcontrol_url'] .= '&nomeEntrega='.substr($entrega_nome, 0, 255).
                                                '&ruaEntrega='.substr($entrega_logradouro, 0, 255).
                                                '&numeroEntrega='.substr($entrega_numero, 0, 8).
                                                '&complementoEntrega='.substr($entrega_complemento, 0, 50).
                                                '&bairroEntrega='.substr($entrega_bairro, 0, 150).
                                                '&cidadeEntrega='.substr($entrega_cidade, 0, 255).
                                                '&ufEntrega='.substr($entrega_estado, 0, 2).
                                                '&paisEntrega=Bra'.
                                                '&cepEntrega='.substr($entrega_cep, 0, 5) . '-' . substr($entrega_cep, 5, 3).
                                                '&dddEntrega='.substr($telefone, 0, 2).
                                                '&telefoneEntrega='.substr($telefone, 2);
                    }

                    $order_total = 0;
                    $itens_total = 0;
                    $itens_qtd = 0;

                    foreach ($products as $product) {
                        $item_valor = $product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0);
                        $order_total += $item_valor;
                        $itens_total += $product['quantity'];
                        $itens_qtd++;
                    }

                    foreach ($shippings as $shipping) {
                        $order_total += $shipping['value'];
                        $itens_total += 1;
                        $itens_qtd++;
                    }

                    $valor_compra = $this->currency->format($order_total, $order_info['currency_code'], '1.00', false);
                    $valor_pagamento = $this->currency->format(($transaction_info['autorizacaoValor'] / 100), $order_info['currency_code'], '1.00', false);

                    $data['fcontrol_url'] .= '&codigoPedido='.$order_id.
                                            '&quantidadeItensDistintos='.$itens_qtd.
                                            '&quantidadeTotalItens='.$itens_total.
                                            '&valorTotalCompra='.($valor_compra*100).
                                            '&dataCompra='.date('Y-m-d', strtotime($order_info['date_added'])).'T'.date('h:i:s', strtotime($order_info['date_added'])).
                                            '&canalVenda=lojavirtual'.
                                            '&codigoIntegrador=0';

                    $data['fcontrol_url'] .= '&metodoPagamentos=55'.
                                            '&numeroParcelasPagamentos='.$parcelas.
                                            '&valorPagamentos='.($valor_pagamento*100);
                }
            }

            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view('extension/cielo_api/info', $data));
        } else {
            $this->load->language('error/not_found');

            $this->document->setTitle($this->language->get('heading_title'));

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_not_found'] = $this->language->get('text_not_found');

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], true)
            );

            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    public function excluir() {
        $json = array();

        $this->load->language('extension/cielo_api/list');

        if ($this->user->hasPermission('modify', 'extension/cielo_api/list')) {
            if (isset($this->request->get['cielo_api_id'])) {
                $order_cielo_api_id = (int) $this->request->get['cielo_api_id'];

                $this->load->model('extension/payment/cielo_api');
                $transaction_info = $this->model_extension_payment_cielo_api->getTransaction($order_cielo_api_id);

                if ($transaction_info) {
                    $this->model_extension_payment_cielo_api->deleteTransaction($order_cielo_api_id);
                } else {
                    $json['error'] = $this->language->get('error_warning');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function consultar() {
        $json = array();

        $this->load->language('extension/cielo_api/info');

        if ($this->user->hasPermission('modify', 'extension/cielo_api/list')) {
            if (isset($this->request->get['cielo_api_id'])) {
                $order_cielo_api_id = (int) $this->request->get['cielo_api_id'];

                $this->load->model('extension/payment/cielo_api');
                $transaction_info = $this->model_extension_payment_cielo_api->getTransaction($order_cielo_api_id);

                if ($transaction_info) {
                    if ($transaction_info['tipo'] == 'CreditCard') {
                        $tipo = 'credito';
                    } else if ($transaction_info['tipo'] == 'DebitCard') {
                        $tipo = 'debito';
                    } else if ($transaction_info['tipo'] == 'Boleto') {
                        $tipo = 'boleto';
                    } else if ($transaction_info['tipo'] == 'EletronicTransfer') {
                        $tipo = 'transferencia';
                    } else {
                        $tipo = 'credito';
                    }

                    $dados['PaymentId'] = $transaction_info['paymentId'];

                    $dados['Chave'] = $this->config->get('cielo_api_'. $tipo .'_chave');
                    $dados['Debug'] = $this->config->get('cielo_api_'. $tipo .'_debug');
                    $dados['Ambiente'] = $this->config->get('cielo_api_'. $tipo .'_ambiente');
                    $dados['MerchantId'] = $this->config->get('cielo_api_'. $tipo .'_merchantid');
                    $dados['MerchantKey'] = $this->config->get('cielo_api_'. $tipo .'_merchantkey');

                    require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
                    require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
                    $cielo = new Cielo();
                    $cielo->setParametros($dados);
                    $resposta = $cielo->getTransacao();

                    if ($resposta) {
                        if (!empty($resposta->Payment)) {
                            $transacaoStatus = $resposta->Payment->Status;

                            switch($transacaoStatus) {
                                case '0':
                                    if ($transaction_info['tipo'] == 'EletronicTransfer') {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => '',
                                            'autorizacaoData' => '',
                                            'autorizacaoValor' => '',
                                            'capturaData' => '',
                                            'capturaValor' => '',
                                            'cancelaData' => '',
                                            'cancelaValor' => '',
                                            'boletoPagamento' => '',
                                            'boletoValor' => '',
                                            'transferenciaPagamento' => '',
                                            'transferenciaValor' => $resposta->Payment->Amount,
                                            'json' => json_encode($resposta)
                                        );

                                        $this->model_extension_payment_cielo_api->updateTransaction($dados);

                                        $status = $this->language->get('text_gerada');
                                    } else {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus
                                        );

                                        $this->model_extension_payment_cielo_api->updateTransactionStatus($dados);

                                        if (isset($resposta->Payment->ReturnMessage)) {
                                            $status = $resposta->Payment->ReturnMessage;
                                        } else {
                                            $status = $this->language->get('text_nao_finalizada');
                                        }
                                    }

                                    $json['mensagem'] = $status;
                                    break;
                                case '1':
                                    if ($transaction_info['tipo'] == 'Boleto') {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => '',
                                            'autorizacaoData' => '',
                                            'autorizacaoValor' => '',
                                            'capturaData' => '',
                                            'capturaValor' => '',
                                            'cancelaData' => '',
                                            'cancelaValor' => '',
                                            'boletoPagamento' => '',
                                            'boletoValor' => $resposta->Payment->Amount,
                                            'transferenciaPagamento' => '',
                                            'transferenciaValor' => '',
                                            'json' => json_encode($resposta)
                                        );

                                        $status = $this->language->get('text_gerado');
                                    } else {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                            'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                            'autorizacaoValor' => $resposta->Payment->Amount,
                                            'capturaData' => '',
                                            'capturaValor' => '',
                                            'cancelaData' => '',
                                            'cancelaValor' => '',
                                            'boletoPagamento' => '',
                                            'boletoValor' => '',
                                            'transferenciaPagamento' => '',
                                            'transferenciaValor' => '',
                                            'json' => json_encode($resposta)
                                        );

                                        if (isset($resposta->Payment->ReturnMessage)) {
                                            $status = $resposta->Payment->ReturnMessage;
                                        } else {
                                            $status = $this->language->get('text_autorizada');
                                        }
                                    }

                                    $this->model_extension_payment_cielo_api->updateTransaction($dados);

                                    $json['mensagem'] = $status;
                                    break;
                                case '2':
                                    if ($transaction_info['tipo'] == 'EletronicTransfer') {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => '',
                                            'autorizacaoData' => '',
                                            'autorizacaoValor' => '',
                                            'capturaData' => '',
                                            'capturaValor' => '',
                                            'cancelaData' => '',
                                            'cancelaValor' => '',
                                            'boletoPagamento' => '',
                                            'boletoValor' => '',
                                            'transferenciaPagamento' => $resposta->Payment->CapturedDate,
                                            'transferenciaValor' => $resposta->Payment->CapturedAmount,
                                            'json' => json_encode($resposta)
                                        );

                                        $status = $this->language->get('text_paga');
                                    } else if ($transaction_info['tipo'] == 'Boleto') {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => '',
                                            'autorizacaoData' => '',
                                            'autorizacaoValor' => '',
                                            'capturaData' => '',
                                            'capturaValor' => '',
                                            'cancelaData' => '',
                                            'cancelaValor' => '',
                                            'boletoPagamento' => $resposta->Payment->CapturedDate,
                                            'boletoValor' => $resposta->Payment->CapturedAmount,
                                            'transferenciaPagamento' => '',
                                            'transferenciaValor' => '',
                                            'json' => json_encode($resposta)
                                        );

                                        $status = $this->language->get('text_pago');
                                    } else {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                            'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                            'autorizacaoValor' => $resposta->Payment->Amount,
                                            'capturaData' => $resposta->Payment->CapturedDate,
                                            'capturaValor' => $resposta->Payment->CapturedAmount,
                                            'cancelaData' => '',
                                            'cancelaValor' => '',
                                            'boletoPagamento' => '',
                                            'boletoValor' => '',
                                            'transferenciaPagamento' => '',
                                            'transferenciaValor' => '',
                                            'json' => json_encode($resposta)
                                        );

                                        if (isset($resposta->Payment->ReturnMessage)) {
                                            $status = $resposta->Payment->ReturnMessage;
                                        } else {
                                            $status = $this->language->get('text_capturada');
                                        }
                                    }

                                    $this->model_extension_payment_cielo_api->updateTransaction($dados);

                                    $json['mensagem'] = $status;
                                    break;
                                case '10':
                                    if ($transaction_info['tipo'] == 'EletronicTransfer') {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus
                                        );

                                        $this->model_extension_payment_cielo_api->updateTransactionStatus($dados);

                                        $status = $this->language->get('text_cancelada');
                                    } else if ($transaction_info['tipo'] == 'Boleto') {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus
                                        );

                                        $this->model_extension_payment_cielo_api->updateTransactionStatus($dados);

                                        $status = $this->language->get('text_cancelada');
                                    } else {
                                        $dados = array(
                                            'order_cielo_api_id' => $order_cielo_api_id,
                                            'status' => $transacaoStatus,
                                            'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                            'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                            'autorizacaoValor' => $resposta->Payment->Amount,
                                            'capturaData' => (isset($resposta->Payment->CapturedDate)) ? $resposta->Payment->CapturedDate : '',
                                            'capturaValor' => (isset($resposta->Payment->CapturedAmount)) ? $resposta->Payment->CapturedAmount : '',
                                            'cancelaData' => $resposta->Payment->VoidedDate,
                                            'cancelaValor' => $resposta->Payment->VoidedAmount,
                                            'boletoPagamento' => '',
                                            'boletoValor' => '',
                                            'transferenciaPagamento' => '',
                                            'transferenciaValor' => '',
                                            'json' => json_encode($resposta)
                                        );

                                        $this->model_extension_payment_cielo_api->updateTransaction($dados);

                                        if (isset($resposta->Payment->ReturnMessage)) {
                                            $status = $resposta->Payment->ReturnMessage;
                                        } else {
                                            $status = $this->language->get('text_cancelada');
                                        }
                                    }

                                    $json['mensagem'] = $status;
                                    break;
                                case '11':
                                    $dados = array(
                                        'order_cielo_api_id' => $order_cielo_api_id,
                                        'status' => $transacaoStatus,
                                        'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                        'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                        'autorizacaoValor' => $resposta->Payment->Amount,
                                        'capturaData' => (isset($resposta->Payment->CapturedDate)) ? $resposta->Payment->CapturedDate : '',
                                        'capturaValor' => (isset($resposta->Payment->CapturedAmount)) ? $resposta->Payment->CapturedAmount : '',
                                        'cancelaData' => $resposta->Payment->VoidedDate,
                                        'cancelaValor' => $resposta->Payment->VoidedAmount,
                                        'boletoPagamento' => '',
                                        'boletoValor' => '',
                                        'transferenciaPagamento' => '',
                                        'transferenciaValor' => '',
                                        'json' => json_encode($resposta)
                                    );

                                    $this->model_payment_cielo_api->updateTransaction($dados);

                                    if (isset($resposta->Payment->ReturnMessage)) {
                                        $status = $resposta->Payment->ReturnMessage;
                                    } else {
                                        $status = $this->language->get('text_estornada');
                                    }

                                    $json['mensagem'] = $status;
                                    break;
                                default:
                                    $dados = array(
                                        'order_cielo_api_id' => $order_cielo_api_id,
                                        'status' => $transacaoStatus
                                    );

                                    $this->model_extension_payment_cielo_api->updateTransactionStatus($dados);

                                    if (isset($resposta->Payment->ReturnMessage)) {
                                        $status = $resposta->Payment->ReturnMessage;
                                    } else {
                                        $mensagem = array(
                                            '3' => $this->language->get('text_negada'),
                                            '12' => $this->language->get('text_pendente'),
                                            '13' => $this->language->get('text_antifraude'),
                                        );

                                        $status = $mensagem[$transacaoStatus];
                                    }

                                    $json['mensagem'] = $status;
                                    break;
                            }
                        } else {
                            $json['error'] = $this->language->get('error_consultar');
                        }
                    } else {
                        $json['error'] = $this->language->get('error_consultar');
                    }
                } else {
                    $json['error'] = $this->language->get('error_warning');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function capturar() {
        $json = array();

        $this->load->language('extension/cielo_api/info');

        if ($this->user->hasPermission('modify', 'extension/cielo_api/list')) {
            if (isset($this->request->get['cielo_api_id'])) {
                $order_cielo_api_id = (int) $this->request->get['cielo_api_id'];

                $this->load->model('extension/payment/cielo_api');
                $transaction_info = $this->model_extension_payment_cielo_api->getTransaction($order_cielo_api_id);

                if ($transaction_info) {
                    if ($transaction_info['tipo'] == 'CreditCard') {
                        $tipo = 'credito';
                    } else if ($transaction_info['tipo'] == 'DebitCard') {
                        $tipo = 'debito';
                    } else if ($transaction_info['tipo'] == 'Boleto') {
                        $tipo = 'boleto';
                    } else if ($transaction_info['tipo'] == 'EletronicTransfer') {
                        $tipo = 'transferencia';
                    } else {
                        $tipo = 'credito';
                    }

                    $dados['PaymentId'] = $transaction_info['paymentId'];

                    $dados['Chave'] = $this->config->get('cielo_api_'. $tipo .'_chave');
                    $dados['Debug'] = $this->config->get('cielo_api_'. $tipo .'_debug');
                    $dados['Ambiente'] = $this->config->get('cielo_api_'. $tipo .'_ambiente');
                    $dados['MerchantId'] = $this->config->get('cielo_api_'. $tipo .'_merchantid');
                    $dados['MerchantKey'] = $this->config->get('cielo_api_'. $tipo .'_merchantkey');

                    require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
                    require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
                    $cielo = new Cielo();
                    $cielo->setParametros($dados);
                    $resposta = $cielo->setCapturar();

                    if ($resposta) {
                        if (!empty($resposta->Status)) {
                            switch($resposta->Status) {
                                case '2':
                                    $dados['order_cielo_api_id'] = $order_cielo_api_id;
                                    $dados['status'] = $resposta->Status;
                                    $dados['json'] = json_encode($resposta);

                                    $this->model_extension_payment_cielo_api->captureTransaction($dados);

                                    $json['mensagem'] = $this->language->get('text_capturada');
                                    break;
                                default:
                                    if (isset($resposta->ReturnMessage)) {
                                        $json['error'] = $resposta->ReturnMessage;
                                    } else {
                                        $json['error'] = $this->language->get('error_capturar');
                                    }
                                    break;
                            }
                        } else {
                            $json['error'] = $this->language->get('error_capturar');
                        }
                    } else {
                        $json['error'] = $this->language->get('error_capturar');
                    }
                } else {
                    $json['error'] = $this->language->get('error_warning');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function setCancelar() {
        $json = array();

        $this->load->language('extension/cielo_api/info');

        if ($this->user->hasPermission('modify', 'extension/cielo_api/list')) {
            if (isset($this->request->get['cielo_api_id'])) {
                $order_cielo_api_id = (int) $this->request->get['cielo_api_id'];

                $this->load->model('extension/payment/cielo_api');
                $transaction_info = $this->model_extension_payment_cielo_api->getTransaction($order_cielo_api_id);

                if ($transaction_info) {
                    if ($transaction_info['tipo'] == 'CreditCard') {
                        $tipo = 'credito';
                    } else if ($transaction_info['tipo'] == 'DebitCard') {
                        $tipo = 'debito';
                    } else if ($transaction_info['tipo'] == 'Boleto') {
                        $tipo = 'boleto';
                    } else if ($transaction_info['tipo'] == 'EletronicTransfer') {
                        $tipo = 'transferencia';
                    }

                    $dados['PaymentId'] = $transaction_info['paymentId'];

                    $dados['Chave'] = $this->config->get('cielo_api_'. $tipo .'_chave');
                    $dados['Debug'] = $this->config->get('cielo_api_'. $tipo .'_debug');
                    $dados['Ambiente'] = $this->config->get('cielo_api_'. $tipo .'_ambiente');
                    $dados['MerchantId'] = $this->config->get('cielo_api_'. $tipo .'_merchantid');
                    $dados['MerchantKey'] = $this->config->get('cielo_api_'. $tipo .'_merchantkey');

                    require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
                    require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
                    $cielo = new Cielo();
                    $cielo->setParametros($dados);
                    $resposta = $cielo->setCancelar();

                    if ($resposta) {
                        if (!empty($resposta->Status)) {
                            switch($resposta->Status) {
                                case '10':
                                    $dados['order_cielo_api_id'] = $order_cielo_api_id;
                                    $dados['status'] = $resposta->Status;
                                    $dados['json'] = json_encode($resposta);

                                    $this->model_extension_payment_cielo_api->cancelTransaction($dados);

                                    $json['mensagem'] = $this->language->get('text_cancelada');
                                    break;
                                case '11':
                                    $dados['order_cielo_api_id'] = $order_cielo_api_id;
                                    $dados['status'] = $resposta->Status;
                                    $dados['json'] = json_encode($resposta);

                                    $this->model_extension_payment_cielo_api->cancelTransaction($dados);

                                    $json['mensagem'] = $this->language->get('text_estornada');
                                    break;
                                default:
                                    if (isset($resposta->ReturnMessage)) {
                                        $json['error'] = $resposta->ReturnMessage;
                                    } else {
                                        $json['error'] = $this->language->get('error_cancel');
                                    }
                                    break;
                            }
                        } else {
                            $json['error'] = $this->language->get('error_cancelar');
                        }
                    } else {
                        $json['error'] = $this->language->get('error_cancelar');
                    }
                } else {
                    $json['error'] = $this->language->get('error_warning');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function setJson($json) {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if ($ends_line_level !== NULL) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ($in_escape) {
                $in_escape = false;
            } else if ($char === '"') {
                $in_quotes = !$in_quotes;
            } else if (!$in_quotes) {
                switch($char) {
                    case '}': case ']':
                        $level--;
                        $ends_line_level = NULL;
                        $new_line_level = $level;
                        break;
                    case '{': case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;
                    case ':':
                        $post = " ";
                        break;
                    case " ": case "\t": case "\n": case "\r":
                        $char = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level = NULL;
                        break;
                }
            } else if ($char === '\\') {
                $in_escape = true;
            }
            if($new_line_level !== NULL) {
                $result .= "\n".str_repeat( "\t", $new_line_level );
            }
            $result .= $char.$post;
        }

        return $result;
    }
}