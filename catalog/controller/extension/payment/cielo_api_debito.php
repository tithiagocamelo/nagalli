<?php
class ControllerExtensionPaymentCieloApiDebito extends Controller {
    private $valorTotal = 0;

    public function index() {
        $this->load->language('extension/payment/cielo_api_debito');

        $data['text_sandbox'] = $this->language->get('text_sandbox');
        $data['text_detalhes'] = $this->language->get('text_detalhes');
        $data['text_mes'] = $this->language->get('text_mes');
        $data['text_ano'] = $this->language->get('text_ano');
        $data['text_carregando'] = $this->language->get('text_carregando');
        $data['text_verificando'] = $this->language->get('text_verificando');
        $data['text_redirecionando'] = $this->language->get('text_redirecionando');

        $data['button_pagar'] = $this->language->get('button_pagar');

        $data['entry_bandeira'] = $this->language->get('entry_bandeira');
        $data['entry_cartao'] = $this->language->get('entry_cartao');
        $data['entry_titular'] = $this->language->get('entry_titular');
        $data['entry_validade_mes'] = $this->language->get('entry_validade_mes');
        $data['entry_validade_ano'] = $this->language->get('entry_validade_ano');
        $data['entry_codigo'] = $this->language->get('entry_codigo');
        $data['entry_total'] = $this->language->get('entry_total');

        $data['error_cartao'] = $this->language->get('error_cartao');
        $data['error_titular'] = $this->language->get('error_titular');
        $data['error_mes'] = $this->language->get('error_mes');
        $data['error_ano'] = $this->language->get('error_ano');
        $data['error_codigo'] = $this->language->get('error_codigo');

        $data['error_bandeiras'] = $this->language->get('error_bandeiras');
        $data['error_configuracao'] = $this->language->get('error_configuracao');

        $data['ambiente'] = $this->config->get('cielo_api_debito_ambiente');

        $data['cor_normal_texto'] = $this->config->get('cielo_api_debito_cor_normal_texto');
        $data['cor_normal_fundo'] = $this->config->get('cielo_api_debito_cor_normal_fundo');
        $data['cor_normal_borda'] = $this->config->get('cielo_api_debito_cor_normal_borda');
        $data['cor_efeito_texto'] = $this->config->get('cielo_api_debito_cor_efeito_texto');
        $data['cor_efeito_fundo'] = $this->config->get('cielo_api_debito_cor_efeito_fundo');
        $data['cor_efeito_borda'] = $this->config->get('cielo_api_debito_cor_efeito_borda');

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);

        $data['bandeiras'] = array();
        foreach ($this->getBandeiras() as $bandeira) {
            ($this->config->get('cielo_api_debito_' . $bandeira)) ? array_push($data['bandeiras'], $bandeira) : '';
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

        if (isset($this->session->data['attempts'])) {
            unset($this->session->data['attempts']);
        }
        $this->session->data['attempts'] = 3;

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        return $this->load->view('extension/payment/cielo_api_debito', $data);
    }

    public function bandeiras() {
        $json = array();

        if (isset($this->session->data['order_id']) && isset($this->session->data['attempts'])) {
            foreach ($this->getBandeiras() as $bandeira) {
                ($this->config->get('cielo_api_debito_' . $bandeira)) ? $json[] = array('bandeira' => $bandeira, 'titulo' => ($bandeira == 'visa' ? 'VISA ELECTRON' : 'MAESTRO'), 'imagem' => HTTPS_SERVER .'image/catalog/cielo_api/'. $bandeira .'_debito.png') : '';
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function pagamento() {
        if (isset($this->session->data['order_id'])) {
            $this->load->language('extension/payment/cielo_api_pagamento');

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
                'text' => $this->language->get('text_pagamento'),
                'href' => $this->url->link('extension/payment/cielo_api_debito/pagamento', '', true)
            );

            include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

            $this->document->addStyle('catalog/view/javascript/cielo_api/css/skeleton/normalize.css?v='.$data['versao']);
            $this->document->addStyle('catalog/view/javascript/cielo_api/css/skeleton/skeleton.css?v='.$data['versao']);
            $this->document->addScript('catalog/view/javascript/cielo_api/js/jquery-loading-overlay/loadingoverlay.min.js?v='.$data['versao']);

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_sandbox'] = $this->language->get('text_sandbox');
            $data['text_informacoes'] = $this->language->get('text_informacoes');
            $data['text_detalhes'] = $this->language->get('text_detalhes');
            $data['text_carregando'] = $this->language->get('text_carregando');
            $data['text_verificando'] = $this->language->get('text_verificando');
            $data['text_redirecionando'] = $this->language->get('text_redirecionando');
            $data['text_mes'] = $this->language->get('text_mes');
            $data['text_ano'] = $this->language->get('text_ano');

            $data['button_pagar'] = $this->language->get('button_pagar');

            $data['entry_bandeira'] = $this->language->get('entry_bandeira');
            $data['entry_cartao'] = $this->language->get('entry_cartao');
            $data['entry_titular'] = $this->language->get('entry_titular');
            $data['entry_validade_mes'] = $this->language->get('entry_validade_mes');
            $data['entry_validade_ano'] = $this->language->get('entry_validade_ano');
            $data['entry_codigo'] = $this->language->get('entry_codigo');
            $data['entry_total'] = $this->language->get('entry_total');

            $data['error_cartao'] = $this->language->get('error_cartao');
            $data['error_titular'] = $this->language->get('error_titular');
            $data['error_mes'] = $this->language->get('error_mes');
            $data['error_ano'] = $this->language->get('error_ano');
            $data['error_codigo'] = $this->language->get('error_codigo');

            $data['error_autorizacao'] = $this->language->get('error_autorizacao');
            $data['error_bandeiras'] = $this->language->get('error_bandeiras');
            $data['error_configuracao'] = $this->language->get('error_configuracao');

            $data['ambiente'] = $this->config->get('cielo_api_debito_ambiente');

            $data['cor_normal_texto'] = $this->config->get('cielo_api_debito_cor_normal_texto');
            $data['cor_normal_fundo'] = $this->config->get('cielo_api_debito_cor_normal_fundo');
            $data['cor_normal_borda'] = $this->config->get('cielo_api_debito_cor_normal_borda');
            $data['cor_efeito_texto'] = $this->config->get('cielo_api_debito_cor_efeito_texto');
            $data['cor_efeito_fundo'] = $this->config->get('cielo_api_debito_cor_efeito_fundo');
            $data['cor_efeito_borda'] = $this->config->get('cielo_api_debito_cor_efeito_borda');

            $data['falhou'] = false;

            if (isset($this->session->data['falhou'])) {
                $data['falhou'] = $this->session->data['falhou'];
                unset($this->session->data['falhou']);
            }

            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

            $data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);

            $bandeiras = array();
            foreach ($this->getBandeiras() as $bandeira) {
                ($this->config->get('cielo_api_debito_' . $bandeira)) ? array_push($bandeiras, $bandeira) : '';
            }
            $data['bandeiras'] = $bandeiras;

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

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('extension/payment/cielo_api_pagamento', $data));
        } else {
            $this->response->redirect($this->url->link('error/not_found'));
        }
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
                'href' => $this->url->link('extension/payment/cielo_api_debito/comprovante')
            );

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_importante'] = $this->language->get('text_importante');
            $data['text_comprovante'] = $this->session->data['comprovante'];

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

    public function retorno() {
        $this->language->load('extension/payment/cielo_api_debito');

        if (isset($this->session->data['order_id']) || isset($this->session->data['cielo_api_id'])) {
            $this->session->data['falhou'] = true;

            $order_id = $this->session->data['order_id'];
            $cielo_api_id = $this->session->data['cielo_api_id'];

            $this->load->model('extension/payment/cielo_api_debito');
            $transaction_info = $this->model_extension_payment_cielo_api_debito->getTransaction($cielo_api_id);

            $dados['PaymentId'] = $transaction_info['paymentId'];

            $dados['Chave'] = $this->config->get('cielo_api_debito_chave');
            $dados['Debug'] = $this->config->get('cielo_api_debito_debug');
            $dados['Ambiente'] = $this->config->get('cielo_api_debito_ambiente');
            $dados['MerchantId'] = $this->config->get('cielo_api_debito_merchantid');
            $dados['MerchantKey'] = $this->config->get('cielo_api_debito_merchantkey');

            require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
            require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
            $cielo = new Cielo();
            $cielo->setParametros($dados);
            $resposta = $cielo->getTransacao();

            if ($resposta) {
                if (!empty($resposta->Payment)) {
                    $this->load->model('checkout/order');
                    $order_info = $this->model_checkout_order->getOrder($order_id);

                    $transacaoStatus = $resposta->Payment->Status;
                    $transacaoData = date('d/m/Y H:i', strtotime($resposta->Payment->ReceivedDate));
                    $transacaoTid = $resposta->Payment->Tid;
                    $transacaoBandeira = $resposta->Payment->DebitCard->Brand;
                    $transacaoValor = $this->currency->format(($resposta->Payment->Amount / 100), $order_info['currency_code'], '1.00', true);

                    if (!empty($transacaoStatus)) {
                        switch($transacaoStatus) {
                            case '1':
                                $dados = array(
                                    'order_cielo_api_id' => $transaction_info['order_cielo_api_id'],
                                    'status' => $transacaoStatus,
                                    'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                    'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                    'autorizacaoValor' => $resposta->Payment->Amount,
                                    'capturaData' => '',
                                    'capturaValor' => '',
                                    'json' => json_encode($resposta)
                                );

                                $this->model_extension_payment_cielo_api_debito->updateTransaction($dados);

                                $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_debito') . "\n";
                                $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                $comment .= $this->language->get('entry_total') . $transacaoValor . "\n";
                                $comment .= $this->language->get('entry_status') . $this->language->get('text_autorizado');

                                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_debito_situacao_autorizada_id'), $comment, true);

                                if(isset($this->session->data['comprovante'])) {
                                    unset($this->session->data['comprovante']);
                                }
                                $this->session->data['comprovante'] = $comment;
                                break;
                            case '2':
                                $dados = array(
                                    'order_cielo_api_id' => $transaction_info['order_cielo_api_id'],
                                    'status' => $transacaoStatus,
                                    'eci' => (isset($resposta->Payment->Eci)) ? $resposta->Payment->Eci : '',
                                    'autorizacaoData' => $resposta->Payment->ReceivedDate,
                                    'autorizacaoValor' => $resposta->Payment->Amount,
                                    'capturaData' => $resposta->Payment->CapturedDate,
                                    'capturaValor' => $resposta->Payment->CapturedAmount,
                                    'json' => json_encode($resposta)
                                );

                                $this->model_extension_payment_cielo_api_debito->updateTransaction($dados);

                                $transacaoData = date('d/m/Y H:i', strtotime($resposta->Payment->CapturedDate));
                                $transacaoValor = $this->currency->format(($resposta->Payment->CapturedAmount / 100), $order_info['currency_code'], '1.00', true);

                                $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_debito') . "\n";
                                $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                $comment .= $this->language->get('entry_total') . $transacaoValor . "\n";
                                $comment .= $this->language->get('entry_status') . $this->language->get('text_capturado');

                                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_debito_situacao_capturada_id'), $comment, true);

                                if(isset($this->session->data['comprovante'])) {
                                    unset($this->session->data['comprovante']);
                                }
                                $this->session->data['comprovante'] = $comment;
                                break;
                            default:
                                $dados = array(
                                    'order_cielo_api_id' => $transaction_info['order_cielo_api_id'],
                                    'status' => $transacaoStatus,
                                    'json' => json_encode($resposta)
                                );

                                $this->model_extension_payment_cielo_api_debito->updateTransactionStatus($dados);

                                $comment = $this->language->get('entry_pedido') . $order_id . "\n";
                                $comment .= $this->language->get('entry_data') . $transacaoData . "\n";
                                $comment .= $this->language->get('entry_tid') . $transacaoTid . "\n";
                                $comment .= $this->language->get('entry_tipo') . $this->language->get('text_cartao_debito') . "\n";
                                $comment .= $this->language->get('entry_bandeira') . strtoupper($transacaoBandeira) . "\n";
                                $comment .= $this->language->get('entry_total') . $transacaoValor . "\n";
                                $comment .= $this->language->get('entry_status') . $this->language->get('text_nao_autorizado');

                                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_debito_situacao_nao_autorizada_id'), $comment, true);
                                break;
                        }

                        if (($transacaoStatus == '1') || ($transacaoStatus == '2')) {
                            $this->response->redirect($this->url->link('extension/payment/cielo_api_debito/comprovante', '', true));
                        } else {
                            $this->response->redirect($this->url->link('extension/payment/cielo_api_debito/pagamento', '', true));
                        }
                    } else {
                        $this->response->redirect($this->url->link('extension/payment/cielo_api_debito/pagamento', '', true));
                    }
                } else {
                    $this->response->redirect($this->url->link('extension/payment/cielo_api_debito/pagamento', '', true));
                }
            } else {
                $this->response->redirect($this->url->link('extension/payment/cielo_api_debito/pagamento', '', true));
            }
        } else {
            $this->response->redirect($this->url->link('error/not_found'));
        }
    }

    private function getBandeiras() {
        $bandeiras = array(
            "visa",
            "mastercard"
        );

        return $bandeiras;
    }

    public function setTransacao() {
        $json = array();

        $this->language->load('extension/payment/cielo_api_debito');

        if (isset($this->session->data['order_id']) && isset($this->session->data['attempts']) && $this->setValidarPost()) {
            if ($this->session->data['attempts'] > 0) {
                $bandeiraCartao = trim($this->request->post['bandeira']);
                $titularCartao = trim($this->request->post['titular']);
                $numeroCartao = preg_replace("/[^0-9]/", '', $this->request->post['cartao']);
                $mesCartao = preg_replace("/[^0-9]/", '', $this->request->post['mes']);
                $anoCartao = preg_replace("/[^0-9]/", '', $this->request->post['ano']);
                $codigoCartao = preg_replace("/[^0-9]/", '', $this->request->post['codigo']);

                $campos = array($bandeiraCartao, $titularCartao, $numeroCartao, $mesCartao, $anoCartao, $codigoCartao);
                $bandeiras = $this->getBandeiras();

                if ($this->setValidarCampos($campos) && in_array(strtolower($bandeiraCartao), $bandeiras)) {
                    $this->session->data['attempts']--;

                    $order_id = $this->session->data['order_id'];
                    $this->load->model('checkout/order');
                    $order_info = $this->model_checkout_order->getOrder($order_id);

                    $this->valorTotal = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
                    $total = $this->valorTotal;
                    $total = number_format($total, 2, '', '');

                    $bandeirasCielo = array(
                        'visa' => 'Visa',
                        'mastercard' => 'Master'
                    );

                    $dados['MerchantOrderId'] = $order_id;
                    $dados['Customer'] = $order_info['firstname'] . ' ' . $order_info['lastname'];

                    $dados['Amount'] = $total;
                    $dados['SoftDescriptor'] = $this->config->get('cielo_api_debito_soft_descriptor');

                    $dados['CardNumber'] = $numeroCartao;
                    $dados['Holder'] = $titularCartao;
                    $dados['ExpirationDate'] = $mesCartao . '/' . $anoCartao;
                    $dados['SecurityCode'] = $codigoCartao;
                    $dados['Brand'] = $bandeirasCielo[$bandeiraCartao];

                    $dados['ReturnUrl'] = HTTPS_SERVER .'index.php?route=extension/payment/cielo_api_debito/retorno';

                    $dados['Chave'] = $this->config->get('cielo_api_debito_chave');
                    $dados['Debug'] = $this->config->get('cielo_api_debito_debug');
                    $dados['Ambiente'] = $this->config->get('cielo_api_debito_ambiente');
                    $dados['MerchantId'] = $this->config->get('cielo_api_debito_merchantid');
                    $dados['MerchantKey'] = $this->config->get('cielo_api_debito_merchantkey');

                    require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
                    require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
                    $cielo = new Cielo();
                    $cielo->setParametros($dados);
                    $resposta = $cielo->setTransacaoDebito();

                    if ($resposta) {
                        if (!empty($resposta->Payment)) {
                            $transacaoStatus = $resposta->Payment->Status;

                            switch($transacaoStatus) {
                                case '0':
                                    $campos = array(
                                        'order_id' => $order_id,
                                        'paymentId' => $resposta->Payment->PaymentId,
                                        'status' => $transacaoStatus,
                                        'tipo' => $resposta->Payment->Type,
                                        'tid' => $resposta->Payment->Tid,
                                        'parcelas' => '1',
                                        'bandeira' => $resposta->Payment->DebitCard->Brand,
                                        'json' => json_encode($resposta)
                                    );

                                    $this->load->model('extension/payment/cielo_api_debito');
                                    $this->session->data['cielo_api_id'] = $this->model_extension_payment_cielo_api_debito->addTransaction($campos);

                                    $this->load->model('checkout/order');
                                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_debito_situacao_pendente_id'), $this->language->get('text_pendente'), true);

                                    $json['redirect'] = $resposta->Payment->AuthenticationUrl;
                                    break;
                                default:
                                    $this->load->model('checkout/order');
                                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_debito_situacao_pendente_id'), $this->language->get('text_nao_autorizado'), true);

                                    $json['error'] = $this->language->get('error_autorizacao');
                                    break;
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
                    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cielo_api_debito_situacao_nao_autorizada_id'), $this->language->get('text_tentativas'), true);
                }

                $json['error'] = $this->language->get('error_tentativas');
            }
        } else {
            $json['error'] = $this->language->get('error_permissao');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function setValidarPost() {
        $campos = array('bandeira', 'titular', 'cartao', 'mes', 'ano', 'codigo');

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
}