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
    <?php if($checkUpdate){ ?>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> 
          Please update Pen Blog now
          <button type="button" data-toggle="tooltip" title="Update Now" class="btn btn-danger btn-sm" onclick="confirm('<?php echo $text_confirm; ?>') ? window.location='<?php echo $btn_update; ?>' : false;"><i class="fa fa-level-up"></i> Update Now</button>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="row">
      <!-- Article -->
      <div class="col-md-4">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_article; ?></h3>
          </div>
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">
                <span class="badge"><?php echo $total_article; ?></span>
                <?php echo $text_total_article; ?>
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $public_article; ?></span>
                <?php echo $text_public_article; ?>
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $unpublic_article; ?></span>
                <?php echo $text_unpublic_article; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Category -->
      <div class="col-md-4">
        <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_category; ?></h3>
          </div>
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">
                <span class="badge"><?php echo $total_category; ?></span>
                <?php echo $text_total_category; ?>
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $public_category; ?></span>
                <?php echo $text_public_category; ?>
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $unpublic_category; ?></span>
                <?php echo $text_unpublic_category; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Comment -->
      <div class="col-md-4">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_comment; ?></h3>
          </div>
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">
                <span class="badge"><?php echo $total_comment; ?></span>
                <?php echo $text_total_comment; ?>
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $public_comment; ?></span>
                <?php echo $text_public_comment; ?>
              </li>
              <li class="list-group-item">
                <span class="badge"><?php echo $unpublic_comment; ?></span>
                <?php echo $text_unpublic_comment; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-warning">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_latest_article; ?></h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $column_name; ?></td>
                    <td class="text-left"><?php echo $column_category; ?></td>
                    <td class="text-left"><?php echo $column_date_added; ?></td>
                    <td class="text-left"><?php echo $column_status; ?></td>
                    <td class="text-right"><?php echo $column_action; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($latest_articles) { ?>
                  <?php foreach ($latest_articles as $article) { ?>
                  <tr>
                    <td class="text-left"><?php echo $article['name']; ?></td>
                    <td class="text-left"><?php echo $article['category']; ?></td>
                    <td class="text-left"><?php echo $article['date_added']; ?></td>
                    <td class="text-left"><?php echo $article['status']; ?></td>
                    <td class="text-right"><a href="<?php echo $article['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $article['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i></a></td>
                  </tr>
                  <?php } ?>
                  <?php } else { ?>
                  <tr>
                    <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-warning">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_latest_testimonial; ?></h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $column_name; ?></td>
                    <td class="text-left"><?php echo $column_date_added; ?></td>
                    <td class="text-left"><?php echo $column_status; ?></td>
                    <td class="text-right"><?php echo $column_action; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($latest_testimonials) { ?>
                  <?php foreach ($latest_testimonials as $testimonial) { ?>
                  <tr>
                    <td class="text-left"><?php echo $testimonial['customer_name']; ?></td>
                    <td class="text-left"><?php echo $testimonial['date_added']; ?></td>
                    <td class="text-left"><?php echo $testimonial['status']; ?></td>
                    <td class="text-right"><a href="<?php echo $testimonial['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                  </tr>
                  <?php } ?>
                  <?php } else { ?>
                  <tr>
                    <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>