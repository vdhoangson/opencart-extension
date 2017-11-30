<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $button_add; ?></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-testimonial').submit() : false;"><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      <?php echo $shortcut; ?>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
        <a href="<?php echo HTTP_CATALOG;?>index.php?route=penblog/testimonial" class="btn blue-bg btn-sm pull-right" target="_blank">Front-end testimonial form</a>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-rating"><?php echo $column_rating; ?></label>
                <select name="filter_rating" id="input-rating" class="form-control">
                  <option value="*"></option>
                  <?php for($i=1; $i<=5; $i++){ ?>
                    <option value="<?php echo $i; ?>" <?php echo ($filter_rating == $i)?'selected="selected':''; ?>"><?php echo $i; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-read"><?php echo $column_read; ?></label>
                <select name="filter_read" id="input-read" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_read) { ?>
                  <option value="1" selected="selected">Read</option>
                  <?php } else { ?>
                  <option value="1">Read</option>
                  <?php } ?>
                  <?php if (!$filter_read && !is_null($filter_read)) { ?>
                  <option value="0" selected="selected">Unread</option>
                  <?php } else { ?>
                  <option value="0">Unread</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_status && !is_null($filter_status)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td width="1" style="text-align: center;"><?php echo $column_avatar; ?></td>
                  <td class="left"><?php if ($sort == 'r.customer_name') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?>
                  </td>
                  <td class="text-center"><?php if ($sort == 'r.rating') { ?>
                    <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?></a>
                    <?php } ?>
                  </td>
                  <td class="right"><?php if ($sort == 'r.read') { ?>
                    <a href="<?php echo $sort_read; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_read; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_read; ?>"><?php echo $column_read; ?></a>
                    <?php } ?>
                  </td>
                  <td class="right"><?php if ($sort == 'r.status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?>
                  </td>
                  <td class="right"><?php if ($sort == 'r.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?>
                  </td>
                  <td class="right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($testimonials) { ?>
                <?php foreach ($testimonials as $testimonial) { ?>
                <tr>
                  <td style="text-align: center;"><?php if ($testimonial['selected']) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $testimonial['testimonial_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $testimonial['testimonial_id']; ?>" />
                    <?php } ?>
                  </td>
                  <td style="text-align: center;" class="avatar"><img src="<?php echo $testimonial['avatar']; ?>" alt="<?php echo $testimonial['customer_name']; ?>"/></td>
                  <td class="left"><?php echo $testimonial['customer_name']; ?><br> <span class="help"><?php echo $testimonial['competence']; ?></span></td>
                  
                  <td class="text-center"><img src="view/penblog/rating/stars-<?php echo $testimonial['rating']; ?>.png" /></td>
                  <td class="right"><?php echo $testimonial['read']; ?></td>
                  <td class="right"><?php echo $testimonial['status']; ?></td>
                  <td class="right"><?php echo $testimonial['date_added']; ?></td>
                  <td class="right">
                    <div class="buttons">
                      <?php foreach ($testimonial['action'] as $action) { ?>
                      <a class="btn btn-primary" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                      <?php } ?>
                    </div>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        <!--row --> 
      </div>
      <!--panel-body -->
      <div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div> 
    </div>
    <!--panel --> 
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=penblog/testimonial&token=<?php echo $token; ?>';

  var filter_rating = $('select[name=\'filter_rating\']').val();

  if (filter_rating != '*') {
    url += '&filter_rating=' + encodeURIComponent(filter_rating);
  }

  var filter_read = $('select[name=\'filter_read\']').val();

  if (filter_read != '*') {
    url += '&filter_read=' + encodeURIComponent(filter_read);
  }

  var filter_status = $('select[name=\'filter_status\']').val();

  if (filter_status != '*') {
    url += '&filter_status=' + encodeURIComponent(filter_status);
  }

  location = url;
});
//--></script>
<?php echo $footer; ?>