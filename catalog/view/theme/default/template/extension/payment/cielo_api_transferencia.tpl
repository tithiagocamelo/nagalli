<link href="catalog/view/javascript/cielo_api/css/skeleton/normalize.css?v=<?php echo $versao; ?>" rel="stylesheet" type="text/css" />
<link href="catalog/view/javascript/cielo_api/css/skeleton/skeleton.css?v=<?php echo $versao; ?>" rel="stylesheet" type="text/css" />
<style>
  #responsivo .button.button-primary,
  #responsivo button.button-primary,
  #responsivo input[type="submit"].button-primary,
  #responsivo input[type="reset"].button-primary,
  #responsivo input[type="button"].button-primary {
    color: <?php echo $cor_normal_texto; ?>;
    background-color: <?php echo $cor_normal_fundo; ?>;
    border-color: <?php echo $cor_normal_borda; ?>;
  }
  #responsivo .button.button-primary:hover,
  #responsivo button.button-primary:hover,
  #responsivo input[type="submit"].button-primary:hover,
  #responsivo input[type="reset"].button-primary:hover,
  #responsivo input[type="button"].button-primary:hover,
  #responsivo .button.button-primary:focus,
  #responsivo button.button-primary:focus,
  #responsivo input[type="submit"].button-primary:focus,
  #responsivo input[type="reset"].button-primary:focus,
  #responsivo input[type="button"].button-primary:focus {
    color: <?php echo $cor_efeito_texto; ?>;
    background-color: <?php echo $cor_efeito_fundo; ?>;
    border-color: <?php echo $cor_efeito_borda; ?>;
  }
</style>
<div id="responsivo">
  <?php if ($ambiente) { ?>
  <div class="alert alert-warning"><?php echo $text_sandbox; ?></div>
  <?php } ?>
  <input class="button-primary" value="<?php echo $button_confirmar; ?>" id="button-confirm" data-loading-text="<?php echo $text_confirmando; ?>" type="button">
</div>
<script type="text/javascript" src="catalog/view/javascript/cielo_api/js/jquery-loading-overlay/loadingoverlay.min.js?v=<?php echo $versao; ?>"></script>
<script type="text/javascript"><!--
  function gerarTransferencia(campo) {
    $('#warning').remove();
    $('#danger').remove();

    $.ajax({
      url: 'index.php?route=extension/payment/cielo_api_transferencia/setTransacao',
      dataType: 'json',
      beforeSend: function() {
        $.LoadingOverlay("show");
        $('#button-confirm').button('loading');
        $("input").prop("disabled", true);
        $("select").prop("disabled", true);
        $("button").prop("disabled", true);
      },
      complete: function() {
        $('#button-confirm').button('reset');
        $("input").prop("disabled", false);
        $("select").prop("disabled", false);
        $("button").prop("disabled", false);
        $.LoadingOverlay("hide");
      },
      success: function(json) {
        $.LoadingOverlay("hide");
        if(json['error']){
          campo.before('<div class="alert alert-danger" id="danger">'+json['error']+'</div>');
        }else{
          $('#button-confirm').hide();
          campo.before('<div class="alert alert-success"><?php echo $text_confirmado; ?></div>');
          location.href = json['redirect'];
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if(jqXHR.status == 404 || jqXHR.status == 500 || errorThrown == 'Not Found'){
          campo.before('<div class="alert alert-warning" id="warning"><?php echo $error_configuracao; ?></div>');
        }
      }
    })
  };
  $('#button-confirm').on('click', function() {
    gerarTransferencia($(this));
  });
//--></script>
