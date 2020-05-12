<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cielo-api-transferencia" input type="hidden" id="save_stay" name="save_stay" value="1" data-toggle="tooltip" title="<?php echo $button_save_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-cielo-api-transferencia" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cielo-api-transferencia" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-geral" data-toggle="tab"><?php echo $tab_geral; ?></a></li>
            <li><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
            <li><a href="#tab-situacoes" data-toggle="tab"><?php echo $tab_situacoes; ?></a></li>
            <li><a href="#tab-finalizacao" data-toggle="tab"><?php echo $tab_finalizacao; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-geral">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-chave"><span data-toggle="tooltip" title="<?php echo $help_chave; ?>"><?php echo $entry_chave; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_transferencia_chave" value="<?php echo $cielo_api_transferencia_chave; ?>" placeholder="<?php echo $entry_chave; ?>" id="input-chave" class="form-control" />
                  <?php if ($error_chave) { ?>
                  <div class="text-danger"><?php echo $error_chave; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_transferencia_total" value="<?php echo $cielo_api_transferencia_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-4">
                  <select name="cielo_api_transferencia_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $cielo_api_transferencia_geo_zone_id) { ?>
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
                  <select name="cielo_api_transferencia_status" id="input-status" class="form-control">
                    <?php if ($cielo_api_transferencia_status) { ?>
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
                  <input type="text" name="cielo_api_transferencia_sort_order" value="<?php echo $cielo_api_transferencia_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-api">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchantid"><span data-toggle="tooltip" title="<?php echo $help_merchantid; ?>"><?php echo $entry_merchantid; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_transferencia_merchantid" value="<?php echo $cielo_api_transferencia_merchantid; ?>" placeholder="<?php echo $entry_merchantid; ?>" id="input-merchantid" class="form-control" />
                  <?php if ($error_merchantid) { ?>
                  <div class="text-danger"><?php echo $error_merchantid; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchantkey"><span data-toggle="tooltip" title="<?php echo $help_merchantkey; ?>"><?php echo $entry_merchantkey; ?></span></label>
                <div class="col-sm-5">
                  <input type="text" name="cielo_api_transferencia_merchantkey" value="<?php echo $cielo_api_transferencia_merchantkey; ?>" placeholder="<?php echo $entry_merchantkey; ?>" id="input-cheve" class="form-control" />
                  <?php if ($error_merchantkey) { ?>
                  <div class="text-danger"><?php echo $error_merchantkey; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ambiente"><span data-toggle="tooltip" title="<?php echo $help_ambiente; ?>"><?php echo $entry_ambiente; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_transferencia_ambiente" id="input-ambiente" class="form-control">
                    <?php if ($cielo_api_transferencia_ambiente) { ?>
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
                  <select name="cielo_api_transferencia_debug" id="input-debug" class="form-control">
                    <?php if ($cielo_api_transferencia_debug) { ?>
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
                  <select name="cielo_api_transferencia_banco" id="input-banco" class="form-control">
                    <?php foreach ($bancos as $key => $value) { ?>
                    <?php if ($key == $cielo_api_transferencia_banco) { ?>
                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-situacoes">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_gerada; ?>"><?php echo $entry_situacao_gerada; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_transferencia_situacao_gerada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_transferencia_situacao_gerada_id) { ?>
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
                  <select name="cielo_api_transferencia_situacao_pendente_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_transferencia_situacao_pendente_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_paga; ?>"><?php echo $entry_situacao_paga; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_transferencia_situacao_paga_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_transferencia_situacao_paga_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_negada; ?>"><?php echo $entry_situacao_negada; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_transferencia_situacao_negada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_transferencia_situacao_negada_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_cancelada; ?>"><?php echo $entry_situacao_cancelada; ?></span></label>
                <div class="col-sm-4">
                  <select name="cielo_api_transferencia_situacao_cancelada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_transferencia_situacao_cancelada_id) { ?>
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
                  <input type="text" name="cielo_api_transferencia_titulo" value="<?php echo $cielo_api_transferencia_titulo; ?>" placeholder="<?php echo $entry_titulo; ?>" id="input-titulo" class="form-control" />
                  <?php if ($error_titulo) { ?>
                  <div class="text-danger"><?php echo $error_titulo; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $help_imagem; ?>"><?php echo $entry_imagem; ?></span></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a>
                  <input type="hidden" name="cielo_api_transferencia_imagem" value="<?php echo $cielo_api_transferencia_imagem; ?>" id="input-image" />
                </div>
              </div>
              <fieldset>
                <legend><?php echo $text_botao; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-botao-normal"><span data-toggle="tooltip" title="<?php echo $help_botao_normal; ?>"><?php echo $entry_botao_normal; ?></span></label>
                  <div class="col-sm-2">
                    <label><?php echo $text_texto; ?></label>
                    <div id="cor_normal_texto" class="input-group colorpicker-component"><input type="text" name="cielo_api_transferencia_cor_normal_texto" value="<?php echo $cielo_api_transferencia_cor_normal_texto; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_fundo; ?></label>
                    <div id="cor_normal_fundo" class="input-group colorpicker-component"><input type="text" name="cielo_api_transferencia_cor_normal_fundo" value="<?php echo $cielo_api_transferencia_cor_normal_fundo; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_borda; ?></label>
                    <div id="cor_normal_borda" class="input-group colorpicker-component"><input type="text" name="cielo_api_transferencia_cor_normal_borda" value="<?php echo $cielo_api_transferencia_cor_normal_borda; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-botao-efeito"><span data-toggle="tooltip" title="<?php echo $help_botao_efeito; ?>"><?php echo $entry_botao_efeito; ?></span></label>
                  <div class="col-sm-2">
                    <label><?php echo $text_texto; ?></label>
                    <div id="cor_efeito_texto" class="input-group colorpicker-component"><input type="text" name="cielo_api_transferencia_cor_efeito_texto" value="<?php echo $cielo_api_transferencia_cor_efeito_texto; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_fundo; ?></label>
                    <div id="cor_efeito_fundo" class="input-group colorpicker-component"><input type="text" name="cielo_api_transferencia_cor_efeito_fundo" value="<?php echo $cielo_api_transferencia_cor_efeito_fundo; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_borda; ?></label>
                    <div id="cor_efeito_borda" class="input-group colorpicker-component"><input type="text" name="cielo_api_transferencia_cor_efeito_borda" value="<?php echo $cielo_api_transferencia_cor_efeito_borda; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
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
  $('#cor_normal_texto').colorpicker();
  $('#cor_normal_fundo').colorpicker();
  $('#cor_normal_borda').colorpicker();
  $('#cor_efeito_texto').colorpicker();
  $('#cor_efeito_fundo').colorpicker();
  $('#cor_efeito_borda').colorpicker();
//--></script>
<?php echo $footer; ?>