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



<footer  class="container">
  <div>
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      
      <div class="col-sm-5">
        <p>JOIAS NAGALLI © 2015 - Todos os direitos reservados.</p>
        <p>As imagens e informações exibidas são exclusivas do site.</p>
        <p>É proibida a reprodução sem autorização, seu conteúdo pode sofrer alterações sem aviso prévio.</p>
      </div>

      <div class="col-sm-4" style="padding-top: 12px;">
        <span><p style="text-align: right;"><img src="image/catalog/cielo_api/cartoes.png" style="width: 100%;"></p></span>
      </div>

    </div>    

  </div>

</footer>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <p id="text-powered" ><?php echo $powered; ?></p>
    </div>
  </div>
</div>

</body>
</html>



