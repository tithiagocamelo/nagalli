<?php
// Heading
$_['heading_title']       = 'Dados para o pagamento';

// Text
$_['text_basket']         = 'Carrinho de compras';
$_['text_checkout']       = 'Finalizar pedido';
$_['text_pagamento']      = 'Cartão de débito';
$_['text_payment']        = 'Seu pedido será enviado assim que o pagamento for confirmado.';
$_['text_detalhes']       = 'Dados do cartão de débito:';
$_['text_carregando']     = 'Carregando...';
$_['text_verificando']    = 'Verificando os dados do cartão...';
$_['text_redirecionando'] = 'Aguarde o redirecionamento para a página de autenticação...';
$_['text_cartao_debito']  = 'Cartão de Débito';
$_['text_visa']           = 'Visa Electron';
$_['text_mastercard']     = 'Maestro';
$_['text_mes']            = 'Mês';
$_['text_ano']            = 'Ano';
$_['text_pendente']       = 'Pendente';
$_['text_autorizado']     = 'Autorizado';
$_['text_capturado']      = 'Capturado';
$_['text_nao_autorizado'] = 'Não autorizado';
$_['text_sandbox']        = '<strong>ATENÇÃO:</strong><br />- Você está no ambiente Sandbox, em resumo, nenhum pagamento será validado.';

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

// Error
$_['error_bandeiras']     = '<strong>Atenção:</strong><br />Nenhum cartão foi habilitado nas configurações da extensão.';
$_['error_cartao']        = 'Número não é válido';
$_['error_titular']       = 'Titular não é válido';
$_['error_mes']           = 'Selecione o mês';
$_['error_ano']           = 'Selecione o ano';
$_['error_codigo']        = 'Código inválido';
$_['error_autorizacao']   = '<strong>O pagamento por cartão de débito não foi autorizado.</strong><br /><br /><strong>VERIFIQUE SE:</strong><br />- Você preencheu corretamente todos os campos com os dados do seu cartão.<br />- Você possui limite disponível para o pagamento do pedido.<br /><br /><strong>IMPORTANTE:</strong><br />- <strong>Só utilize cartões habilitados para débito e crédito</strong>, pois cartões habilitados somente para débito, não são autorizados para pagamento através de lojas online.<br />- <strong>Utilize o código de segurança que está no verso do seu cartão</strong>, se o seu cartão não possui código de segurança no verso, ele não é autorizado para este pagamento.<br />- Após a digitação dos dados do seu cartão de débito, você será direcionado(a) para fazer uma <strong>autenticação no banco emissor do seu cartão</strong>.<br />- Tenha em mãos o seu <strong>celular habilitado no Internet Banking, token eletrônico, cartão de códigos, CPF e senha do cartão de débito</strong>, para o processo de autenticação.<br />- <strong>Caso seu pagamento não seja autenticado ou autorizado, tente só mais uma vez</strong>, pois o banco emissor do seu cartão poderá bloquear o pagamento por 24 horas.<br /><br />Lembre-se que você pode tentar outro cartão ou selecionar outra forma de pagamento.<br />Em caso de dúvidas, entre em contato com nosso atendimento.';