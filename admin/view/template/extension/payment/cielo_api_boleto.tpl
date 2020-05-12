<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cielo-api-boleto" input type="hidden" id="save_stay" name="save_stay" value="1" data-toggle="tooltip" title="<?php echo $button_save_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-cielo-api-boleto" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1> <span class="badge"><?php echo $versao; ?></span>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cielo-api-boleto" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-geral" data-toggle="tab"><?php echo $tab_geral; ?></a></li>
            <li><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
            <li><a href="#tab-situacoes" data-toggle="tab"><?php echo $tab_situacoes; ?></a></li>
            <li><a href="#tab-campos" data-toggle="tab"><?php echo $tab_campos; ?></a></li>
            <li><a href="#tab-finalizacao" data-toggle="tab"><?php echo $tab_finalizacao; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-geral">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-chave"><span data-toggle="tooltip" title="<?php echo $help_chave; ?>"><?php echo $entry_chave; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_boleto_chave" value="<?php echo $cielo_api_boleto_chave; ?>" placeholder="<?php echo $entry_chave; ?>" id="input-chave" class="form-control" />
                  <?php if ($error_chave) { ?>
                  <div class="text-danger"><?php echo $error_chave; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_boleto_total" value="<?php echo $cielo_api_boleto_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-4">
                  <select name="cielo_api_boleto_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $cielo_api_boleto_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_boleto_status" id="input-status" class="form-control">
                    <?php if ($cielo_api_boleto_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_boleto_sort_order" value="<?php echo $cielo_api_boleto_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-api">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchantid"><span data-toggle="tooltip" title="<?php echo $help_merchantid; ?>"><?php echo $entry_merchantid; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_boleto_merchantid" value="<?php echo $cielo_api_boleto_merchantid; ?>" placeholder="<?php echo $entry_merchantid; ?>" id="input-merchantid" class="form-control" />
                  <?php if ($error_merchantid) { ?>
                  <div class="text-danger"><?php echo $error_merchantid; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchantkey"><span data-toggle="tooltip" title="<?php echo $help_merchantkey; ?>"><?php echo $entry_merchantkey; ?></span></label>
                <div class="col-sm-5">
                  <input type="text" name="cielo_api_boleto_merchantkey" value="<?php echo $cielo_api_boleto_merchantkey; ?>" placeholder="<?php echo $entry_merchantkey; ?>" id="input-cheve" class="form-control" />
                  <?php if ($error_merchantkey) { ?>
                  <div class="text-danger"><?php echo $error_merchantkey; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ambiente"><span data-toggle="tooltip" title="<?php echo $help_ambiente; ?>"><?php echo $entry_ambiente; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_boleto_ambiente" id="input-ambiente" class="form-control">
                    <?php if ($cielo_api_boleto_ambiente) { ?>
                    <option value="1" selected="selected"><?php echo $text_sandbox; ?></option>
                    <option value="0"><?php echo $text_producao; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_sandbox; ?></option>
                    <option value="0" selected="selected"><?php echo $text_producao; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-debug"><span data-toggle="tooltip" title="<?php echo $help_debug; ?>"><?php echo $entry_debug; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_boleto_debug" id="input-debug" class="form-control">
                    <?php if ($cielo_api_boleto_debug) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-banco"><span data-toggle="tooltip" title="<?php echo $help_banco; ?>"><?php echo $entry_banco; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_boleto_banco" id="input-banco" class="form-control">
                    <?php foreach ($bancos as $key => $value) { ?>
                    <?php if ($key == $cielo_api_boleto_banco) { ?>
                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-vencimento"><span data-toggle="tooltip" title="<?php echo $help_vencimento; ?>"><?php echo $entry_vencimento; ?></span></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_boleto_vencimento" value="<?php echo $cielo_api_boleto_vencimento; ?>" placeholder="<?php echo $entry_vencimento; ?>" id="input-vencimento" class="form-control" />
                  <?php if ($error_vencimento) { ?>
                  <div class="text-danger"><?php echo $error_vencimento; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-demonstrativo"><span data-toggle="tooltip" title="<?php echo $help_demonstrativo; ?>"><?php echo $entry_demonstrativo; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="cielo_api_boleto_demonstrativo" value="<?php echo $cielo_api_boleto_demonstrativo; ?>" placeholder="<?php echo $entry_demonstrativo; ?>" id="input-demonstrativo" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-instrucoes"><span data-toggle="tooltip" title="<?php echo $help_instrucoes; ?>"><?php echo $entry_instrucoes; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="cielo_api_boleto_instrucoes" value="<?php echo $cielo_api_boleto_instrucoes; ?>" placeholder="<?php echo $entry_instrucoes; ?>" id="input-instrucoes" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-campos">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_razao_id; ?>"><?php echo $entry_custom_razao_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_custom_razao_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_boleto_custom_razao_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_boleto_custom_razao_id) { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>" selected="selected"><?php echo $custom_field['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-3" id="razao_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_razao; ?>"><?php echo $text_razao; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_razao_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_boleto_razao_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_razao) { ?>
                  <div class="text-danger"><?php echo $error_razao; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_cnpj_id; ?>"><?php echo $entry_custom_cnpj_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_custom_cnpj_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_boleto_custom_cnpj_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_boleto_custom_cnpj_id) { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>" selected="selected"><?php echo $custom_field['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-3" id="cnpj_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_cnpj; ?>"><?php echo $text_cnpj; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_cnpj_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_boleto_cnpj_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_cnpj) { ?>
                  <div class="text-danger"><?php echo $error_cnpj; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_cpf_id; ?>"><?php echo $entry_custom_cpf_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_custom_cpf_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_boleto_custom_cpf_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_boleto_custom_cpf_id) { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>" selected="selected"><?php echo $custom_field['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-3" id="cpf_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_cpf; ?>"><?php echo $text_cpf; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_cpf_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_boleto_cpf_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_cpf) { ?>
                  <div class="text-danger"><?php echo $error_cpf; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_numero_id; ?>"><?php echo $entry_custom_numero_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_custom_numero_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_boleto_custom_numero_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'address') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_boleto_custom_numero_id) { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>" selected="selected"><?php echo $custom_field['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-3" id="numero_fatura_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_numero_fatura; ?>"><?php echo $text_numero_fatura; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_numero_fatura_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_boleto_numero_fatura_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_numero_fatura) { ?>
                  <div class="text-danger"><?php echo $error_numero_fatura; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_complemento_id; ?>"><?php echo $entry_custom_complemento_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_custom_complemento_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_boleto_custom_complemento_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'address') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_boleto_custom_complemento_id) { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>" selected="selected"><?php echo $custom_field['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-3" id="complemento_fatura_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_complemento_fatura; ?>"><?php echo $text_complemento_fatura; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_boleto_complemento_fatura_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_boleto_complemento_fatura_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_complemento_fatura) { ?>
                  <div class="text-danger"><?php echo $error_complemento_fatura; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-situacoes">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_gerado; ?>"><?php echo $entry_situacao_gerado; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_boleto_situacao_gerado_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_boleto_situacao_gerado_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_pendente; ?>"><?php echo $entry_situacao_pendente; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_boleto_situacao_pendente_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_boleto_situacao_pendente_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_pago; ?>"><?php echo $entry_situacao_pago; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_boleto_situacao_pago_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_boleto_situacao_pago_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_cancelado; ?>"><?php echo $entry_situacao_cancelado; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_boleto_situacao_cancelado_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_boleto_situacao_cancelado_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-finalizacao">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-titulo"><span data-toggle="tooltip" title="<?php echo $help_titulo; ?>"><?php echo $entry_titulo; ?></span></label>
                <div class="col-sm-3">
                  <input type="text" name="cielo_api_boleto_titulo" value="<?php echo $cielo_api_boleto_titulo; ?>" placeholder="<?php echo $entry_titulo; ?>" id="input-titulo" class="form-control" />
                  <?php if ($error_titulo) { ?>
                  <div class="text-danger"><?php echo $error_titulo; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $help_imagem; ?>"><?php echo $entry_imagem; ?></span></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a>
                  <input type="hidden" name="cielo_api_boleto_imagem" value="<?php echo $cielo_api_boleto_imagem; ?>" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-one-checkout"><span data-toggle="tooltip" title="<?php echo $help_one_checkout; ?>"><?php echo $entry_one_checkout; ?></span></label>
                <div class="col-sm-2">
                  <select name="cielo_api_boleto_one_checkout" id="input-one-checkout" class="form-control">
                    <?php if ($cielo_api_boleto_one_checkout) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <fieldset>
                <legend><?php echo $text_botao; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-botao-normal"><span data-toggle="tooltip" title="<?php echo $help_botao_normal; ?>"><?php echo $entry_botao_normal; ?></span></label>
                  <div class="col-sm-2">
                    <label><?php echo $text_texto; ?></label>
                    <div id="cor_normal_texto" class="input-group colorpicker-component"><input type="text" name="cielo_api_boleto_cor_normal_texto" value="<?php echo $cielo_api_boleto_cor_normal_texto; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_fundo; ?></label>
                    <div id="cor_normal_fundo" class="input-group colorpicker-component"><input type="text" name="cielo_api_boleto_cor_normal_fundo" value="<?php echo $cielo_api_boleto_cor_normal_fundo; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_borda; ?></label>
                    <div id="cor_normal_borda" class="input-group colorpicker-component"><input type="text" name="cielo_api_boleto_cor_normal_borda" value="<?php echo $cielo_api_boleto_cor_normal_borda; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-botao-efeito"><span data-toggle="tooltip" title="<?php echo $help_botao_efeito; ?>"><?php echo $entry_botao_efeito; ?></span></label>
                  <div class="col-sm-2">
                    <label><?php echo $text_texto; ?></label>
                    <div id="cor_efeito_texto" class="input-group colorpicker-component"><input type="text" name="cielo_api_boleto_cor_efeito_texto" value="<?php echo $cielo_api_boleto_cor_efeito_texto; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_fundo; ?></label>
                    <div id="cor_efeito_fundo" class="input-group colorpicker-component"><input type="text" name="cielo_api_boleto_cor_efeito_fundo" value="<?php echo $cielo_api_boleto_cor_efeito_fundo; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_borda; ?></label>
                    <div id="cor_efeito_borda" class="input-group colorpicker-component"><input type="text" name="cielo_api_boleto_cor_efeito_borda" value="<?php echo $cielo_api_boleto_cor_efeito_borda; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  $('#razao_coluna').hide();
  $('#cnpj_coluna').hide();
  $('#cpf_coluna').hide();
  $('#numero_fatura_coluna').hide();
  $('#complemento_fatura_coluna').hide();

  $('select[name=\'cielo_api_boleto_custom_razao_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#razao_coluna').show(); }else{ $('#razao_coluna').hide(); }
  });
  $('select[name=\'cielo_api_boleto_custom_cnpj_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#cnpj_coluna').show(); }else{ $('#cnpj_coluna').hide(); }
  });
  $('select[name=\'cielo_api_boleto_custom_cpf_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#cpf_coluna').show(); }else{ $('#cpf_coluna').hide(); }
  });
  $('select[name=\'cielo_api_boleto_custom_numero_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#numero_fatura_coluna').show(); }else{ $('#numero_fatura_coluna').hide(); }
  });
  $('select[name=\'cielo_api_boleto_custom_complemento_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#complemento_fatura_coluna').show(); }else{ $('#complemento_fatura_coluna').hide(); }
  });

  $('select[name=\'cielo_api_boleto_custom_razao_id\']').trigger('change');
  $('select[name=\'cielo_api_boleto_custom_cnpj_id\']').trigger('change');
  $('select[name=\'cielo_api_boleto_custom_cpf_id\']').trigger('change');
  $('select[name=\'cielo_api_boleto_custom_numero_id\']').trigger('change');
  $('select[name=\'cielo_api_boleto_custom_complemento_id\']').trigger('change');

  $('#cor_normal_texto').colorpicker();
  $('#cor_normal_fundo').colorpicker();
  $('#cor_normal_borda').colorpicker();
  $('#cor_efeito_texto').colorpicker();
  $('#cor_efeito_fundo').colorpicker();
  $('#cor_efeito_borda').colorpicker();
//--></script>
<?php echo $footer; ?>