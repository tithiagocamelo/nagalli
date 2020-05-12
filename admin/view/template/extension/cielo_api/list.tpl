<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div id="progress"></div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="cielo-api" style="min-width:100% !important;" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="min-width: 80px !important;" class="text-right"><?php echo $column_order_id; ?></th>
                <th style="min-width: 120px !important;" class="text-center"><?php echo $column_date_added; ?></th>
                <th style="min-width: 200px !important;" class="text-left"><?php echo $column_customer; ?></th>
                <th style="min-width: 100px !important;" class="text-left"><?php echo $column_metodo; ?></th>
                <th style="min-width: 120px !important;" class="text-center"><?php echo $column_status; ?></th>
                <th style="min-width: 100px !important;" class="text-right"><?php echo $column_action; ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if ($transactions) { ?>
              <?php foreach ($transactions as $transaction) { ?>
              <tr>
                <td class="text-right"><a href="<?php echo $transaction['view_order']; ?>"><?php echo $transaction['order_id']; ?></a></td>
                <td class="text-center"><?php echo $transaction['date_added']; ?></td>
                <td class="text-left"><?php echo $transaction['customer']; ?></td>
                <td class="text-left"><?php echo $transaction['metodo']; ?></td>
                <td class="text-center"><?php echo $transaction['status']; ?></td>
                <td class="text-right">
                  <button type="button" data-toggle="tooltip" title="<?php echo $button_excluir; ?>" class="btn btn-danger" name="button-excluir" id="<?php echo $transaction['cielo_api_id']; ?>" data-loading-text="..."><i class="fa fa-trash-o"></i></button>
                  <a href="<?php echo $transaction['view_transaction']; ?>" data-toggle="tooltip" title="<?php echo $button_informacoes; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                </td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    $(document).ready(function() {
      $('#cielo-api').DataTable({
        "order": [],
        "columnDefs": [ {"targets": 5, "searchable": false, "orderable": false} ],
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
      });
    });

    $('button[name=\'button-excluir\']').on('click', function() {
      if (confirm('<?php echo $text_confirmacao; ?>')) {
        $('.alert alert-danger').remove();
        var currentId = $(this).attr('id');
        $.ajax({
          url: 'index.php?route=extension/cielo_api/list/excluir&token=<?php echo $token; ?>&cielo_api_id=' + currentId,
          dataType: 'json',
          beforeSend: function() {
            $('button[name=\'button-excluir\']').button('loading');
            $('button[name=\'button-excluir\']').prop('disabled', true);
          },
          complete: function() {
            $('button[name=\'button-excluir\']').button('reset');
            $('button[name=\'button-excluir\']').prop('disabled', false);
          },
          success: function(json) {
            if (json['error']) {
              $('html, body').animate({ scrollTop: 0 }, 'slow');
              $('#progress').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            } else {
              location.href = location.href;
            }
          }
        });
      }
    });
  //--></script>
</div>
<?php echo $footer; ?>