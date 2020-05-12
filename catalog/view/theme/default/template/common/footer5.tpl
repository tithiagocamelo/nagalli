<?php if(false) { ?>

<footer>
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-2">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-2">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
          <li><a href="https://rastreamentocorreios.info/">Rastrear pedido</a></li>
        </ul>
      </div>
      <div class="col-sm-2">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-2">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>

    <div class="col-sm-3" id="newsletter">
      <h5><i class="fa fa-envelope"></i>NEWS</h5>
      <p>ASSINE NOSSA NEWSLETTER</p>
      <div class="form-group">
        <input type="text" class="form-control form-control-lg" id="email" placeholder="E-mail">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-default" style="width: 100%;" onclick="return regNewsletter();">Enviar</button>
      </div>
    </div>

    </div>
    <hr>
    <p><?php echo $powered; ?></p>
  </div>
</footer>
<?php } ?>



<footer>
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-2">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5>FALE CONOSCO</h5>
        <p>Sera um prazer te ajudar! Por gentileza, nos envie um email para <strong>hello@loristore.com</strong> ou nos ligue no <strong>(11)95379-6206</strong>.</p>
      </div>
      <div class="col-sm-4">
        <h5>FORMA DE PAGAMENTO</h5>
        <p>Para fazer de sua compra uma experiência segura, a Lori Store trabalha exclusivamente com o Pagseguro, que oferece a opção de pagamento por boleto ou cartão de credito (ate 12 x sem juros aceitando mais de 20 bandeiras). Também oferecemos a opção de transferencia em conta corrente (Itau).</p>
      </div>
      <!--<div class="col-sm-2">
        <h5></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>-->

    <div class="col-sm-3" id="newsletter">
      <h5><i class="fa fa-envelope"></i>NEWS</h5>
      <p>ASSINE NOSSA NEWSLETTER</p>
      <div class="form-group">
        <input type="text" class="form-control form-control-lg" id="email" placeholder="E-mail">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-default" style="width: 100%;" onclick="return regNewsletter();">Enviar</button>
      </div>
    </div>

    </div>
    <hr>
    <p><?php echo $powered; ?></p>
  </div>
</footer>







<script>
  function regNewsletter()
  {
    var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var email = $('#email').val();
    if(email != "")
    {
      if(!emailpattern.test(email))
      {
        $("#text-danger-newsletter").remove();
        $("#newsletter").first("div").removeClass("has-error");
        $("#newsletter-email").append('<div class="text-danger" id="text-danger-newsletter">E-Mail preenchido incorretamente.</div>');
        $("#newsletter").first("div").addClass("has-error");

        return false;
      }
      else
      {
        $.ajax({
          url: 'index.php?route=extension/module/newsletters/add',
          type: 'post',
          data: 'email=' + $('#txtemail').val(),
          dataType: 'json',
          async:false,

          success: function(json) {

            if (json.message == true) {
              alert('Cadastrado com sucesso.');
              window.location= "index.php";
            }
            else {
              $("#text-danger-newsletter").remove();
              $("#newsletter").first("div").removeClass("has-error");
              $("#newsletter-email").append(json.message);
              $("#newsletter").first("div").addClass("has-error");
              console.log()
            }
          }
        });
        return false;
      }
    }
    else
    {

      $("#text-danger-newsletter").remove();
      $("#newsletter").first("div").removeClass("has-error");
      $("#form-newsletter-error").append('<div class="text-danger" id="text-danger-newsletter">E-Mail preenchido incorretamente.</div>');
      $("#newsletter").first("div").addClass("has-error");

      return false;
    }
  }
</script>


</body></html>



