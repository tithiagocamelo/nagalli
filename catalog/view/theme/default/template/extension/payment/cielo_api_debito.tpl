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
<?php if ($bandeiras) { ?>
<div id="responsivo">
  <?php if ($ambiente) { ?>
  <div class="alert alert-warning"><?php echo $text_sandbox; ?></div>
  <?php } ?>
  <h4><strong><?php echo $text_detalhes; ?></strong></h4>
  <h4>&nbsp;</h4>
  <form onkeypress="return event.keyCode != 13" id="payment">
    <div class="row-form" id="bandeiras"></div>
    <h4>&nbsp;</h4>
    <div class="row-form">
      <div class="four columns value">
        <label for="input-cartao"><?php echo $entry_cartao; ?><span id='bandeiraEscolhida'></span>:</label>
        <input type="text" name="cartao" value="" placeholder="" id="input-cartao" maxlength="19" autocomplete="off" class="u-full-width" />
      </div>
      <div class="four columns value">
        <label for="input-titular"><?php echo $entry_titular; ?></label>
        <input type="text" name="titular" value="" placeholder="" id="input-titular" maxlength="30" autocomplete="off" class="u-full-width" />
      </div>
    </div>
    <div class="row-form">
      <div id="meses" class="three columns value">
        <label class="" for="input-mes"><strong><?php echo $entry_validade_mes; ?></strong></label>
        <select name="mes" id="input-mes" class="u-full-width">
        </select>
      </div>
      <div id="anos" class="three columns value">
        <label class="" for="input-ano"><strong><?php echo $entry_validade_ano; ?></strong></label>
        <select name="ano" id="input-ano" class="u-full-width">
        </select>
      </div>
      <div class="three columns value">
        <label class="u-full-width" for="input-codigo"><strong><?php echo $entry_codigo; ?></strong></label>
        <input type="text" name="codigo" value="" placeholder="" id="input-codigo" maxlength="4" autocomplete="off" class="u-full-width" />
      </div>
    </div>
    <input class="button-primary" value="<?php echo $button_pagar; ?>" id="button-confirm" data-loading-text="<?php echo $text_carregando; ?>" type="button">
  </form>
</div>
<script type="text/javascript" src="catalog/view/javascript/cielo_api/js/jquery-loading-overlay/loadingoverlay.min.js?v=<?php echo $versao; ?>"></script>
<script type="text/javascript"><!--
  function meses() {
    json = <?php echo $meses; ?>;
    html = '<label class="" for="input-mes"><strong><?php echo $entry_validade_mes; ?></strong></label>';
    html += '<select name="mes" id="input-mes" class="u-full-width">';
    html += '<option value=""><?php echo $text_mes; ?></option>';
    for (i = 0; i <= json.length-1; i++) {
      html += '<option value="' + json[i]['value'] + '">' + json[i]['text'] + '</option>';
    }
    html += '</select>';
    $('#meses').html(html);
  };
  meses();
  function anos() {
    json = <?php echo $anos; ?>;
    html = '<label class="" for="input-ano"><strong><?php echo $entry_validade_ano; ?></strong></label>';
    html += '<select name="ano" id="input-ano" class="u-full-width">';
    html += '<option value=""><?php echo $text_ano; ?></option>';
    for (i = 0; i <= json.length-1; i++) {
      html += '<option value="' + json[i]['value'] + '">' + json[i]['text'] + '</option>';
    }
    html += '</select>';
    $('#anos').html(html);
  };
  anos();
  function bandeiras() {
    $.ajax({
      url: 'index.php?route=extension/payment/cielo_api_debito/bandeiras',
      dataType: 'json',
      cache: false,
      beforeSend: function() {
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
      },
      success: function(json) {
        html = '';
        for (i = 0; i <= json.length-1; i++) {
          html += '<div class="two columns value">';
          if (i == '0') {
            html += '<input type="radio" name="bandeira" id="input-bandeira" value="'+ json[i]['bandeira'] +'" checked />';
            if(json[i]['bandeira'] == 'visa'){
              $('#bandeiraEscolhida').html('VISA ELECTRON');
            }else if(json[i]['bandeira'] == 'mastercard'){
              $('#bandeiraEscolhida').html('MAESTRO');
            }
          } else {
            html += '<input type="radio" name="bandeira" id="input-bandeira" value="'+ json[i]['bandeira'] +'" />';
          }
          html += '<img alt="' + json[i]['titulo'] + '" title="' + json[i]['titulo'] + '" src="'+ json[i]['imagem'] +'" border="0" /> ';
          html += '<strong><?php echo $total; ?></strong>';
          html += '</div>';
        }
        $('#bandeiras').html(html);
      }
    });
  }
  bandeiras();
  function transacao(campo) {
    $.ajax({
      url: 'index.php?route=extension/payment/cielo_api_debito/setTransacao',
      type: 'post',
      data: $('#payment input[type=\'text\'], #payment input[type=\'radio\']:checked, #payment select'),
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
        $('input[name="cartao"]').val('');
        $('input[name="titular"]').val('');
        $('select[name="mes"]').val('');
        $('select[name="ano"]').val('');
        $('input[name="codigo"]').val('');
        $.LoadingOverlay("hide");
      },
      success: function(json) {
        $.LoadingOverlay("hide");
        if(json['error']){
          campo.before('<div class="alert alert-warning" id="warning">'+json['error']+'</div>');
        }else{
          $('#button-confirm').hide();
          campo.before('<div class="alert alert-success"><?php echo $text_redirecionando; ?></div>');
          location.href = json['redirect'];
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        if(jqXHR.status == 404 || jqXHR.status == 500 || errorThrown == 'Not Found'){
          campo.before('<div class="alert alert-warning" id="warning"><?php echo $error_configuracao; ?></div>');
        }
      }
    });
  };
  function validar(campo) {
    var erros = 0;
    var campos = {
      cartao: '<?php echo $error_cartao; ?>',
      titular: '<?php echo $error_titular; ?>',
      mes: '<?php echo $error_mes; ?>',
      ano: '<?php echo $error_ano; ?>',
      codigo: '<?php echo $error_codigo; ?>'
    };

    $("div #warning").each(function(){ $(this).remove(); });
    $("div .text-danger").each(function(){ $(this).remove(); });
    $('#payment input[type=\'text\'], #payment select').removeClass('alert-danger');

    $("#payment input[type=\'text\'], #payment input[type=\'radio\']:checked, #payment select").each(function(){
      for(var chave in campos){
        if($(this).attr("name") == chave){
          if($(this).attr("name") == 'cartao'){
            if($.trim($(this).val()).length < 13){
              $(this).toggleClass('alert-danger');
              $(this).after('<div class="text-danger">'+campos[chave]+'</div>');
              erros++;
            }else{
              $(this).removeClass('alert-danger');
            }
          }else if($(this).attr("name") == 'codigo'){
            if($.trim($(this).val()).length !== 3){
              $(this).toggleClass('alert-danger');
              $(this).after('<div class="text-danger">'+campos[chave]+'</div>');
              erros++;
            }else{
              $(this).removeClass('alert-danger');
            }
          }else{
            if($.trim($(this).val()).length == 0){
              $(this).toggleClass('alert-danger');
              $(this).after('<div class="text-danger">'+campos[chave]+'</div>');
              erros++;
            }else{
              $(this).removeClass('alert-danger');
            }
          }
        }
      }
    });

    if(erros == 0){
      transacao(campo);
    }else{
      return false;
    };
  };
//--></script>
<script type="text/javascript" src="catalog/view/javascript/cielo_api/js/debito.js?v=<?php echo $versao; ?>"></script>
<?php } else { ?>
<div id="responsivo">
  <div class="alert alert-warning"><?php echo $error_bandeiras; ?></div>
</div>
<?php } ?>