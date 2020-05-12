<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-sub-total" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit_order_discount; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sub-total" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="discountorder_status" id="input-status" class="form-control">
                <?php if ($discountorder_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <!--
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_order_price_qunatity; ?></label>
            <div class="col-sm-10">
              <select name="discountorder_pricequantity" id="input-status" class="form-control">
                <?php if ($discountorder_pricequantity == 'price') { ?>
                <option value="price" selected="selected"><?php echo 'Price'; ?></option>
                <option value="quantity"><?php echo 'Quantity'; ?></option>
                <?php } else { ?>
                <option value="price"><?php echo 'Price'; ?></option>
                <option value="quantity" selected="selected"><?php echo 'Quantity'; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> -->
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_order_discount_type; ?></label>
            <div class="col-sm-10">
              <select name="discountorder_distype" id="input-status" class="form-control">
                <?php if ($discountorder_distype == 'percent') { ?>
                <option value="percent" selected="selected"><?php echo $text_percent_order_discount; ?></option>
                <option value="fix"><?php echo $text_fix_order_discount; ?></option>
                <?php } else { ?>
                <option value="percent"><?php echo $text_percent_order_discount; ?></option>
                <option value="fix" selected="selected"><?php echo $text_fix_order_discount; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <!--
		      <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_order_discount_label; ?></label>
            <div class="col-sm-10">
              <input type="text" name="discountorder_on_pr_qu" value="<?php echo $discountorder_on_pr_qu; ?>" placeholder="<?php echo $entry_order_discount_label; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div> -->
		   
		      <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_order_discount_value; ?></label>
            <div class="col-sm-10">
              <input type="text" name="discountorder_disvalue" value="<?php echo $discountorder_disvalue; ?>" placeholder="<?php echo $entry_order_discount_value; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_discountorder_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="discountorder_sort_order" value="<?php echo $discountorder_sort_order; ?>" placeholder="<?php echo $entry_discountorder_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>