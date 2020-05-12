<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row">
    <div id="content" class="col-sm-12">
      <div class="row">
        <div class="col-sm-4">
          <div id="cupom" class="panel panel-info">
            <div class="panel-heading"><?php echo $heading_title; ?></div>
            <div class="panel-body">
            <?php echo nl2br($text_comprovante); ?>
            </div>
          </div>
          <div class="buttons">
            <div class="pull-left">
              <a href="<?php echo $imprimir; ?>" target="_blank" class="btn btn-primary"><?php echo $button_imprimir; ?></a>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div id="cupom" class="panel panel-info">
            <div class="panel-body">
            <?php echo $text_importante; ?>
            </div>
          </div>
          <div class="buttons">
            <div class="pull-left">
              <a href="<?php echo $historico; ?>" class="btn btn-primary"><?php echo $button_historico; ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>