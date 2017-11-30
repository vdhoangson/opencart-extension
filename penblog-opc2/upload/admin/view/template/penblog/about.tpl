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
      <?php echo $shortcut; ?>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_info_update; ?></a></li>
          <li><a href="#tab-log" data-toggle="tab"><?php echo $tab_log; ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-general">
            <div class="form-group">
              <label>Extension: Gen CMS - <a href="https://codecanyon.net/item/gen-cms-best-cms-for-opencart/15757289">Codecanyon Link</a></label>
            </div>
            <div class="form-group">
              <label>Author: <a href="https://codecanyon.net/user/geniusteams">vdhoangson</a> - <a href="http://pencms.com">http://pencms.com</a></label>
            </div>
            <div class="form-group">
              <label>Version:</label>
              <strong><?php echo $curent_version; ?></strong>
              <?php if($update==true){ ?>
              <p class="alert alert-danger"><i class="fa fa-info-circle"></i> <?php echo $text_need_update; ?></p>
              <?php } ?>
            </div>
            <?php if($update==true){ ?>
            <div class="form-group">
              <label>Update: <button type="button" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? window.location='<?php echo $btn_update; ?>' : false;"><i class="fa fa-level-up"></i> <?php echo $button_update; ?></button></label>
            </div>
            <?php } ?>
          </div>
          <div class="tab-pane" id="tab-log">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Date Update</th>
                  <th>Info</th>
                  <th>Version</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>20/09/2017</td>
                  <td>First Release</td>
                  <td>1.0</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div>
    </div>
  </div>
</div>