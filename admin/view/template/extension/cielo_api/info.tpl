<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="" data-toggle="tooltip" title="" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div id="progress"></div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-details" data-toggle="tab"><?php echo $tab_details; ?></a></li>
          <li><a href="#tab-json" data-toggle="tab"><?php echo $tab_json; ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-details">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered">
                  <tr>
                    <td><?php echo $entry_order_id; ?></td>
                    <td><a href="<?php echo $view_order; ?>"><?php echo $order_id; ?></a></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_date_added; ?></td>
                    <td><?php echo $added; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_total; ?></td>
                    <td><?php echo $total; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_customer; ?></td>
                    <td><a href="<?php echo $view_customer; ?>"><?php echo $customer; ?></a></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_payment_id; ?></td>
                    <td>
                      <?php echo $payment_id; ?>
                      <br>
                      <button type="button" class="btn btn-success btn-xs" name="button-consultar" data-loading-text="<?php echo $text_aguarde; ?>"><i class="fa fa-search"></i> <?php echo $button_consultar; ?></button>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_metodo; ?></td>
                    <td><?php echo $metodo; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_antifraude; ?></td>
                    <?php if ($antifraude) { ?>
                    <td><span class="text-info"><strong><?php echo $text_com_antifraude; ?></strong></span></td>
                    <?php } else { ?>
                    <td><span class="text-danger"><strong><?php echo $text_sem_antifraude; ?></strong></span></td>
                    <?php } ?>
                  </tr>
                  <?php if ($tid) { ?>
                  <tr>
                    <td><?php echo $entry_tid; ?></td>
                    <td><?php echo $tid; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if ($codigo) { ?>
                  <tr>
                    <td><?php echo $entry_codigo; ?></td>
                    <td><?php echo $codigo; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if ($bandeira) { ?>
                  <tr>
                    <td><?php echo $entry_bandeira; ?></td>
                    <td><?php echo $bandeira; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if ($eci != '') { ?>
                  <tr>
                    <td><?php echo $entry_eci; ?></td>
                    <td>
                      <?php echo $eci; ?>
                      <?php if ($eci == '0' && $bandeira == 'Master') { ?>
                      - <span class="text-danger"><strong><?php echo $text_nao_autenticada; ?></strong></span>
                      <?php } else if ($eci == '1' && $bandeira == 'Master') { ?>
                      - <span class="text-danger"><strong><?php echo $text_falha_autenticao; ?></strong></span>
                      <?php } else if ($eci == '2' && $bandeira == 'Master') { ?>
                      - <span class="text-info"><strong><?php echo $text_autenticada; ?></strong></span>
                      <?php } else if ($eci == '5' && $bandeira == 'Visa') { ?>
                      - <span class="text-info"><strong><?php echo $text_autenticada; ?></strong></span>
                      <?php } else if ($eci == '6' && $bandeira == 'Visa') { ?>
                      - <span class="text-danger"><strong><?php echo $text_falha_autenticao; ?></strong></span>
                      <?php } else if ($eci == '7' && $bandeira == 'Visa') { ?>
                      - <span class="text-danger"><strong><?php echo $text_nao_autenticada; ?></strong></span>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php if ($parcelas) { ?>
                  <tr>
                    <td><?php echo $entry_parcelas; ?></td>
                    <td><?php echo $parcelas; ?>x</td>
                  </tr>
                  <?php } ?>
                  <?php if ($data_autorizacao) { ?>
                  <tr>
                    <td><?php echo $entry_autorizacao; ?></td>
                    <td>
                      <?php echo $data_autorizacao; ?>
                      <?php if ((!$data_captura) && (!empty($dias_capturar)) && (!$data_cancelamento) && (!empty($dias_cancelar))) { ?>
                      <br>
                      <strong><?php echo $dias_capturar; ?></strong>
                      <br>
                      <strong><?php echo $dias_cancelar; ?></strong>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_valor_autorizado; ?></td>
                    <td>
                      <?php echo $valor_autorizado; ?>
                      <?php if ((!$data_captura) && (!empty($dias_capturar)) && (!$data_cancelamento) && (!empty($dias_cancelar))) { ?>
                      <br>
                      <button type="button" class="btn btn-success btn-xs" name="button-capturar" data-loading-text="<?php echo $text_aguarde; ?>"><i class="fa fa-check"></i> <?php echo $button_capturar; ?></button> 
                      <button type="button" class="btn btn-danger btn-xs" name="button-cancelar" data-loading-text="<?php echo $text_aguarde; ?>"><i class="fa fa-trash-o"></i> <?php echo $button_cancelar; ?></button>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php if ($data_captura) { ?>
                  <tr>
                    <td><?php echo $entry_captura; ?></td>
                    <td>
                      <?php echo $data_captura; ?>
                      <br>
                      <?php if ((!$data_cancelamento) && (!empty($dias_cancelar))) { ?>
                      <strong><?php echo $dias_cancelar; ?></strong>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_valor_capturado; ?></td>
                    <td>
                      <?php echo $valor_capturado; ?> 
                      <?php if ((!$data_cancelamento) && (!empty($dias_cancelar))) { ?>
                      <button type="button" class="btn btn-danger btn-xs" name="button-cancelar" data-loading-text="<?php echo $text_aguarde; ?>"><i class="fa fa-trash-o"></i> <?php echo $button_cancelar; ?></button>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php if ($data_cancelamento) { ?>
                  <tr>
                    <td><?php echo $entry_cancelamento; ?></td>
                    <td><?php echo $data_cancelamento; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_valor_cancelado; ?></td>
                    <td><?php echo $valor_cancelado; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if ($boleto_data) { ?>
                  <tr>
                    <td><?php echo $entry_boleto_data; ?></td>
                    <td><?php echo $boleto_data; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_boleto_vencimento; ?></td>
                    <td><?php echo $boleto_vencimento; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_boleto_valor; ?></td>
                    <td><?php echo $boleto_valor; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if ($boleto_pagamento) { ?>
                  <tr>
                    <td><?php echo $entry_boleto_pagamento; ?></td>
                    <td><?php echo $boleto_pagamento; ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_boleto_pago; ?></td>
                    <td><?php echo $boleto_pago; ?></td>
                  </tr>
                  <?php } ?>
                  <?php if ($transferencia_data) { ?>
                  <tr>
                    <td><?php echo $entry_transferencia_data; ?></td>
                    <td><?php echo $transferencia_data; ?></td>
                  </tr>
                  <?php if ($transferencia_pagamento) { ?>
                  <tr>
                    <td><?php echo $entry_transferencia_pagamento; ?></td>
                    <td><?php echo $transferencia_pagamento; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td><?php echo $entry_transferencia_valor; ?></td>
                    <td><?php echo $transferencia_valor; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td><?php echo $entry_status; ?></td>
                    <td><strong><?php echo $status; ?></strong></td>
                  </tr>
                  <?php if ((!$data_cancelamento) && ($tipo == 'CreditCard' )) { ?>
                  <?php if ($clearsale) { ?>
                  <tr>
                    <td><?php echo $entry_clearsale; ?></td>
                    <td>
                      <form action="<?php echo $clearsale_url; ?>" method="post" id="clearsale" target="iFrameStart" onSubmit="carregarIframe(this);">
                        <?php foreach($clearsale_itens as $name => $value) { ?>
                        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
                        <?php } ?>
                      </form>
                      <button id="button-clearsale" class="btn btn-warning btn-xs" onclick="$('#clearsale').submit();"><i class="fa fa-shield"></i> <?php echo $button_antifraude; ?></button>
                      <script type="text/javascript"><!--
                        function carregarIframe(form){
                          var src = "<?php echo $clearsale_src; ?>";
                          $('#button-clearsale').hide();
                          $('#iFrameStart').show();
                          $('#iFrameStart').attr("src", src);
                          return true;
                        }
                      //--></script>
                      <iframe style="display:none;" id="iFrameStart" name="iFrameStart" width="280" height="100" frameborder="0" scrolling="no"><p><?php echo $error_iframe; ?></p></iframe>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php if ($fcontrol) { ?>
                  <tr>
                    <td><?php echo $entry_fcontrol; ?></td>
                    <td>
                      <button id="button-fcontrol" class="btn btn-warning btn-xs"><i class="fa fa-shield"></i> <?php echo $button_antifraude; ?></button>
                      <script type="text/javascript"><!--
                        $(document).delegate('#button-fcontrol', 'click', function() {
                          var src = "<?php echo $fcontrol_url; ?>";
                          $(this).hide();
                          $('#fcontrol').show();
                          $('#fcontrol').attr("src", src);
                        });
                      //--></script>
                      <iframe style="display:none;" id="fcontrol" width="300" height="110" frameborder="0" scrolling="no"><p><?php echo $error_iframe; ?></p></iframe>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab-json">
            <textarea wrap="off" rows="20" readonly class="form-control"><?php echo $json; ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    $('button[name=\'button-consultar\']').on('click', function() {
      $.ajax({ 
        url: 'index.php?route=extension/cielo_api/list/consultar&token=<?php echo $token; ?>&cielo_api_id=<?php echo $cielo_api_id; ?>',
        dataType: 'json',
        beforeSend: function() {
          $('button[name=\'button-consultar\']').button('loading');
          $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_consultando; ?> <img src="view/image/cielo_api/ajax-loader.gif" alt="" /><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        complete: function() {
          $('button[name=\'button-consultar\']').button('reset');
          $('.alert alert-danger').remove();
        },
        success: function(json) {
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          if (json['error']) {
            $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          } else {
            $('#progress').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['mensagem'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            location.href = location.href;
          }
        }
      });
    });
    <?php if ($tipo == 'CreditCard' || $tipo == 'DebitCard') { ?>
    $('button[name=\'button-capturar\']').on('click', function() {
      $.ajax({ 
        url: 'index.php?route=extension/cielo_api/list/capturar&token=<?php echo $token; ?>&cielo_api_id=<?php echo $cielo_api_id; ?>',
        dataType: 'json',
        beforeSend: function() {
          $('button[name=\'button-capturar\']').button('loading');
          $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_capturando; ?> <img src="view/image/cielo_api/ajax-loader.gif" alt="" /><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        complete: function() {
          $('button[name=\'button-capturar\']').button('reset');
          $('.alert alert-danger').remove();
        },
        success: function(json) {
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          if (json['error']) {
            $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          } else {
            $('#progress').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['mensagem'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            $('button[name=\'button-consultar\']').trigger('click');
          }
        }
      });
    });
    $('button[name=\'button-cancelar\']').on('click', function() {
      $.ajax({ 
        url: 'index.php?route=extension/cielo_api/list/cancelar&token=<?php echo $token; ?>&cielo_api_id=<?php echo $cielo_api_id; ?>',
        dataType: 'json',
        beforeSend: function() {
          $('button[name=\'button-cancelar\']').button('loading');
          $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_cancelando; ?> <img src="view/image/cielo_api/ajax-loader.gif" alt="" /><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        complete: function() {
          $('button[name=\'button-cancelar\']').button('reset');
          $('.alert alert-danger').remove();
        },
        success: function(json) {
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          if (json['error']) {
            $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          } else {
            $('#progress').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['mensagem'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            $('button[name=\'button-consultar\']').trigger('click');
          }
        }
      });
    });
    <?php } ?>
  //--></script>
</div>
<?php echo $footer; ?>