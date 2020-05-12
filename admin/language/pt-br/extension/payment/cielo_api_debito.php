<?php
// Heading
$_['heading_title']                 = 'Cielo API Débito';

// Text
$_['text_extension']                = 'Extensões';
$_['text_success']                  = 'Pagamento por Cielo API Débito modificado com sucesso!';
$_['text_edit']                     = 'Configurações do pagamento por Cielo API Débito';
$_['text_cielo_api_debito']         = '<a target="_BLANK" href="https://www.cielo.com.br/aceite-cartao/api/"><img src="view/image/payment/cielo_api.jpg" alt="Cielo API Débito" title="Cielo API Débito" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_manage']                   = 'Gerenciar pagamento';
$_['text_image_manager']            = 'Gerenciador de arquivos';
$_['text_browse']                   = 'Localizar';
$_['text_clear']                    = 'Apagar';
$_['text_botao']                    = 'Cor do botão CONFIRMAR PAGAMENTO na finalização do pedido';
$_['text_texto']                    = 'Cor do texto';
$_['text_fundo']                    = 'Cor do fundo';
$_['text_borda']                    = 'Cor da borda';
$_['text_sandbox']                  = 'Sandbox';
$_['text_producao']                 = 'Produção';

// Tab
$_['tab_geral']                     = 'Configurações';
$_['tab_api']                       = 'API';
$_['tab_situacoes_pedido']          = 'Situações';
$_['tab_finalizacao']               = 'Finalização';

// Button
$_['button_save_stay']              = 'Salvar e continuar';
$_['button_save']                   = 'Salvar e sair';

// Entry
$_['entry_chave']                   = 'Chave da extensão';
$_['entry_total']                   = 'Total mínimo';
$_['entry_geo_zone']                = 'Região geográfica';
$_['entry_status']                  = 'Situação';
$_['entry_sort_order']              = 'Posição';
$_['entry_merchantid']              = 'Merchant ID';
$_['entry_merchantkey']             = 'Merchant Key';
$_['entry_soft_descriptor']         = 'Identificação no extrato';
$_['entry_ambiente']                = 'Ambiente';
$_['entry_debug']                   = 'Debug';
$_['entry_visa']                    = 'Cartão Visa Electron';
$_['entry_mastercard']              = 'Cartão Mastercard Maestro';
$_['entry_situacao_pendente']       = 'Pendente';
$_['entry_situacao_autorizada']     = 'Autorizado';
$_['entry_situacao_nao_autorizada'] = 'Não autorizado';
$_['entry_situacao_capturada']      = 'Capturado';
$_['entry_situacao_cancelada']      = 'Cancelado';
$_['entry_titulo']                  = 'Título da extensão';
$_['entry_imagem']                  = 'Imagem da extensão';
$_['entry_botao_normal']            = 'Cor inicial';
$_['entry_botao_efeito']            = 'Cor com efeito';

// Help
$_['help_chave']                    = 'A chave da extensão é fornecida pelo OpenCart Brasil.';
$_['help_total']                    = 'Valor mínimo que o pedido deve alcançar para que a extensão seja habilitada. Deixe em branco se não houver valor mínimo.';
$_['help_merchantid']               = 'É gerado e enviado ao lojista pela Cielo através de e-mail. Você recebe após a confirmação do credenciamento da loja na Cielo. Contém 36 caracteres.';
$_['help_merchantkey']              = 'É gerada e enviada ao lojista pela Cielo através de e-mail. Você recebe após a confirmação do credenciamento da loja na Cielo. Contém 40 caracteres.';
$_['help_soft_descriptor']          = 'Texto com até 13 caracteres que será exibido no extrato bancário do cliente para que ele identifique a origem do débito. O texto não deve conter espaço, sinais de pontuação, acentuação ou ç, e deve ser preenchido em maiúsculo.';
$_['help_ambiente']                 = 'Selecione Sandbox, caso deseje apenas testar o funcionamento da extensão na loja. Quando for vender selecione Produção.';
$_['help_debug']                    = 'Selecione Habilitado caso deseje visualizar as informações enviadas pela API da Cielo para a loja. Por padrão deixe Desabilitado.';
$_['help_visa']                     = 'Para pagamento à vista, com suporte para autenticação do titular do cartão através do banco emissor.';
$_['help_mastercard']               = 'Para pagamento à vista, com suporte para autenticação do titular do cartão através do banco emissor.';
$_['help_situacao_pendente']        = 'Selecione a situação para identificar o pedido pendente, ou situação inicial do pedido.';
$_['help_situacao_autorizada']      = 'Selecione a situação para identificar o pedido que está com a transação autorizada.';
$_['help_situacao_nao_autorizada']  = 'Selecione a situação para identificar o pedido que está com a transação não autorizada.';
$_['help_situacao_capturada']       = 'Selecione a situação para identificar o pedido que está com a transação capturada.';
$_['help_situacao_cancelada']       = 'Selecione a situação para identificar o pedido que está com a transação cancelada.';
$_['help_titulo']                   = 'Título que será exibido na finalização do pedido.';
$_['help_imagem']                   = 'Caso selecione uma imagem, ela será exibida no lugar do título da extensão.';
$_['help_botao_normal']             = 'Cor do botão quando o mesmo não estiver pressionado ou não estiver com o mouse sobre ele.';
$_['help_botao_efeito']             = 'Cor do botão quando o mesmo for pressionado ou quando o mouse estiver sobre ele.';

// Error
$_['error_permission']              = 'Atenção: Você não tem permissão para modificar a extensão Cielo API Débito!';
$_['error_warning']                 = 'Atenção: A extensão não foi configurada corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_chave']                   = 'O campo Chave da extensão é obrigatório!';
$_['error_merchantid']              = 'O campo Merchant ID está vazio ou foi preenchido de maneira incorreta!';
$_['error_merchantkey']             = 'O campo Merchant Key está vazio ou foi preenchido de maneira incorreta!';
$_['error_soft_descriptor']         = 'O campo Identificação no extrato está vazio ou foi preenchido de maneira incorreta!';
$_['error_titulo']                  = 'O campo Título da extensão é obrigatório!';