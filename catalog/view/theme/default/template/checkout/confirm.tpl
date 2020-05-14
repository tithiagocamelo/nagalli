<?php if (!isset($redirect)) { ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-center">Imagem</td>
        <td class="text-left"><?php echo $column_name; ?></td>
        <td class="text-left"><?php echo $column_model; ?></td>
        <td class="text-right"><?php echo $column_quantity; ?></td>
        <td class="text-right"><?php echo $column_price; ?></td>
        <td class="text-right"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="text-center">
          <?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
          <?php } ?>
        </td>
        <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?>
          <?php if($product['recurring']) { ?>
          <br />
          <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
          <?php } ?></td>
        <td class="text-left"><?php echo $product['model']; ?></td>
        <!--<td class="text-right"><?php echo $product['quantity']; ?></td>-->
        <td class="text-left">
          <div class="input-group btn-block item_list" style="max-width: 200px;" data-cart_id="<?php echo $product['cart_id']; ?>">
            <input type="text" name="quantity" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
            <span class="input-group-btn">
              <button type="button" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary udate_item"><i class="fa fa-refresh"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="fa fa-times-circle"></i></button>
            </span>
          </div>
        </td>
        <td class="text-right"><?php echo $product['price']; ?></td>
        <td class="text-right"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="text-left"><?php echo $voucher['description']; ?></td>
        <td class="text-left"></td>
        <td class="text-right">1</td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="5" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
        <td class="text-right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script>
  $(document).ready(function() {
    $('.udate_item').click(function() {

      let item_list = $(this).closest('item_list');

      let quantity = item_list.find('[name="quantity"]').val(),
          key = item_list.data('cart_id');

      if(Number(quantity) == 0) {
        alert('Quantidade 0 (zero) não permitida');
        return;
      }

      $.ajax({
        url: 'index.php?route=checkout/cart/update',
        type: 'post',
        data: 'key=' + key + '&quantity=' + ((typeof(quantity) != 'undefined' && quantity > 0 ) ? quantity : 1),
        dataType: 'json',
        beforeSend: function() {
          $('#cart > button').button('loading');
        },
        complete: function() {
          $('#cart > button').button('reset');
        },
        success: function(json) {
          
          if(json.error === false) {

            console.log(json)

          }

        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    });
  });
</script>
<?php echo $payment; ?>
<?php } else { ?>
  <script type="text/javascript">
    location = '<?php echo $redirect; ?>';
  </script>
<?php } ?>
