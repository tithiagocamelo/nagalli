<?php
// Heading
$_['heading_title']               = 'Cielo API Boleto';

// Text
$_['text_extension']              = 'Extensões';
$_['text_success']                = 'Pagamento por Cielo API Boleto modificado com sucesso!';
$_['text_edit']                   = 'Configurações do pagamento por Cielo API Boleto';
$_['text_cielo_api_boleto']       = '<a target="_blank" href="https://www.cielo.com.br/aceite-cartao/api/"><img src="view/image/payment/cielo_api.jpg" alt="Cielo API Boleto" title="Cielo API Boleto" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_configuracoes']          = 'Configurações';
$_['text_situacoes']              = 'Situações';
$_['text_bradesco']               = 'Bradesco - Boleto Registrado';
$_['text_banco_brasil']           = 'Banco do Brasil - Boleto Registrado';
$_['text_campo']                  = 'Campo:';
$_['text_coluna']                 = 'Coluna na tabela de pedidos';
$_['text_razao']                  = 'Coluna com Razão Social do cliente:';
$_['text_cnpj']                   = 'Coluna com CNPJ do cliente:';
$_['text_cpf']                    = 'Coluna com CPF do cliente:';
$_['text_numero_fatura']          = 'Coluna com número para fatura:';
$_['text_complemento_fatura']     = 'Coluna com complemento para fatura:';
$_['text_botao']                  = 'Cor do botão CONFIRMAR PEDIDO na finalização do pedido';
$_['text_texto']                  = 'Cor do texto:';
$_['text_fundo']                  = 'Cor de fundo:';
$_['text_borda']                  = 'Cor da borda:';
$_['text_sandbox']                = 'Sandbox';
$_['text_producao']               = 'Produção';

// Button
$_['button_save_stay']            = 'Salvar e continuar';
$_['button_save']                 = 'Salvar e sair';

// Tab
$_['tab_geral']                   = 'Configurações';
$_['tab_api']                     = 'API';
$_['tab_situacoes']               = 'Situações';
$_['tab_campos']                  = 'Campos do cliente';
$_['tab_finalizacao']             = 'Finalização';

// Entry
$_['entry_chave']                 = 'Chave da extensão';
$_['entry_total']                 = 'Total mínimo';
$_['entry_geo_zone']              = 'Região geográfica';
$_['entry_status']                = 'Situação';
$_['entry_sort_order']            = 'Posição';
$_['entry_merchantid']            = 'Merchant ID';
$_['entry_merchantkey']           = 'Merchant Key';
$_['entry_ambiente']              = 'Ambiente';
$_['entry_debug']                 = 'Debug';
$_['entry_banco']                 = 'Banco';
$_['entry_vencimento']            = 'Dias para vencimento';
$_['entry_demonstrativo']         = 'Demonstrativo';
$_['entry_instrucoes']            = 'Instruções';
$_['entry_situacao_gerado']       = 'Boleto gerado';
$_['entry_situacao_pendente']     = 'Boleto pendente';
$_['entry_situacao_pago']         = 'Boleto pago';
$_['entry_situacao_cancelado']    = 'Boleto cancelado';
$_['entry_custom_razao_id']       = 'Razão Social';
$_['entry_custom_cnpj_id']        = 'CNPJ';
$_['entry_custom_cpf_id']         = 'CPF';
$_['entry_custom_numero_id']      = 'Número';
$_['entry_custom_complemento_id'] = 'Complemento';
$_['entry_titulo']                = 'Título da extensão';
$_['entry_imagem']                = 'Imagem da extensão';
$_['entry_one_checkout']          = 'Modo One Checkout';
$_['entry_botao_normal']          = 'Cor inicial';
$_['entry_botao_efeito']          = 'Cor com efeito';

// Help
$_['help_chave']                  = 'A chave da extensão é fornecida pelo OpenCart Brasil.';
$_['help_total']                  = 'Valor mínimo que o pedido deve alcançar para que a forma de pagamento por boleto bancário seja habilitada. Deixe em branco se não houver valor mínimo.';
$_['help_status']                 = 'Selecione Habilitado, para oferecer o pagamento por boleto bancário.';
$_['help_merchantid']             = 'É gerado e enviado ao lojista pela Cielo através de e-mail. Você recebe após a confirmação do credenciamento da loja na Cielo. Contém 36 caracteres.';
$_['help_merchantkey']            = 'É gerada e enviada ao lojista pela Cielo através de e-mail. Você recebe após a confirmação do credenciamento da loja na Cielo. Contém 40 caracteres.';
$_['help_ambiente']               = 'Selecione Sandbox, caso deseje apenas testar o funcionamento da extensão na loja. Quando for vender selecione Produção.';
$_['help_debug']                  = 'Selecione Habilitado caso deseje visualizar as informações enviadas pela API da Cielo para a loja. Por padrão deixe Desabilitado.';
$_['help_banco']                  = 'Banco responsável pela emissão do boleto.';
$_['help_vencimento']             = 'Dias que serão somados a data do pedido para gerar a data de vencimento do boleto.';
$_['help_demonstrativo']          = 'Demonstrativo que será impresso no boleto. Esse campo é utilizado para informações genéricas relacionadas ao boleto.';
$_['help_instrucoes']             = 'Instruções que serão impressas no boleto. Esse campo é utilizado para instruir o caixa do banco ao receber o pagamento do boleto.';
$_['help_situacao_gerado']        = 'Selecione a situação para identificar o pedido que está com o boleto gerado.';
$_['help_situacao_pendente']      = 'Selecione a situação para identificar o pedido que está com o boleto pendente.';
$_['help_situacao_pago']          = 'Selecione a situação para identificar o pedido que está com o boleto pago.';
$_['help_situacao_cancelado']     = 'Selecione a situação para identificar o pedido que está com o boleto cancelado.';
$_['help_custom_razao_id']        = 'O campo Razão Social não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta (Texto em uma linha), e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_cnpj_id']         = 'O campo CNPJ não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta (Texto em uma linha), e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_cpf_id']          = 'O campo CPF não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta (Texto em uma linha), e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_numero_id']       = 'O campo Número não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Endereço (Texto em uma linha), e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_complemento_id']  = 'O campo Complemento não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Endereço (Texto em uma linha), e selecione-o para que a extensão funcione corretamente.';
$_['help_campo']                  = 'Caso o campo não seja do tipo personalizado, selecione a opção Coluna na tabela de pedidos.';
$_['help_razao']                  = 'Coluna com a Razão Social do cliente na tabela de pedidos.';
$_['help_cnpj']                   = 'Coluna com o CNPJ do cliente na tabela de pedidos.';
$_['help_cpf']                    = 'Coluna com o CPF do cliente na tabela de pedidos.';
$_['help_numero_fatura']          = 'Coluna com o número do endereço para fatura na tabela de pedidos.';
$_['help_complemento_fatura']     = 'Coluna com o complemento do endereço para fatura na tabela de pedidos.';
$_['help_titulo']                 = 'Título do pagamento por boleto bancário, que será exibido na finalização do pedido.';
$_['help_imagem']                 = 'Caso selecione uma imagem, ela será exibida no lugar do título da extensão.';
$_['help_one_checkout']           = 'Só selecione Sim, se seu checkout for do tipo One Checkout.';
$_['help_botao_normal']           = 'Cor do botão quando o mesmo não estiver pressionado ou não estiver com o mouse sobre ele.';
$_['help_botao_efeito']           = 'Cor do botão quando o mesmo for pressionado ou quando o mouse estiver sobre ele.';

// Error
$_['error_permission']            = 'Atenção: Você não tem permissão para modificar a extensão Cielo API Boleto!';
$_['error_warning']               = 'Atenção: A extensão não foi configurada corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_chave']                 = 'O campo Chave da extensão é obrigatório!';
$_['error_merchantid']            = 'O campo Merchant ID está vazio ou foi preenchido de maneira incorreta!';
$_['error_merchantkey']           = 'O campo Merchant Key está vazio ou foi preenchido de maneira incorreta!';
$_['error_vencimento']            = 'O campo Dias para vencimento é obrigatório!';
$_['error_titulo']                = 'O campo Título da extensão é obrigatório!';