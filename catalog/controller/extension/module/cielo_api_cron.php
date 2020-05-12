<?php
class ControllerExtensionModuleCieloApiCron extends Controller {
    public function index() {
        if ($this->config->get('cielo_api_cron_status')) {
            $this->load->language('extension/module/cielo_api_cron');

            if (isset($this->request->get['key'])) {
                if ($this->config->get('cielo_api_cron_chave_cron') == $this->request->get['key']) {
                    $this->debug($this->language->get('text_cron_iniciada'));

                    $this->load->model('extension/module/cielo_api_cron');
                    $transactions = $this->model_extension_module_cielo_api_cron->getTransactions();
                    foreach ($transactions as $transaction) {
                        $order_id = $transaction['order_id'];
                        $order_cielo_api_id = $transaction['order_cielo_api_id'];
                        $this->consultar($order_id, $order_cielo_api_id);
                    }

                    $this->debug($this->language->get('text_cron_encerrada'));
                } else {
                    $this->debug($this->language->get('error_cron_invalida'));
                    $this->response->redirect($this->url->link('error/not_found'));
                }
            } else {
                $this->debug($this->language->get('error_cron_negada'));
                $this->response->redirect($this->url->link('error/not_found'));
            }
        }
    }

    private function consultar($order_id, $order_cielo_api_id) {
        $this->load->model('extension/module/cielo_api_cron');
        $transaction_info = $this->model_extension_module_cielo_api_cron->getTransaction($order_cielo_api_id);

        if ($transaction_info['tipo'] == 'EletronicTransfer') {
            $tipo = 'boleto';
        } else if ($transaction_info['tipo'] == 'Boleto') {
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
        $resposta = $cielo->getTransacao();

        if ($resposta) {
            if (!empty($resposta->Payment)) {
                $transacaoStatus = $resposta->Payment->Status;

                switch ($transacaoStatus) {
                    case '0':
                        $situacao = $this->language->get('text_gerada');
                        $order_status_id = $this->config->get('cielo_api_transferencia_situacao_gerada_id');
                        break;
                    case '1':
                        $situacao = $this->language->get('text_gerado');
                        $order_status_id = $this->config->get('cielo_api_boleto_situacao_gerado_id');
                        break;
                    case '2':
                        if ($transaction_info['tipo'] == 'EletronicTransfer') {
                            $situacao = $this->language->get('text_paga');
                            $order_status_id = $this->config->get('cielo_api_transferencia_situacao_paga_id');
                        } else if ($transaction_info['tipo'] == 'Boleto') {
                            $situacao = $this->language->get('text_pago');
                            $order_status_id = $this->config->get('cielo_api_boleto_situacao_pago_id');
                        }
                        break;
                    case '3':
                        $situacao = $this->language->get('text_negada');
                        $order_status_id = $this->config->get('cielo_api_transferencia_situacao_negada_id');
                        break;
                    case '12':
                        if ($transaction_info['tipo'] == 'EletronicTransfer') {
                            $situacao = $this->language->get('text_pendente');
                            $order_status_id = $this->config->get('cielo_api_transferencia_situacao_pendente_id');
                        } else if ($transaction_info['tipo'] == 'Boleto') {
                            $situacao = $this->language->get('text_pendente');
                            $order_status_id = $this->config->get('cielo_api_boleto_situacao_pendente_id');
                        }
                        break;
                    case '10':
                    case '13':
                        if ($transaction_info['tipo'] == 'EletronicTransfer') {
                            $situacao = $this->language->get('text_cancelada');
                            $order_status_id = $this->config->get('cielo_api_transferencia_situacao_cancelada_id');
                        } else if ($transaction_info['tipo'] == 'Boleto') {
                            $situacao = $this->language->get('text_cancelado');
                            $order_status_id = $this->config->get('cielo_api_boleto_situacao_cancelado_id');
                        }
                        break;
                }

                $this->load->model('checkout/order');
                $order_info = $this->model_checkout_order->getOrder($order_id);

                if (isset($order_status_id) && $order_info['order_status_id'] != $order_status_id) {
                    switch ($transacaoStatus) {
                        case '0':
                            $dados = array(
                                'order_cielo_api_id' => $order_cielo_api_id,
                                'status' => $transacaoStatus,
                                'boletoPagamento' => '',
                                'boletoValor' => '',
                                'transferenciaPagamento' => '',
                                'transferenciaValor' => $resposta->Payment->Amount,
                                'json' => json_encode($resposta)
                            );

                            $this->model_extension_module_cielo_api_cron->updateTransaction($dados);
                            break;
                        case '1':
                            $dados = array(
                                'order_cielo_api_id' => $order_cielo_api_id,
                                'status' => $transacaoStatus,
                                'boletoPagamento' => '',
                                'boletoValor' => $resposta->Payment->Amount,
                                'transferenciaPagamento' => '',
                                'transferenciaValor' => '',
                                'json' => json_encode($resposta)
                            );

                            $this->model_extension_module_cielo_api_cron->updateTransaction($dados);
                            break;
                        case '2':
                            if ($transaction_info['tipo'] == 'EletronicTransfer') {
                                $dados = array(
                                    'order_cielo_api_id' => $order_cielo_api_id,
                                    'status' => $transacaoStatus,
                                    'boletoPagamento' => '',
                                    'boletoValor' => '',
                                    'transferenciaPagamento' => $resposta->Payment->CapturedDate,
                                    'transferenciaValor' => $resposta->Payment->CapturedAmount,
                                    'json' => json_encode($resposta)
                                );

                                $this->model_extension_module_cielo_api_cron->updateTransaction($dados);
                            } else if ($transaction_info['tipo'] == 'Boleto') {
                                $dados = array(
                                    'order_cielo_api_id' => $order_cielo_api_id,
                                    'status' => $transacaoStatus,
                                    'boletoPagamento' => $resposta->Payment->CapturedDate,
                                    'boletoValor' => $resposta->Payment->CapturedAmount,
                                    'transferenciaPagamento' => '',
                                    'transferenciaValor' => '',
                                    'json' => json_encode($resposta)
                                );

                                $this->model_extension_module_cielo_api_cron->updateTransaction($dados);
                            }
                            break;
                        case '3':
                        case '10':
                        case '12':
                        case '13':
                            $dados = array(
                                'order_cielo_api_id' => $order_cielo_api_id,
                                'status' => $transacaoStatus
                            );

                            $this->model_extension_module_cielo_api_cron->updateTransactionStatus($dados);
                            break;
                    }

                    if ($this->config->get('cielo_api_cron_notification')) {
                        $mail = new Mail();
                        $mail->protocol = $this->config->get('config_mail_protocol');
                        $mail->parameter = $this->config->get('config_mail_parameter');
                        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                        $mail->setTo($this->config->get('config_email'));
                        $mail->setFrom($this->config->get('config_email'));
                        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
                        $mail->setSubject(html_entity_decode(sprintf($this->language->get('text_email_subject'), $order_id), ENT_QUOTES, 'UTF-8'));
                        $mail->setText(html_entity_decode(sprintf($this->language->get('text_email_content'), $order_id, $situacao), ENT_QUOTES, 'UTF-8'));
                        $mail->send();
                    }

                    $this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $situacao, true);
                }
            }
        }
    }

    private function debug($log) {
        if (defined('DIR_LOGS')){
            $file = DIR_LOGS . 'cielo_api.log';
            $handle = fopen($file, 'a');
            fwrite($handle, date('d/m/Y H:i:s (T)') . "\n");
            fwrite($handle, print_r($log, true) . "\n");
            fclose($handle);
        }
    }
}