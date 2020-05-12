<?php
class ControllerExtensionPaymentCieloAPITransferencia extends Controller {
    private $valorTotal = 0;

    public function index() {
        $this->load->language('extension/payment/cielo_api_transferencia');

        $data['text_sandbox'] = $this->language->get('text_sandbox');
        $data['text_confirmando'] = $this->language->get('text_confirmando');
        $data['text_confirmado'] = $this->language->get('text_confirmado');

        $data['button_confirmar'] = $this->language->get('button_confirmar');

        $data['error_configuracao'] = $this->language->get('error_configuracao');

        $data['ambiente'] = $this->config->get('cielo_api_transferencia_ambiente');

        $data['cor_normal_texto'] = $this->config->get('cielo_api_transferencia_cor_normal_texto');
        $data['cor_normal_fundo'] = $this->config->get('cielo_api_transferencia_cor_normal_fundo');
        $data['cor_normal_borda'] = $this->config->get('cielo_api_transferencia_cor_normal_borda');
        $data['cor_efeito_texto'] = $this->config->get('cielo_api_transferencia_cor_efeito_texto');
        $data['cor_efeito_fundo'] = $this->config->get('cielo_api_transferencia_cor_efeito_fundo');
        $data['cor_efeito_borda'] = $this->config->get('cielo_api_transferencia_cor_efeito_borda');

        include_once(DIR_SYSTEM . 'library/cielo_api/versao.php');

        return $this->load->view('extension/payment/cielo_api_transferencia', $data);
    }

    public function setTransacao() {
        $json = array();

        if (isset($this->session->data['order_id']) && $this->session->data['payment_method']['code'] == 'cielo_api_transferencia') {
            $this->language->load('extension/payment/cielo_api_transferencia');

            $order_id = $this->session->data['order_id'];

            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($order_id);

            $total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $total = number_format($total, 2, '', '');

            $dados['MerchantOrderId'] = $order_id;

            $dados['Customer'] = $order_info['payment_firstname'].' '.$order_info['payment_lastname'];

            $dados['Amount'] = $total;
            $dados['Provider'] = $this->config->get('cielo_api_transferencia_banco');
            $dados['ReturnUrl'] = HTTPS_SERVER .'index.php?route=extension/payment/cielo_api_transferencia/retorno';

            $dados['Chave'] = $this->config->get('cielo_api_transferencia_chave');
            $dados['Debug'] = $this->config->get('cielo_api_transferencia_debug');
            $dados['Ambiente'] = $this->config->get('cielo_api_transferencia_ambiente');
            $dados['MerchantId'] = $this->config->get('cielo_api_transferencia_merchantid');
            $dados['MerchantKey'] = $this->config->get('cielo_api_transferencia_merchantkey');

            require_once(DIR_SYSTEM . 'library/cielo_api/debug.php');
            require_once(DIR_SYSTEM . 'library/cielo_api/cielo.php');
            $cielo = new Cielo();
            $cielo->setParametros($dados);
            $resposta = $cielo->setTransacaoTransferencia();

            if ($resposta) {
                if (isset($resposta->Payment->Url)) {
                    $campos = array(
                        'order_id' => $order_id,
                        'paymentId' => $resposta->Payment->PaymentId,
                        'status' => $resposta->Payment->Status,
                        'tipo' => $resposta->Payment->Type,
                        'transferenciaData' => $resposta->Payment->ReceivedDate,
                        'transferenciaValor' => $resposta->Payment->Amount,
                        'json' => json_encode($resposta)
                    );

                    $this->load->model('extension/payment/cielo_api_transferencia');
                    $this->model_extension_payment_cielo_api_transferencia->addTransaction($campos);

                    $this->load->model('checkout/order');
                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('cielo_api_transferencia_situacao_gerada_id'), $this->language->get('text_mensagem'), true);

                    if(isset($this->session->data['transferencia_cielo_api_url'])) {
                        unset($this->session->data['transferencia_cielo_api_url']);
                    }
                    $this->session->data['transferencia_cielo_api_url'] = $resposta->Payment->Url;

                    $json['redirect'] = $this->url->link('extension/payment/cielo_api_transferencia/confirmado', '', true);
                } else {
                    $json['error'] = $this->language->get('error_nao_gerou');
                }
            } else {
                $json['error'] = $this->language->get('error_nao_gerou');
            }

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function confirmado() {
        if (isset($this->session->data['transferencia_cielo_api_url'])) {
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
                unset($this->session->data['coupon']);
                unset($this->session->data['reward']);
                unset($this->session->data['voucher']);
                unset($this->session->data['vouchers']);
                unset($this->session->data['totals']);
            }

            $this->load->language('extension/payment/cielo_api_transferencia');

            $this->document->setTitle($this->language->get('heading_confirmado'));

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
                'text' => $this->language->get('heading_confirmado'),
                'href' => $this->url->link('extension/payment/cielo_api_transferencia/confirmado')
            );

            $data['heading_title'] = $this->language->get('heading_confirmado');

            $data['text_mensagem'] = $this->language->get('text_instrucoes');
            $data['text_botao'] = $this->language->get('button_pagar');

            $data['url'] = $this->session->data['transferencia_cielo_api_url'];

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

    public function retorno() {
        $this->load->language('extension/payment/cielo_api_transferencia');

        $this->document->setTitle($this->language->get('heading_retorno'));

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
            'text' => $this->language->get('heading_retorno'),
            'href' => $this->url->link('extension/payment/cielo_api_transferencia/retorno')
        );

        $data['heading_title'] = $this->language->get('heading_retorno');

        $data['text_mensagem'] = $this->language->get('text_importante');

        $data['text_botao'] = $this->language->get('button_historico');

        $data['url'] = $this->url->link('account/order', '', true);

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('extension/payment/cielo_api_confirmado', $data));
    }
}