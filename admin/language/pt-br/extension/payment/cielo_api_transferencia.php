<?php
// Heading
$_['heading_title']                = 'Cielo API Transferência';

// Text
$_['text_extension']               = 'Extensões';
$_['text_success']                 = 'Pagamento por Cielo API Transferência modificado com sucesso!';
$_['text_edit']                    = 'Configurações do pagamento por Cielo API Transferência';
$_['text_cielo_api_transferencia'] = '<a target="_blank" href="https://www.cielo.com.br/aceite-cartao/api/"><img src="view/image/payment/cielo_api.jpg" alt="Cielo API Transferência" title="Cielo API Transferência" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_configuracoes']           = 'Configurações';
$_['text_situacoes']               = 'Situações';
$_['text_bradesco']                = 'Bradesco';
$_['text_banco_brasil']            = 'Banco do Brasil';
$_['text_botao']                   = 'Cor do botão CONFIRMAR PEDIDO na finalização do pedido';
$_['text_texto']                   = 'Cor do texto:';
$_['text_fundo']                   = 'Cor de fundo:';
$_['text_borda']                   = 'Cor da borda:';
$_['text_sandbox']                 = 'Sandbox';
$_['text_producao']                = 'Produção';

// Button
$_['button_save_stay']             = 'Salvar e continuar';
$_['button_save']                  = 'Salvar e sair';

// Tab
$_['tab_geral']                    = 'Configurações';
$_['tab_api']                      = 'API';
$_['tab_situacoes']                = 'Situações';
$_['tab_finalizacao']              = 'Finalização';

// Entry
$_['entry_chave']                  = 'Chave da extensão';
$_['entry_total']                  = 'Total mínimo';
$_['entry_geo_zone']               = 'Região geográfica';
$_['entry_status']                 = 'Situação';
$_['entry_sort_order']             = 'Posição';
$_['entry_merchantid']             = 'Merchant ID';
$_['entry_merchantkey']            = 'Merchant Key';
$_['entry_ambiente']               = 'Ambiente';
$_['entry_debug']                  = 'Debug';
$_['entry_banco']                  = 'Banco';
$_['entry_situacao_gerada']        = 'Transferência gerada';
$_['entry_situacao_pendente']      = 'Transferência pendente';
$_['entry_situacao_paga']          = 'Transferência paga';
$_['entry_situacao_negada']        = 'Transferência negada';
$_['entry_situacao_cancelada']     = 'Transferência cancelada';
$_['entry_titulo']                 = 'Título da extensão';
$_['entry_imagem']                 = 'Imagem da extensão';
$_['entry_botao_normal']           = 'Cor inicial';
$_['entry_botao_efeito']           = 'Cor com efeito';

// Help
$_['help_chave']                   = 'A chave da extensão é fornecida pelo OpenCart Brasil.';
$_['help_total']                   = 'Valor mínimo que o pedido deve alcançar para que a forma de pagamento por Transferência seja habilitada. Deixe em branco se não houver valor mínimo.';
$_['help_status']                  = 'Selecione Habilitado, para oferecer o pagamento por Transferência.';
$_['help_merchantid']              = 'É gerado e enviado ao lojista pela Cielo através de e-mail. Você recebe após a confirmação do credenciamento da loja na Cielo. Contém 36 caracteres.';
$_['help_merchantkey']             = 'É gerada e enviada ao lojista pela Cielo através de e-mail. Você recebe após a confirmação do credenciamento da loja na Cielo. Contém 40 caracteres.';
$_['help_ambiente']                = 'Selecione Sandbox, caso deseje apenas testar o funcionamento da extensão na loja. Quando for vender selecione Produção.';
$_['help_debug']                   = 'Selecione Habilitado caso deseje visualizar as informações enviadas pela API da Cielo para a loja. Por padrão deixe Desabilitado.';
$_['help_banco']                   = 'Banco responsável pela transferência.';
$_['help_situacao_gerada']         = 'Selecione a situação para identificar o pedido que está com a transferência gerada.';
$_['help_situacao_pendente']       = 'Selecione a situação para identificar o pedido que está com a transferência pendente.';
$_['help_situacao_paga']           = 'Selecione a situação para identificar o pedido que está com a transferência paga.';
$_['help_situacao_negada']         = 'Selecione a situação para identificar o pedido que está com a transferência negada.';
$_['help_situacao_cancelada']      = 'Selecione a situação para identificar o pedido que está com a transferência cancelada.';
$_['help_titulo']                  = 'Título do pagamento por transferência eletrônica, que será exibido na finalização do pedido.';
$_['help_imagem']                  = 'Caso selecione uma imagem, ela será exibida no lugar do título da extensão.';
$_['help_botao_normal']            = 'Cor do botão quando o mesmo não estiver pressionado ou não estiver com o mouse sobre ele.';
$_['help_botao_efeito']            = 'Cor do botão quando o mesmo for pressionado ou quando o mouse estiver sobre ele.';

// Error
$_['error_permission']             = 'Atenção: Você não tem permissão para modificar a extensão Cielo API Transferência!';
$_['error_warning']                = 'Atenção: A extensão não foi configurada corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_chave']                  = 'O campo Chave da extensão é obrigatório!';
$_['error_merchantid']             = 'O campo Merchant ID está vazio ou foi preenchido de maneira incorreta!';
$_['error_merchantkey']            = 'O campo Merchant Key está vazio ou foi preenchido de maneira incorreta!';
$_['error_titulo']                 = 'O campo Título da extensão é obrigatório!';