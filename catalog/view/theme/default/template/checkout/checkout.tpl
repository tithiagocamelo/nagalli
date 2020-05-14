<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div class="panel-group" id="accordion">
        
        <div class="panel panel-default">
          <div class="panel-collapse collapse in" id="collapse-checkout-option">
            <div class="panel-body"></div>
          </div>
        </div>
        
        <div class="row hidden" id="quick_checkout">
            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-collapse collapse" id="collapse-payment-address">
                        <div class="panel-body"></div>
                    </div>
                </div>
        

                <?php if ($shipping_required) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $text_checkout_shipping_address; ?></h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapse-shipping-address">
                            <div class="panel-body"></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?php echo $text_checkout_shipping_method; ?></h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapse-shipping-method">
                            <div class="panel-body"></div>
                        </div>
                    </div>
                <?php } ?>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?php echo $text_checkout_payment_method; ?></h4>
                    </div>
                    <div class="panel-collapse collapse" id="collapse-payment-method">
                        <div class="panel-body"></div>
                    </div>
                </div>

            </div>

            <div class="col-md-8">

                <div class="row">
                    
                    <div class="col-md-12">
                    
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?php echo $text_checkout_confirm; ?></h4>
                            </div>
                            <div class="panel-collapse collapse" id="collapse-checkout-confirm">
                                <div class="panel-body"></div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<script>
    $(document).ready(function() {
        
        <?php if (!$logged) { ?>
            $.ajax({
                url: 'index.php?route=checkout/login',
                dataType: 'html',
                success: function(html) {
                    console.log('podepa')
                    $('#collapse-checkout-option .panel-body').html(html);

                    // $('#collapse-checkout-option').parent().find('.panel-heading .panel-title').html('<a href="#collapse-checkout-option" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_option; ?> <i class="fa fa-caret-down"></i></a>');
                    
                    // $('a[href=\'#collapse-checkout-option\']').trigger('click');

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        <?php } else { ?>
            $.ajax({
                url: 'index.php?route=checkout/payment_address',
                dataType: 'html',
                success: function(html) {
                    $('#collapse-payment-address .panel-body').html(html);

                    // $('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');
                    $('#collapse-payment-address').addClass('in');
                    $('#collapse-payment-address').parent().removeClass('hidden');
                    // $('a[href=\'#collapse-payment-address\']').trigger('click');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

            $('#quick_checkout').removeClass('hidden');
            $('#collapse-checkout-option').parent().addClass('hidden');
        <?php } ?>

    });
</script>

<?php echo $footer; ?>
