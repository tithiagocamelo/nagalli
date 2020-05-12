<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cielo-api-cron" input type="hidden" id="save_stay" name="save_stay" value="1" data-toggle="tooltip" title="<?php echo $button_save_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-cielo-api-cron" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1> <span class="badge"><?php echo $versao; ?></span>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cielo-api-cron" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-geral" data-toggle="tab"><?php echo $tab_geral; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-geral">
              <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_info_geral; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-url-cron"><span data-toggle="tooltip" title="<?php echo $help_url_cron; ?>"><?php echo $entry_url_cron; ?></span></label>
                <div class="col-sm-10">
                  <strong><?php echo $text_url_cron; ?></strong>
                  <br>
                  <?php echo $url_cron; ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-chave-cron"><span data-toggle="tooltip" title="<?php echo $help_chave_cron; ?>"><?php echo $entry_chave_cron; ?></span></label>
                <div class="col-sm-4">
                  <input type="text" name="cielo_api_cron_chave_cron" value="<?php echo $cielo_api_cron_chave_cron; ?>" placeholder="<?php echo $entry_chave_cron; ?>" id="input-chave-cron" class="form-control" />
                  <?php if ($error_chave_cron) { ?>
                  <div class="text-danger"><?php echo $error_chave_cron; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-notification"><span data-toggle="tooltip" title="<?php echo $help_notification; ?>"><?php echo $entry_notification; ?></span></label>
                <div class="col-sm-2">
                  <select name="cielo_api_cron_notification" id="input-notification" class="form-control">
                    <?php if ($cielo_api_cron_notification) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-2">
                  <select name="cielo_api_cron_status" id="input-status" class="form-control">
                    <?php if ($cielo_api_cron_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>