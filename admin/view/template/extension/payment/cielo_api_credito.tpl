<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cielo-api-credito" input type="hidden" id="save_stay" name="save_stay" value="1" data-toggle="tooltip" title="<?php echo $button_save_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-cielo-api-credito" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cielo-api-credito" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-geral" data-toggle="tab"><?php echo $tab_geral; ?></a></li>
            <li><a href="#tab-api" data-toggle="tab"><?php echo $tab_api; ?></a></li>
            <li><a href="#tab-parcelamentos" data-toggle="tab"><?php echo $tab_parcelamentos; ?></a></li>
            <li><a href="#tab-situacoes-pedido" data-toggle="tab"><?php echo $tab_situacoes_pedido; ?></a></li>
            <li><a href="#tab-finalizacao" data-toggle="tab"><?php echo $tab_finalizacao; ?></a></li>
            <li><a href="#tab-campos" data-toggle="tab"><?php echo $tab_campos; ?></a></li>
            <li><a href="#tab-antifraude" data-toggle="tab"><?php echo $tab_antifraude; ?></a></li>
            <li><a href="#tab-clearsale" data-toggle="tab"><?php echo $tab_clearsale; ?></a></li>
            <li><a href="#tab-fcontrol" data-toggle="tab"><?php echo $tab_fcontrol; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-geral">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-chave"><span data-toggle="tooltip" title="<?php echo $help_chave; ?>"><?php echo $entry_chave; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_credito_chave" value="<?php echo $cielo_api_credito_chave; ?>" placeholder="<?php echo $entry_chave; ?>" id="input-chave" class="form-control" />
                  <?php if ($error_chave) { ?>
                  <div class="text-danger"><?php echo $error_chave; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_credito_total" value="<?php echo $cielo_api_credito_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-3">
                  <select name="cielo_api_credito_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $cielo_api_credito_geo_zone_id) { ?>
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
                  <select name="cielo_api_credito_status" id="input-status" class="form-control">
                    <?php if ($cielo_api_credito_status) { ?>
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
                  <input type="text" name="cielo_api_credito_sort_order" value="<?php echo $cielo_api_credito_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-api">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchantid"><span data-toggle="tooltip" title="<?php echo $help_merchantid; ?>"><?php echo $entry_merchantid; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_credito_merchantid" value="<?php echo $cielo_api_credito_merchantid; ?>" placeholder="<?php echo $entry_merchantid; ?>" id="input-merchantid" class="form-control" />
                  <?php if ($error_merchantid) { ?>
                  <div class="text-danger"><?php echo $error_merchantid; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchantkey"><span data-toggle="tooltip" title="<?php echo $help_merchantkey; ?>"><?php echo $entry_merchantkey; ?></span></label>
                <div class="col-sm-5">
                  <input type="text" name="cielo_api_credito_merchantkey" value="<?php echo $cielo_api_credito_merchantkey; ?>" placeholder="<?php echo $entry_merchantkey; ?>" id="input-cheve" class="form-control" />
                  <?php if ($error_merchantkey) { ?>
                  <div class="text-danger"><?php echo $error_merchantkey; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-soft-descriptor"><span data-toggle="tooltip" title="<?php echo $help_soft_descriptor; ?>"><?php echo $entry_soft_descriptor; ?></span></label>
                <div class="col-sm-3">
                  <input type="text" name="cielo_api_credito_soft_descriptor" value="<?php echo $cielo_api_credito_soft_descriptor; ?>" placeholder="<?php echo $entry_soft_descriptor; ?>" id="input-soft-descriptor" class="form-control" />
                  <?php if ($error_soft_descriptor) { ?>
                  <div class="text-danger"><?php echo $error_soft_descriptor; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ambiente"><span data-toggle="tooltip" title="<?php echo $help_ambiente; ?>"><?php echo $entry_ambiente; ?></span></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_ambiente" id="input-ambiente" class="form-control">
                    <?php if ($cielo_api_credito_ambiente) { ?>
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
                <div class="col-sm-2">
                  <select name="cielo_api_credito_debug" id="input-debug" class="form-control">
                    <?php if ($cielo_api_credito_debug) { ?>
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
                <label class="col-sm-2 control-label" for="input-captura"><span data-toggle="tooltip" title="<?php echo $help_captura; ?>"><?php echo $entry_captura; ?></span></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_captura" id="input-captura" class="form-control">
                    <?php if ($cielo_api_credito_captura) { ?>
                    <option value="1" selected="selected"><?php echo $text_automatica; ?></option>
                    <option value="0"><?php echo $text_manual; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_automatica; ?></option>
                    <option value="0" selected="selected"><?php echo $text_manual; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-parcelamentos">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-calculo"><span data-toggle="tooltip" title="<?php echo $help_calculo; ?>"><?php echo $entry_calculo; ?></span></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_calculo" id="input-calculo" class="form-control">
                    <?php if ($cielo_api_credito_calculo) { ?>
                    <option value="1" selected="selected"><?php echo $text_simples; ?></option>
                    <option value="0"><?php echo $text_composto; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_simples; ?></option>
                    <option value="0" selected="selected"><?php echo $text_composto; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-minimo"><span data-toggle="tooltip" title="<?php echo $help_minimo; ?>"><?php echo $entry_minimo; ?></span></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_credito_minimo" value="<?php echo $cielo_api_credito_minimo; ?>" placeholder="<?php echo $entry_minimo; ?>" id="input-minimo" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-desconto"><span data-toggle="tooltip" title="<?php echo $help_desconto; ?>"><?php echo $entry_desconto; ?></span></label>
                <div class="col-sm-2">
                  <input type="text" name="cielo_api_credito_desconto" value="<?php echo $cielo_api_credito_desconto; ?>" placeholder="<?php echo $entry_desconto; ?>" id="input-desconto" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-visa"><span data-toggle="tooltip" title="<?php echo $help_visa; ?>"><?php echo $entry_visa; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_visa" id="input-visa" class="form-control">
                    <?php if ($cielo_api_credito_visa) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_visa_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_visa_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_visa_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_visa_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_visa_juros" value="<?php echo $cielo_api_credito_visa_juros; ?>" placeholder="" id="input-visa-taxa-juros" class="form-control" />
                  <?php if ($error_visa) { ?>
                  <div class="text-danger"><?php echo $error_visa; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mastercard"><span data-toggle="tooltip" title="<?php echo $help_mastercard; ?>"><?php echo $entry_mastercard; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_mastercard" id="input-mastercard" class="form-control">
                    <?php if ($cielo_api_credito_mastercard) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_mastercard_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_mastercard_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_mastercard_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_mastercard_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_mastercard_juros" value="<?php echo $cielo_api_credito_mastercard_juros; ?>" placeholder="" id="input-mastercard-taxa-juros" class="form-control" />
                  <?php if ($error_mastercard) { ?>
                  <div class="text-danger"><?php echo $error_mastercard; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-diners"><span data-toggle="tooltip" title="<?php echo $help_diners; ?>"><?php echo $entry_diners; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_diners" id="input-diners" class="form-control">
                    <?php if ($cielo_api_credito_diners) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_diners_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_diners_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_diners_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_diners_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_diners_juros" value="<?php echo $cielo_api_credito_diners_juros; ?>" placeholder="" id="input-diners-taxa-juros" class="form-control" />
                  <?php if ($error_diners) { ?>
                  <div class="text-danger"><?php echo $error_diners; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-discover"><span data-toggle="tooltip" title="<?php echo $help_discover; ?>"><?php echo $entry_discover; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_discover" id="input-discover" class="form-control">
                    <?php if ($cielo_api_credito_discover) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-elo"><span data-toggle="tooltip" title="<?php echo $help_elo; ?>"><?php echo $entry_elo; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_elo" id="input-elo" class="form-control">
                    <?php if ($cielo_api_credito_elo) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_elo_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_elo_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_elo_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_elo_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_elo_juros" value="<?php echo $cielo_api_credito_elo_juros; ?>" placeholder="" id="input-elo-taxa-juros" class="form-control" />
                  <?php if ($error_elo) { ?>
                  <div class="text-danger"><?php echo $error_elo; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-amex"><span data-toggle="tooltip" title="<?php echo $help_amex; ?>"><?php echo $entry_amex; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_amex" id="input-amex" class="form-control">
                    <?php if ($cielo_api_credito_amex) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_amex_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_amex_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_amex_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_amex_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_amex_juros" value="<?php echo $cielo_api_credito_amex_juros; ?>" placeholder="" id="input-amex-taxa-juros" class="form-control" />
                  <?php if ($error_amex) { ?>
                  <div class="text-danger"><?php echo $error_amex; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-hipercard"><span data-toggle="tooltip" title="<?php echo $help_hipercard; ?>"><?php echo $entry_hipercard; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_hipercard" id="input-hipercard" class="form-control">
                    <?php if ($cielo_api_credito_hipercard) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_hipercard_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_hipercard_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_hipercard_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_hipercard_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_hipercard_juros" value="<?php echo $cielo_api_credito_hipercard_juros; ?>" placeholder="" id="input-hipercard-taxa-juros" class="form-control" />
                  <?php if ($error_hipercard) { ?>
                  <div class="text-danger"><?php echo $error_hipercard; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-jcb"><span data-toggle="tooltip" title="<?php echo $help_jcb; ?>"><?php echo $entry_jcb; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_jcb" id="input-jcb" class="form-control">
                    <?php if ($cielo_api_credito_jcb) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_jcb_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_jcb_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_jcb_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_jcb_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_jcb_juros" value="<?php echo $cielo_api_credito_jcb_juros; ?>" placeholder="" id="input-jcb-taxa-juros" class="form-control" />
                  <?php if ($error_jcb) { ?>
                  <div class="text-danger"><?php echo $error_jcb; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-aura"><span data-toggle="tooltip" title="<?php echo $help_aura; ?>"><?php echo $entry_aura; ?></span></label>
                <div class="col-sm-2">
                  <label><?php echo $text_ativar; ?></label>
                  <select name="cielo_api_credito_aura" id="input-aura" class="form-control">
                    <?php if ($cielo_api_credito_aura) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_parcelas; ?></label>
                  <select name="cielo_api_credito_aura_parcelas" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_aura_parcelas) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_sem_juros; ?></label>
                  <select name="cielo_api_credito_aura_sem_juros" class="form-control">
                    <?php foreach ($parcelas as $parcela) { ?>
                    <?php if ($parcela == $cielo_api_credito_aura_sem_juros) { ?>
                    <option value="<?php echo $parcela; ?>" selected="selected"><?php echo $parcela; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $parcela; ?>"><?php echo $parcela; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label><?php echo $text_juros; ?></label>
                  <input type="text" name="cielo_api_credito_aura_juros" value="<?php echo $cielo_api_credito_aura_juros; ?>" placeholder="" id="input-aura-taxa-juros" class="form-control" />
                  <?php if ($error_aura) { ?>
                  <div class="text-danger"><?php echo $error_aura; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-situacoes-pedido">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_pendente; ?>"><?php echo $entry_situacao_pendente; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_credito_situacao_pendente_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_credito_situacao_pendente_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_autorizada; ?>"><?php echo $entry_situacao_autorizada; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_credito_situacao_autorizada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_credito_situacao_autorizada_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_nao_autorizada; ?>"><?php echo $entry_situacao_nao_autorizada; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_credito_situacao_nao_autorizada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_credito_situacao_nao_autorizada_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_situacao_capturada; ?>"><?php echo $entry_situacao_capturada; ?></span></label>
                <div class="col-sm-3">
                  <select name="cielo_api_credito_situacao_capturada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_credito_situacao_capturada_id) { ?>
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
                <div class="col-sm-3">
                  <select name="cielo_api_credito_situacao_cancelada_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $cielo_api_credito_situacao_cancelada_id) { ?>
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
                  <input type="text" name="cielo_api_credito_titulo" value="<?php echo $cielo_api_credito_titulo; ?>" placeholder="<?php echo $entry_titulo; ?>" id="input-titulo" class="form-control" />
                  <?php if ($error_titulo) { ?>
                  <div class="text-danger"><?php echo $error_titulo; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><span data-toggle="tooltip" title="<?php echo $help_imagem; ?>"><?php echo $entry_imagem; ?></span></label>
                <div class="col-sm-9"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a>
                  <input type="hidden" name="cielo_api_credito_imagem" value="<?php echo $cielo_api_credito_imagem; ?>" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-exibir-juros"><span data-toggle="tooltip" title="<?php echo $help_exibir_juros; ?>"><?php echo $entry_exibir_juros; ?></span></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_exibir_juros" id="input-exibir-juros" class="form-control">
                    <?php if ($cielo_api_credito_exibir_juros) { ?>
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
                    <div id="cor_normal_texto" class="input-group colorpicker-component"><input type="text" name="cielo_api_credito_cor_normal_texto" value="<?php echo $cielo_api_credito_cor_normal_texto; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_fundo; ?></label>
                    <div id="cor_normal_fundo" class="input-group colorpicker-component"><input type="text" name="cielo_api_credito_cor_normal_fundo" value="<?php echo $cielo_api_credito_cor_normal_fundo; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_borda; ?></label>
                    <div id="cor_normal_borda" class="input-group colorpicker-component"><input type="text" name="cielo_api_credito_cor_normal_borda" value="<?php echo $cielo_api_credito_cor_normal_borda; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-botao-efeito"><span data-toggle="tooltip" title="<?php echo $help_botao_efeito; ?>"><?php echo $entry_botao_efeito; ?></span></label>
                  <div class="col-sm-2">
                    <label><?php echo $text_texto; ?></label>
                    <div id="cor_efeito_texto" class="input-group colorpicker-component"><input type="text" name="cielo_api_credito_cor_efeito_texto" value="<?php echo $cielo_api_credito_cor_efeito_texto; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_fundo; ?></label>
                    <div id="cor_efeito_fundo" class="input-group colorpicker-component"><input type="text" name="cielo_api_credito_cor_efeito_fundo" value="<?php echo $cielo_api_credito_cor_efeito_fundo; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                  <div class="col-sm-2">
                    <label><?php echo $text_borda; ?></label>
                    <div id="cor_efeito_borda" class="input-group colorpicker-component"><input type="text" name="cielo_api_credito_cor_efeito_borda" value="<?php echo $cielo_api_credito_cor_efeito_borda; ?>" class="form-control" /><span class="input-group-addon"><i></i></span></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_recaptcha; ?></legend>
                <span><?php echo $text_recaptcha_registrar; ?></span>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-recaptcha-site-key"><span data-toggle="tooltip" title="<?php echo $help_recaptcha_site_key; ?>"><?php echo $entry_recaptcha_site_key; ?></span></label>
                  <div class="col-sm-5">
                    <input type="text" name="cielo_api_credito_recaptcha_site_key" value="<?php echo $cielo_api_credito_recaptcha_site_key; ?>" placeholder="<?php echo $entry_recaptcha_site_key; ?>" id="input-recaptcha-site-key" class="form-control" />
                    <?php if ($error_recaptcha_site_key) { ?>
                    <div class="text-danger"><?php echo $error_recaptcha_site_key; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-recaptcha-secret-key"><span data-toggle="tooltip" title="<?php echo $help_recaptcha_secret_key; ?>"><?php echo $entry_recaptcha_secret_key; ?></span></label>
                  <div class="col-sm-5">
                    <input type="text" name="cielo_api_credito_recaptcha_secret_key" value="<?php echo $cielo_api_credito_recaptcha_secret_key; ?>" placeholder="<?php echo $entry_recaptcha_secret_key; ?>" id="input-recaptcha-secret-key" class="form-control" />
                    <?php if ($error_recaptcha_secret_key) { ?>
                    <div class="text-danger"><?php echo $error_recaptcha_secret_key; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-recaptcha-status"><span data-toggle="tooltip" title="<?php echo $help_recaptcha_status; ?>"><?php echo $entry_recaptcha_status; ?></span></label>
                  <div class="col-sm-2">
                    <select name="cielo_api_credito_recaptcha_status" id="input-recaptcha-status" class="form-control">
                      <?php if ($cielo_api_credito_recaptcha_status) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-campos">
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_razao_id; ?>"><?php echo $entry_custom_razao_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_credito_custom_razao_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_credito_custom_razao_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_credito_custom_razao_id) { ?>
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
                  <select name="cielo_api_credito_razao_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_razao_coluna) { ?>
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
                  <select name="cielo_api_credito_custom_cnpj_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_credito_custom_cnpj_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_credito_custom_cnpj_id) { ?>
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
                  <select name="cielo_api_credito_cnpj_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_cnpj_coluna) { ?>
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
                  <select name="cielo_api_credito_custom_cpf_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_credito_custom_cpf_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_credito_custom_cpf_id) { ?>
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
                  <select name="cielo_api_credito_cpf_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_cpf_coluna) { ?>
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
                  <select name="cielo_api_credito_custom_numero_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_credito_custom_numero_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'address') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_credito_custom_numero_id) { ?>
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
                  <select name="cielo_api_credito_numero_fatura_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_numero_fatura_coluna) { ?>
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
                <div class="col-sm-3" id="numero_entrega_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_numero_entrega; ?>"><?php echo $text_numero_entrega; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_credito_numero_entrega_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_numero_entrega_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_numero_entrega) { ?>
                  <div class="text-danger"><?php echo $error_numero_entrega; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_custom_complemento_id; ?>"><?php echo $entry_custom_complemento_id; ?></span></label>
                <div class="col-sm-4">
                  <label><span data-toggle="tooltip" title="<?php echo $help_campo; ?>"><?php echo $text_campo; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_credito_custom_complemento_id" class="form-control">
                    <option value=""><?php echo $text_none; ?></option>
                    <?php if ($cielo_api_credito_custom_complemento_id == 'N') { ?>
                    <option value="N" selected="selected"><?php echo $text_coluna; ?></option>
                    <?php } else { ?>
                    <option value="N"><?php echo $text_coluna; ?></option>
                    <?php } ?>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'address') { ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <?php if ($custom_field['custom_field_id'] == $cielo_api_credito_custom_complemento_id) { ?>
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
                  <select name="cielo_api_credito_complemento_fatura_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_complemento_fatura_coluna) { ?>
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
                <div class="col-sm-3" id="complemento_entrega_coluna">
                  <label><span data-toggle="tooltip" title="<?php echo $help_complemento_entrega; ?>"><?php echo $text_complemento_entrega; ?> <i class="fa fa-question-circle" aria-hidden="true"></i></span></label>
                  <select name="cielo_api_credito_complemento_entrega_coluna" class="form-control">
                    <option value=""></option>
                    <?php foreach ($columns as $column) { ?>
                    <?php if ($column['Field'] == $cielo_api_credito_complemento_entrega_coluna) { ?>
                    <option value="<?php echo $column['Field']; ?>" selected="selected"><?php echo $column['Field']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $column['Field']; ?>"><?php echo $column['Field']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_complemento_entrega) { ?>
                  <div class="text-danger"><?php echo $error_complemento_entrega; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-antifraude">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-returnsaccepted"><?php echo $entry_antifraude_returnsaccepted; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_antifraude_returnsaccepted" id="input-antifraude-returnsaccepted" class="form-control">
                    <?php if ($cielo_api_credito_antifraude_returnsaccepted) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-giftcategory"><?php echo $entry_antifraude_giftcategory; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_giftcategory" id="input-antifraude-giftcategory" class="form-control">
                    <?php foreach ($giftcategory as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_giftcategory == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-hosthedge"><?php echo $entry_antifraude_hosthedge; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_hosthedge" id="input-antifraude-hosthedge" class="form-control">
                    <?php foreach ($hosthedge as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_hosthedge == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-nonsensicalhedge"><?php echo $entry_antifraude_nonsensicalhedge; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_nonsensicalhedge" id="input-antifraude-nonsensicalhedge" class="form-control">
                    <?php foreach ($nonsensicalhedge as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_nonsensicalhedge == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-obscenitieshedge"><?php echo $entry_antifraude_obscenitieshedge; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_obscenitieshedge" id="input-antifraude-obscenitieshedge" class="form-control">
                    <?php foreach ($obscenitieshedge as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_obscenitieshedge == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-risk"><?php echo $entry_antifraude_risk; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_risk" id="input-antifraude-risk" class="form-control">
                    <?php foreach ($risk as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_risk == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-timehedge"><?php echo $entry_antifraude_timehedge; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_timehedge" id="input-antifraude-timehedge" class="form-control">
                    <?php foreach ($timehedge as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_timehedge == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-type"><?php echo $entry_antifraude_type; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_type" id="input-antifraude-type" class="form-control">
                    <?php foreach ($type as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_type == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-velocityhedge"><?php echo $entry_antifraude_velocityhedge; ?></label>
                <div class="col-sm-9">
                  <select name="cielo_api_credito_antifraude_velocityhedge" id="input-antifraude-velocityhedge" class="form-control">
                    <?php foreach ($velocityhedge as $chave => $valor) { ?>
                    <?php if ($cielo_api_credito_antifraude_velocityhedge == $chave) { ?>
                    <option value="<?php echo $chave; ?>" selected="selected"><?php echo $valor; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $chave; ?>"><?php echo $valor; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="input-antifraude-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_antifraude_status" id="input-antifraude-status" class="form-control">
                    <?php if ($cielo_api_credito_antifraude_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-clearsale">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-clearsale-codigo"><span data-toggle="tooltip" title="<?php echo $help_clearsale_codigo; ?>"><?php echo $entry_clearsale_codigo; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_credito_clearsale_codigo" value="<?php echo $cielo_api_credito_clearsale_codigo; ?>" placeholder="<?php echo $entry_clearsale_codigo; ?>" id="input-clearsale-codigo" class="form-control" />
                  <?php if ($error_clearsale_codigo) { ?>
                  <div class="text-danger"><?php echo $error_clearsale_codigo; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-clearsale-ambiente"><?php echo $entry_clearsale_ambiente; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_clearsale_ambiente" id="input-clearsale-ambiente" class="form-control">
                    <?php if ($cielo_api_credito_clearsale_ambiente) { ?>
                    <option value="1" selected="selected"><?php echo $text_producao; ?></option>
                    <option value="0"><?php echo $text_homologacao; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_producao; ?></option>
                    <option value="0" selected="selected"><?php echo $text_homologacao; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-clearsale-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_clearsale_status" id="input-clearsale-status" class="form-control">
                    <?php if ($cielo_api_credito_clearsale_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-fcontrol">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-fcontrol-login"><span data-toggle="tooltip" title="<?php echo $help_fcontrol_login; ?>"><?php echo $entry_fcontrol_login; ?></span></label>
                <div class="col-sm-3">
                  <input type="text" name="cielo_api_credito_fcontrol_login" value="<?php echo $cielo_api_credito_fcontrol_login; ?>" placeholder="<?php echo $entry_fcontrol_login; ?>" id="input-fcontrol-login" class="form-control" />
                  <?php if ($error_fcontrol_login) { ?>
                  <div class="text-danger"><?php echo $error_fcontrol_login; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-fcontrol-senha"><span data-toggle="tooltip" title="<?php echo $help_fcontrol_senha; ?>"><?php echo $entry_fcontrol_senha; ?></span></label>
                <div class="col-sm-3">
                  <input type="text" name="cielo_api_credito_fcontrol_senha" value="<?php echo $cielo_api_credito_fcontrol_senha; ?>" placeholder="<?php echo $entry_fcontrol_senha; ?>" id="input-fcontrol-senha" class="form-control" />
                  <?php if ($error_fcontrol_senha) { ?>
                  <div class="text-danger"><?php echo $error_fcontrol_senha; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-fcontrol-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_credito_fcontrol_status" id="input-fcontrol-status" class="form-control">
                    <?php if ($cielo_api_credito_fcontrol_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
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
  $('#numero_entrega_coluna').hide();
  $('#complemento_fatura_coluna').hide();
  $('#complemento_entrega_coluna').hide();

  $('select[name=\'cielo_api_credito_custom_razao_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#razao_coluna').show(); }else{ $('#razao_coluna').hide(); }
  });
  $('select[name=\'cielo_api_credito_custom_cnpj_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#cnpj_coluna').show(); }else{ $('#cnpj_coluna').hide(); }
  });
  $('select[name=\'cielo_api_credito_custom_cpf_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#cpf_coluna').show(); }else{ $('#cpf_coluna').hide(); }
  });
  $('select[name=\'cielo_api_credito_custom_numero_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#numero_fatura_coluna').show(); }else{ $('#numero_fatura_coluna').hide(); }
    if($(this).val() == 'N'){ $('#numero_entrega_coluna').show(); }else{ $('#numero_entrega_coluna').hide(); }
  });
  $('select[name=\'cielo_api_credito_custom_complemento_id\']').on('change', function() {
    if($(this).val() == 'N'){ $('#complemento_fatura_coluna').show(); }else{ $('#complemento_fatura_coluna').hide(); }
    if($(this).val() == 'N'){ $('#complemento_entrega_coluna').show(); }else{ $('#complemento_entrega_coluna').hide(); }
  });

  $('select[name=\'cielo_api_credito_custom_razao_id\']').trigger('change');
  $('select[name=\'cielo_api_credito_custom_cnpj_id\']').trigger('change');
  $('select[name=\'cielo_api_credito_custom_cpf_id\']').trigger('change');
  $('select[name=\'cielo_api_credito_custom_numero_id\']').trigger('change');
  $('select[name=\'cielo_api_credito_custom_complemento_id\']').trigger('change');

  $('#cor_normal_texto').colorpicker();
  $('#cor_normal_fundo').colorpicker();
  $('#cor_normal_borda').colorpicker();
  $('#cor_efeito_texto').colorpicker();
  $('#cor_efeito_fundo').colorpicker();
  $('#cor_efeito_borda').colorpicker();
//--></script>
<?php echo $footer; ?>