<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-mensagem" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-mensagem" class="form-horizontal">
          <div class="form-group required" id="titulo">
            <label class="col-sm-2 control-label" for="input-titulo"><?php echo $entry_titulo; ?></label>
            <div class="col-sm-10">
              <input type="text" name="titulo" value="<?php print $titulo; ?>" placeholder="<?php echo $entry_titulo; ?>" id="input-titulo" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-mensagem"><?php echo $entry_mensagem; ?></label>
            <div class="col-sm-10">
              <textarea name="mensagem" placeholder="<?php echo $entry_mensagem; ?>" id="input-mensagem" class="form-control summernote"><?php print $mensagem; ?></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<?php echo $footer; ?>