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
                        
                        <div class="panel-collapse collapse in" id="collapse-shipping-address">
                            <div class="panel-body"></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        
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
                    
                    <div class="col-md-12" id="tab-checkout-confirm">
                    
                        

                    </div>

                </div>

            </div>

        </div>
        
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<div class="main_loader" style="display: none;">
    <div class="loader">
        <img src="catalog/view/theme/default/image/loader.svg">
    </div>
</div>
<script>
    $(document).ready(function() {    
        // Register
        $(document).delegate('#button-register', 'click', function() {
            $.ajax({
                url: 'index.php?route=checkout/register/save',
                type: 'post',
                data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address textarea, #collapse-payment-address select'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-register').button('loading');
                },
                success: function(json) {
                    $('.alert, .text-danger').remove();
                    $('.form-group').removeClass('has-error');

                    if (json['redirect']) {
                        location = json['redirect'];
                    } else if (json['error']) {
                        $('#button-register').button('reset');

                        if (json['error']['warning']) {
                            $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }

                        for (i in json['error']) {
                            var element = $('#input-payment-' + i.replace('_', '-'));

                            if ($(element).parent().hasClass('input-group')) {
                                $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                            } else {
                                $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                            }
                        }

                        // Highlight any found errors
                        $('.text-danger').parent().addClass('has-error');
                    } else {
                        <?php if ($shipping_required) { ?>
                        var shipping_address = $('#payment-address input[name=\'shipping_address\']:checked').prop('value');

                        if (shipping_address) {
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_method',
                                dataType: 'html',
                                success: function(html) {
                                    // Add the shipping address
                                    $.ajax({
                                        url: 'index.php?route=checkout/shipping_address',
                                        dataType: 'html',
                                        success: function(html) {
                                            $('#collapse-shipping-address .panel-body').html(html);

                                            $('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                        }
                                    });

                                    $('#collapse-shipping-method .panel-body').html(html);

                                    $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_method; ?> <i class="fa fa-caret-down"></i></a>');

                                    $('a[href=\'#collapse-shipping-method\']').trigger('click');

                                    $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
                                    $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
                                    $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        } else {
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_address',
                                dataType: 'html',
                                success: function(html) {
                                    $('#collapse-shipping-address .panel-body').html(html);

                                    $('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');

                                    $('a[href=\'#collapse-shipping-address\']').trigger('click');

                                    $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
                                    $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
                                    $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        }
                        <?php } else { ?>
                        $.ajax({
                            url: 'index.php?route=checkout/payment_method',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-payment-method .panel-body').html(html);

                                $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');

                                $('a[href=\'#collapse-payment-method\']').trigger('click');

                                $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                        <?php } ?>

                        $.ajax({
                            url: 'index.php?route=checkout/payment_address',
                            dataType: 'html',
                            complete: function() {
                                $('#button-register').button('reset');
                            },
                            success: function(html) {
                                $('#collapse-payment-address .panel-body').html(html);

                                $('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

    });
</script>

<script>

    let save_payment_address = null,
        save_shipping_address = null,
        save_shipping_method = null,
        save_payment_method = null;

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

                    save_payment_address();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

            $('#quick_checkout').removeClass('hidden');
            $('#collapse-checkout-option').parent().addClass('hidden');
            
        <?php } ?>

        // Checkout
        $(document).delegate('#button-account', 'click', function() {
            $.ajax({
                url: 'index.php?route=checkout/' + $('input[name=\'account\']:checked').val(),
                dataType: 'html',
                beforeSend: function() {
                    $('#button-account').button('loading');
                },
                complete: function() {
                    $('#button-account').button('reset');
                },
                success: function(html) {
                    $('.alert, .text-danger').remove();

                    $('#collapse-payment-address .panel-body').html(html);

                    if ($('input[name=\'account\']:checked').val() == 'register') {
                        $('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_account; ?> <i class="fa fa-caret-down"></i></a>');
                    } else {
                        $('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i></a>');
                    }

                    // $('a[href=\'#collapse-payment-address\']').trigger('click');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

        // Login
        $(document).delegate('#button-login', 'click', function() {
            $.ajax({
                url: 'index.php?route=checkout/login/save',
                type: 'post',
                data: $('#collapse-checkout-option :input'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-login').button('loading');
                },
                complete: function() {
                    $('#button-login').button('reset');
                },
                success: function(json) {
                    $('.alert, .text-danger').remove();
                    $('.form-group').removeClass('has-error');

                    if (json['redirect']) {
                        location = json['redirect'];
                    } else if (json['error']) {
                        $('#collapse-checkout-option .panel-body').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                        // Highlight any found errors
                        $('input[name=\'email\']').parent().addClass('has-error');
                        $('input[name=\'password\']').parent().addClass('has-error');
                }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

        // Payment Address
        save_payment_address = function() {
            $.ajax({
                url: 'index.php?route=checkout/payment_address/save',
                type: 'post',
                data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-payment-address').button('loading');
                    $('.main_loader').show()
                },
                complete: function() {
                    $('#button-payment-address').button('reset');
                    $('.main_loader').hide()
                },
                success: function(json) {
                    $('.alert, .text-danger').remove();
        
                    if (json['redirect']) {
                        location = json['redirect'];
                    } else if (json['error']) {
                        if (json['error']['warning']) {
                            $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }
        
                        for (i in json['error']) {
                            var element = $('#input-payment-' + i.replace('_', '-'));
        
                            if ($(element).parent().hasClass('input-group')) {
                                $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                            } else {
                                $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                            }
                        }
        
                        // Highlight any found errors
                        $('.text-danger').parent().parent().addClass('has-error');
                    } else {
                        
                        <?php if ($shipping_required) { ?>
                        $.ajax({
                            url: 'index.php?route=checkout/shipping_address',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-shipping-address .panel-body').html(html);
        
                                save_shipping_address();

                                // $('#collapse-shipping-address').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_address; ?> <i class="fa fa-caret-down"></i></a>');
        
                                // $('a[href=\'#collapse-shipping-address\']').trigger('click');
        
                                $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_shipping_method; ?>');
                                $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
                                $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                        <?php } else { ?>
                        $.ajax({
                            url: 'index.php?route=checkout/payment_method',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-payment-method .panel-body').html(html);
        
                                $('#collapse-payment-method')

                                save_payment_method();

                                // $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');
        
                                // $('a[href=\'#collapse-payment-method\']').trigger('click');
        
                                $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                        <?php } ?>
        
                        $.ajax({
                            url: 'index.php?route=checkout/payment_address',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-payment-address .panel-body').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        // Shipping Address
        save_shipping_address = function() {
            $.ajax({
                url: 'index.php?route=checkout/shipping_address/save',
                type: 'post',
                data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-shipping-address').button('loading');
                    $('.main_loader').show()
                },
                success: function(json) {
                    $('.alert, .text-danger').remove();
        
                    if (json['redirect']) {
                        location = json['redirect'];
                    } else if (json['error']) {
                        $('#button-shipping-address').button('reset');
                        $('.main_loader').hide()
        
                        if (json['error']['warning']) {
                            $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }
        
                        for (i in json['error']) {
                            var element = $('#input-shipping-' + i.replace('_', '-'));
        
                            if ($(element).parent().hasClass('input-group')) {
                                $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                            } else {
                                $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                            }
                        }
        
                        // Highlight any found errors
                        $('.text-danger').parent().parent().addClass('has-error');
                    } else {
                        $.ajax({
                            url: 'index.php?route=checkout/shipping_method',
                            dataType: 'html',
                            complete: function() {
                                $('#button-shipping-address').button('reset');
                                $('.main_loader').hide()
                            },
                            success: function(html) {
                                $('#collapse-shipping-method .panel-body').html(html);

                                $('#collapse-shipping-method').addClass('in');

                                save_shipping_method();
        
                                // $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_shipping_method; ?> <i class="fa fa-caret-down"></i></a>');
        
                                // $('a[href=\'#collapse-shipping-method\']').trigger('click');
        
                                $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?>');
                                $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
        
                                $.ajax({
                                    url: 'index.php?route=checkout/shipping_address',
                                    dataType: 'html',
                                    success: function(html) {
                                        $('#collapse-shipping-address .panel-body').html(html);
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                                });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
        
                        $.ajax({
                            url: 'index.php?route=checkout/payment_address',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-payment-address .panel-body').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        // Shipping Method
        save_shipping_method = function() {
            $.ajax({
                url: 'index.php?route=checkout/shipping_method/save',
                type: 'post',
                data: $('#collapse-shipping-method input[type=\'radio\']:checked, #collapse-shipping-method textarea'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-shipping-method').button('loading');
                    $('.main_loader').show();
                },
                success: function(json) {
                    $('.alert, .text-danger').remove();
        
                    if (json['redirect']) {
                        location = json['redirect'];
                    } else if (json['error']) {
                        $('#button-shipping-method').button('reset');
                        $('.main_loader').hide();
        
                        if (json['error']['warning']) {
                            $('#collapse-shipping-method .panel-body').prepend('<div class="alert alert-danger">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }
                    } else {
                        $.ajax({
                            url: 'index.php?route=checkout/payment_method',
                            dataType: 'html',
                            complete: function() {
                                $('#button-shipping-method').button('reset');
                                $('.main_loader').hide();
                            },
                            success: function(html) {
                                $('#collapse-payment-method .panel-body').html(html);
        
                                // thiago - verificar se existe o tipo de pagamento na listagem
                                $('#collapse-payment-method').addClass('in');

                                save_payment_method();

                                // $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i></a>');
        
                                // $('a[href=\'#collapse-payment-method\']').trigger('click');
        
                                $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?>');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        save_payment_method = function() {

            $('[name="agree"]').prop('checked', true);

            $.ajax({
                url: 'index.php?route=checkout/payment_method/save',
                type: 'post',
                data: $('#collapse-payment-method input[type=\'radio\']:checked, #collapse-payment-method input[type=\'checkbox\']:checked, #collapse-payment-method textarea'),
                dataType: 'json',
                beforeSend: function() {
                    $('#button-payment-method').button('loading');
                    $('.main_loader').show();
                },
                success: function(json) {
                    $('.alert, .text-danger').remove();
        
                    if (json['redirect']) {
                        location = json['redirect'];
                    } else if (json['error']) {
                        $('#button-payment-method').button('reset');
                        $('.main_loader').hide();
                        
                        if (json['error']['warning']) {
                            $('#collapse-payment-method .panel-body').prepend('<div class="alert alert-danger">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }
                    } else {
                        $.ajax({
                            url: 'index.php?route=checkout/confirm',
                            dataType: 'html',
                            beforeSend: function() {
                                $('.main_loader').show();
                            },
                            complete: function() {
                                $('#button-payment-method').button('reset');
                                $('.main_loader').hide();
                            },
                            success: function(html) {
                                $('#tab-checkout-confirm').html(html);
        
                                // $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<a href="#collapse-checkout-confirm" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle"><?php echo $text_checkout_confirm; ?> <i class="fa fa-caret-down"></i></a>');
        
                                // $('a[href=\'#collapse-checkout-confirm\']').trigger('click');
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        $(document).delegate('#button-payment-address', 'click', save_payment_address );

        $(document).delegate('#button-shipping-address', 'click', save_shipping_address );

        $(document).delegate('[name="shipping_method"]', 'change', save_shipping_method );

        $(document).delegate('[name="payment_method"]', 'change', save_payment_method );

    });
</script>

<?php echo $footer; ?>
