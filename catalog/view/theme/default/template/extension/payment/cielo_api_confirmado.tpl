<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row">
    <div id="content" class="col-sm-12">
      <div id="cupom" class="panel panel-info">
        <div class="panel-heading"><?php echo $heading_title; ?></div>
        <div class="panel-body">
        <?php echo $text_mensagem; ?>
        </div>
      </div>
      <div class="buttons">
        <div class="pull-left">
          <a href="<?php echo $url; ?>" class="btn btn-primary"><?php echo $text_botao; ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>