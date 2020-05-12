<?php
// Text
$_['text_payment']        = 'Seu pedido será liberado assim que o pagamento for confirmado.';
$_['text_detalhes']       = 'Dados do cartão de débito:';
$_['text_carregando']     = 'Carregando...';
$_['text_verificando']    = 'Verificando os dados do cartão...';
$_['text_redirecionando'] = 'Aguarde o redirecionamento para a página de autenticação...';
$_['text_cartao_debito']  = 'Cartão de Débito';
$_['text_visa']           = 'Visa Electron';
$_['text_mastercard']     = 'Maestro';
$_['text_mes']            = 'Mês';
$_['text_ano']            = 'Ano';
$_['text_pendente']       = 'Autorização pendente';
$_['text_autorizado']     = 'Pagamento autorizado';
$_['text_capturado']      = 'Pagamento capturado';
$_['text_nao_autorizado'] = 'Não autorizado';
$_['text_tentativas']     = 'O limite de tentativas de pagamento com o cartão de débito foi excedido.';
$_['text_sandbox']        = '<strong>Atenção:</strong><br>Você está no ambiente Sandbox, por isso, nenhum pagamento será validado.<br>No ambiente Sandbox, não é recomendado utilizar dados de cartões válidos, por isso, utilize qualquer informação não válida para teste.';

// Button
$_['button_pagar']        = 'Confirmar pagamento';

// Entry
$_['entry_total']         = 'Total: ';
$_['entry_bandeira']      = 'Bandeira do cartão: ';
$_['entry_cartao']        = 'Número do ';
$_['entry_titular']       = 'Titular do cartão: ';
$_['entry_validade_mes']  = 'Válido até (mês): ';
$_['entry_validade_ano']  = 'Válido até (ano): ';
$_['entry_codigo']        = 'Cód. de segurança: ';
$_['entry_pedido']        = 'Pedido: ';
$_['entry_data']          = 'Data: ';
$_['entry_tid']           = 'TID: ';
$_['entry_tipo']          = 'Pago com: ';
$_['entry_status']        = 'Status: ';
$_['entry_erro']          = 'Erro: ';
$_['entry_mensagem']      = 'Mensagem: ';

// Error
$_['error_bandeiras']     = '<strong>Atenção:</strong><br>Nenhum cartão foi ativado nas configurações da extensão.';
$_['error_cartao']        = 'Número não é válido';
$_['error_titular']       = 'Titular não é válido';
$_['error_mes']           = 'Selecione o mês';
$_['error_ano']           = 'Selecione o ano';
$_['error_codigo']        = 'Código inválido';
$_['error_permissao']     = 'Acesso negado!';
$_['error_tentativas']    = '<strong>Atenção:<br>Você excedeu o limite de tentativas para pagamento.<br>Em caso de dúvidas, entre em contato com nosso atendimento.</strong>';
$_['error_preenchimento'] = '<strong>Atenção:</strong><br>Todos os campos são de preenchimento obrigatório.';
$_['error_configuracao']  = '<strong>Atenção:</strong><br>Não foi possível autorizar o seu pagamento por problemas técnicos.<br>Tente novamente mais tarde ou selecione outra forma de pagamento.<br>Em caso de dúvidas, entre em contato com nosso atendimento.';
$_['error_json']          = '<strong>Atenção:</strong><br>Não foi possível autorizar o seu pagamento.<br>Tente novamente, e em caso de dúvidas, entre em contato com nosso atendimento.';
$_['error_autorizacao']   = '<strong>O pagamento por cartão de débito não foi autorizado.</strong><br><br><strong>VERIFIQUE SE:</strong><br>- Você preencheu corretamente todos os campos com os dados do seu cartão.<br>- Você possui limite disponível para o pagamento do pedido.<br><br><strong>IMPORTANTE:</strong><br>- <strong>Só utilize cartões habilitados para débito e crédito</strong>, pois cartões habilitados somente para débito, não são autorizados para pagamento através de lojas online.<br>- <strong>Utilize o código de segurança que está no verso do seu cartão</strong>, se o seu cartão não possui código de segurança no verso, ele não é autorizado para este pagamento.<br>- Após a digitação dos dados do seu cartão de débito, você será direcionado(a) para fazer uma <strong>autenticação no banco emissor do seu cartão</strong>.<br>- Tenha em mãos o seu <strong>celular habilitado no Internet Banking, token eletrônico, cartão de códigos, CPF e senha do cartão de débito</strong>, para o processo de autenticação.<br>- <strong>Caso seu pagamento não seja autenticado ou autorizado, tente só mais uma vez</strong>, pois o banco emissor do seu cartão poderá bloquear o pagamento por 24 horas.<br><br>Lembre-se que você pode tentar outro cartão ou selecionar outra forma de pagamento.<br>Em caso de dúvidas, entre em contato com nosso atendimento.';