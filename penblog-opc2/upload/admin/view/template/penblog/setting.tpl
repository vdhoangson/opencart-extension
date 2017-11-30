<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-gen-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-gen-setting" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-category" data-toggle="tab"><?php echo $tab_category; ?></a></li>
            <li><a href="#tab-article" data-toggle="tab"><?php echo $tab_article; ?></a></li>
            <li><a href="#tab-video" data-toggle="tab"><?php echo $tab_video; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <div class="col-md-6 col-sm-6">
                  <div class="form-group required">
                    <label class="col-sm-6 control-label"><?php echo $entry_admin_limit; ?></label>
                    <div class="col-sm-6">
                      <select name="penblog_setting[admin_limit]" class="form-control">
                        <?php foreach($admin_limits as $value) { ?>
                        <?php if($admin_limit==$value){ ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="form-group required">
                    <label class="col-sm-6 control-label"><?php echo $entry_date_format; ?></label>
                    <div class="col-sm-6">
                      <select name="penblog_setting[date_format]" class="form-control">
                        <?php foreach($date_formats as $key => $value) { ?>
                        <?php if($date_format==$key){ ?>
                        <option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4">
                  <label class="col-sm-6 control-label"><?php echo $entry_comment; ?></label>
                  <div class="col-sm-6">
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn <?php echo $comment_status=='1'?'btn-primary active':'btn-default'; ?>">
                      <input type="radio" name="penblog_setting[comment_status]" value="1" <?php echo $comment_status=='1'?'checked':''; ?>><?php echo $text_on; ?></label>
                      <label class="btn <?php echo $comment_status=='0'?'btn-primary active':'btn-default'; ?>">
                      <input type="radio" name="penblog_setting[comment_status]" value="0" <?php echo $comment_status=='0'?'checked':''; ?>><?php echo $text_off; ?></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-category">
              <div class="row">
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_catalog_setting; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label class="col-sm-6 control-label"><?php echo $entry_catalog_limit; ?></label>
                        <div class="col-sm-6">
                          <select name="penblog_setting[catalog_limit]" class="form-control">
                            <?php foreach($catalog_limits as $value) { ?>
                            <?php if($catalog_limit==$value){ ?>
                            <option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6">
                          <label><?php echo $entry_catalog_show_filter; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $catalog_show_filter==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_filter]" value="1" <?php echo $catalog_show_filter==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $catalog_show_filter==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_filter]" value="0" <?php echo $catalog_show_filter==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_catalog_setting_image; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_catalog_image; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[catalog_image_width]" value="<?php echo $catalog_image_width; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_catalog_image) { ?>
                            <div class="text-danger"><?php echo $error_catalog_image; ?></div>
                            <?php } ?>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[catalog_image_height]" value="<?php echo $catalog_image_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_catalog_image) { ?>
                            <div class="text-danger"><?php echo $error_catalog_image; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_catalog_image_article; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[catalog_image_article_width]" value="<?php echo $catalog_image_article_width; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_catalog_image_article) { ?>
                            <div class="text-danger"><?php echo $error_catalog_image_article; ?></div>
                            <?php } ?>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[catalog_image_article_height]" value="<?php echo $catalog_image_article_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_catalog_image_article) { ?>
                            <div class="text-danger"><?php echo $error_catalog_image_article; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_catalog_setting_article; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_author; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $catalog_show_author==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_author]" value="1" <?php echo $catalog_show_author==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $catalog_show_author==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_author]" value="0" <?php echo $catalog_show_author==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_viewed; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $catalog_show_viewed==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_viewed]" value="1" <?php echo $catalog_show_viewed==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $catalog_show_viewed==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_viewed]" value="0" <?php echo $catalog_show_viewed==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_date_added; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $catalog_show_date_added==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_date_added]" value="1" <?php echo $catalog_show_date_added==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $catalog_show_date_added==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_date_added]" value="0" <?php echo $catalog_show_date_added==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_date_modified; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $catalog_show_date_modified==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_date_modified]" value="1" <?php echo $catalog_show_date_modified==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $catalog_show_date_modified==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[catalog_show_date_modified]" value="0" <?php echo $catalog_show_date_modified==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-article">
              <div class="row">
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_article_setting; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_author; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $article_show_author==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_author]" value="1" <?php echo $article_show_author==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $article_show_author==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_author]" value="0" <?php echo $article_show_author==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_viewed; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $article_show_viewed==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_viewed]" value="1" <?php echo $article_show_viewed==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $article_show_viewed==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_viewed]" value="0" <?php echo $article_show_viewed==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_date_added; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $article_show_date_added==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_date_added]" value="1" <?php echo $article_show_date_added==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $article_show_date_added==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_date_added]" value="0" <?php echo $article_show_date_added==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_date_modified; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $article_show_date_modified==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_date_modified]" value="1" <?php echo $article_show_date_modified==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $article_show_date_modified==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_date_modified]" value="0" <?php echo $article_show_date_modified==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label><?php echo $entry_show_share; ?></label>
                          <div class="btn-group" data-toggle="buttons">
                            <label class="btn <?php echo $article_show_share_btn==1?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_share_btn]" value="1" <?php echo $article_show_share_btn==1?'checked':''; ?>><?php echo $text_on; ?></label>
                            <label class="btn <?php echo $article_show_share_btn==0?'btn-primary active':'btn-default'; ?>">
                            <input type="radio" name="penblog_setting[article_show_share_btn]" value="0" <?php echo $article_show_share_btn==0?'checked':''; ?>><?php echo $text_off; ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_article_setting_image; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_article_image_thumb; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[article_thumb_width]" value="<?php echo $article_thumb_width; ?>" placeholder="<?php echo $entry_width; ?>" id="penblog-image-thumb-width" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_article_thumb) { ?>
                            <div class="text-danger"><?php echo $error_article_thumb; ?></div>
                            <?php } ?>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[article_thumb_height]" value="<?php echo $article_thumb_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_article_thumb) { ?>
                            <div class="text-danger"><?php echo $error_article_thumb; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_article_image_popup; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[article_popup_width]" value="<?php echo $article_popup_width; ?>" placeholder="<?php echo $entry_width; ?>" id="penblog-image-popup-width" class="form-control" />
                              <span class="input-group-addon">px </span>
                              <?php if ($error_article_popup) { ?>
                              <div class="text-danger"><?php echo $error_article_popup; ?></div>
                              <?php } ?>
                            </div>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[article_popup_height]" value="<?php echo $article_popup_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                              <?php if ($error_article_popup) { ?>
                              <div class="text-danger"><?php echo $error_article_popup; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_article_additional; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[article_additional_width]" value="<?php echo $article_additional_width; ?>" placeholder="<?php echo $entry_width; ?>" id="penblog-image-list-width" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_article_additional) { ?>
                            <div class="text-danger"><?php echo $error_article_additional; ?></div>
                            <?php } ?>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[article_additional_height]" value="<?php echo $article_additional_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                            </div>
                            <?php if ($error_article_additional) { ?>
                            <div class="text-danger"><?php echo $error_article_additional; ?></div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_article_related; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[article_related_width]" value="<?php echo $article_related_width; ?>" placeholder="<?php echo $entry_width; ?>" id="penblog-image-related-width" class="form-control" />
                              <span class="input-group-addon">px </span>
                              <?php if ($error_article_related) { ?>
                              <div class="text-danger"><?php echo $error_article_related; ?></div>
                              <?php } ?>
                            </div>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[article_related_height]" value="<?php echo $article_related_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                              <?php if ($error_article_related) { ?>
                              <div class="text-danger"><?php echo $error_article_related; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Product Image -->
                      <div class="form-group required">
                        <label class="col-sm-4 control-label"><?php echo $entry_article_product; ?></label>
                        <div class="col-sm-8">
                          <div class="form-inline">
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_width; ?> </span>
                              <input type="text" name="penblog_setting[article_product_width]" value="<?php echo $article_product_width; ?>" placeholder="<?php echo $entry_width; ?>" id="penblog-image-product-width" class="form-control" />
                              <span class="input-group-addon">px </span>
                              <?php if ($error_article_product) { ?>
                              <div class="text-danger"><?php echo $error_article_product; ?></div>
                              <?php } ?>
                            </div>
                            <div class="input-group">
                              <span class="input-group-addon"><?php echo $entry_height; ?> </span>
                              <input type="text" name="penblog_setting[article_product_height]" value="<?php echo $article_product_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                              <span class="input-group-addon">px </span>
                              <?php if ($error_article_product) { ?>
                              <div class="text-danger"><?php echo $error_article_product; ?></div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_article_setting_display; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <label class="col-sm-6 control-label"><?php echo $entry_article_related_display; ?></label>
                        <div class="col-sm-6">
                          <select name="penblog_setting[article_related_display]" class="form-control">
                            <?php if($article_related_display=='grid'){ ?>
                            <option value="grid" selected>Grid</option>
                            <option value="grid_carousel">Grid Carousel</option>
                            <?php } else { ?>
                            <option value="grid">Grid</option>
                            <option value="grid_carousel" selected>Grid Carousel</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-6 control-label"><?php echo $entry_article_product_display; ?></label>
                        <div class="col-sm-6">
                          <select name="penblog_setting[article_product_display]" class="form-control">
                            <?php if($article_product_display=='grid'){ ?>
                            <option value="grid" selected>Grid</option>
                            <option value="grid_carousel">Grid Carousel</option>
                            <?php } else { ?>
                            <option value="grid">Grid</option>
                            <option value="grid_carousel" selected>Grid Carousel</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-video">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $entry_video_youtube_setting; ?></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label class="col-md-4"><?php echo $entry_youtube_show_control; ?></label>
                          <div class="col-md-8">
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn <?php echo $youtube_show_control==1?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_show_control]" value="1" <?php echo $youtube_show_control==1?'checked':''; ?>><?php echo $text_on; ?></label>
                              <label class="btn <?php echo $youtube_show_control==0?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_show_control]" value="0" <?php echo $youtube_show_control==0?'checked':''; ?>><?php echo $text_off; ?></label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="col-md-4"><?php echo $entry_youtube_fullsreen; ?></label>
                          <div class="col-md-8">
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn <?php echo $youtube_allow_fullsreen==1?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_allow_fullsreen]" value="1" <?php echo $youtube_allow_fullsreen==1?'checked':''; ?>><?php echo $text_on; ?></label>
                              <label class="btn <?php echo $youtube_allow_fullsreen==0?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_allow_fullsreen]" value="0" <?php echo $youtube_allow_fullsreen==0?'checked':''; ?>><?php echo $text_off; ?></label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label class="col-md-4"><?php echo $entry_youtube_related_video; ?></label>
                          <div class="col-md-8">
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn <?php echo $youtube_related_video==1?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_related_video]" value="1" <?php echo $youtube_related_video==1?'checked':''; ?>><?php echo $text_on; ?></label>
                              <label class="btn <?php echo $youtube_related_video==0?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_related_video]" value="0" <?php echo $youtube_related_video==0?'checked':''; ?>><?php echo $text_off; ?></label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <label class="col-md-4"><?php echo $entry_youtube_autohide; ?></label>
                          <div class="col-md-8">
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn <?php echo $youtube_autohide==1?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_autohide]" value="1" <?php echo $youtube_autohide==1?'checked':''; ?>><?php echo $text_on; ?></label>
                              <label class="btn <?php echo $youtube_autohide==0?'btn-primary active':'btn-default'; ?>">
                              <input type="radio" name="penblog_setting[youtube_autohide]" value="0" <?php echo $youtube_autohide==0?'checked':''; ?>><?php echo $text_off; ?></label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-6">
                          <label><?php echo $entry_youtube_template; ?></label>
                          <select name="penblog_setting[youtube_template]" class="form-control">
                            <option value="dark" <?php echo $youtube_template=='dark'?'selected':''; ?>>Dark</option>
                            <option value="light" <?php echo $youtube_template=='light'?'selected':''; ?>>Light</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                          <label><?php echo $entry_youtube_quanlity; ?></label>
                          <select name="penblog_setting[youtube_quanlity]" class="form-control">
                            <option value="ap=%2526fmt%3D18" <?php echo $youtube_quanlity=='ap=%2526fmt%3D18'?'selected':''; ?>>High-Quality</option>
                            <option value="hd=1" <?php echo $youtube_quanlity=='hd=1'?'selected':''; ?>>High-Definition</option>
                            <option value="vq=hd1080" <?php echo $youtube_quanlity=='vq=hd1080'?'selected':''; ?>>High-Definition 1080p</option>
                            <option value="vq=hd720" <?php echo $youtube_quanlity=='vq=hd720'?'selected':''; ?>>High-Definition 720p</option>
                            <option value="vq=hd480" <?php echo $youtube_quanlity=='vq=hd480'?'selected':''; ?>>High-Definition 480p</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>