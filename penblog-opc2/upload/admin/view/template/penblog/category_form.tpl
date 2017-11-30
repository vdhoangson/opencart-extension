<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
   <div class="page-header">
      <div class="container-fluid">
         <div class="pull-right">
            <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
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
      <div class="panel panel-default">
         <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
         </div>
         <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
               <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                  <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                  <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?> & <?php echo $entry_store; ?></a></li>
               </ul>
               <div class="tab-content">
                  <div class="tab-pane active in" id="tab-general">
                     <ul class="nav nav-tabs" id="language">
                        <?php foreach ($languages as $language) { ?>
                        <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                        <?php } ?>
                     </ul>
                     <div class="tab-content">
                        <?php foreach ($languages as $language) { ?>
                        <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                           <div class="col-md-6 col-sm-6">
                              <div class="form-group required">
                                 <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                                 <div class="col-sm-10">
                                    <input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                                    <?php if (isset($error_name[$language['language_id']])) { ?>
                                    <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                    <?php } ?>
                                 </div>
                                 <?php if ($error_name) { ?>
                                 <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_name; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 </div>
                                 <?php } ?>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                 <div class="col-sm-10">
                                    <textarea name="category_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-6">
                              <div class="form-group required">
                                 <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                 <div class="col-sm-10">
                                    <input type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                    <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                    <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                 <div class="col-sm-10">
                                    <textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                 <div class="col-sm-10">
                                    <textarea name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="tab-data">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                           <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                           <div class="col-sm-10">
                              <input type="text" name="penblog_path" value="<?php echo $penblog_path; ?>" placeholder="<?php echo $entry_parent; ?>" id="input-parent" class="form-control" />
                              <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <div class="col-sm-6">
                              <label class="control-label col-sm-4" for="input-top"><?php echo $entry_top; ?></label>
                              <div class="col-sm-8">
                                 <div class="btn-group" data-toggle="buttons">
                                    <label class="btn <?php echo $top==1?'btn-primary active':'btn-default'; ?>">
                                    <input type="radio" name="top" value="1" <?php echo $top==1?'checked':''; ?>><?php echo $text_on; ?></label>
                                    <label class="btn <?php echo $top==0?'btn-primary active':'btn-default'; ?>">
                                    <input type="radio" name="top" value="0" <?php echo $top==0?'checked':''; ?>><?php echo $text_off; ?></label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <label class="control-label col-sm-4" for="input-status"><?php echo $entry_status; ?></label>
                              <div class="col-sm-8">
                                 <div class="btn-group" data-toggle="buttons">
                                    <label class="btn <?php echo $status==1?'btn-primary active':'btn-default'; ?>">
                                    <input type="radio" name="status" value="1" <?php echo $status==1?'checked':''; ?>><?php echo $text_on; ?></label>
                                    <label class="btn <?php echo $status==0?'btn-primary active':'btn-default'; ?>">
                                    <input type="radio" name="status" value="0" <?php echo $status==0?'checked':''; ?>><?php echo $text_off; ?></label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="col-sm-6">
                              <label class="col-sm-4 control-label" for="input-column"><?php echo $entry_column; ?></label>
                              <div class="col-sm-8">
                                 <select name="column" class="form-control" id="input-column">
                                    <?php for($i=1;$i<=3;$i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $i==$column?'selected':''; ?>><?php echo $i; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <label class="col-sm-4 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                              <div class="col-sm-8">
                                 <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-sm-2 control-label" for="input-keyword"><?php echo $entry_keyword; ?></label>
                           <div class="col-sm-10">
                              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                           </div>
                           <?php if ($error_keyword) { ?>
                           <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_keyword; ?>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab-design">
                     <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                        <div class="col-sm-10">
                           <div class="well well-sm" style="height: 150px; overflow: auto;">
                              <div class="checkbox">
                                 <label>
                                 <?php if (in_array(0, $category_store)) { ?>
                                 <input type="checkbox" name="category_store[]" value="0" checked="checked" />
                                 <?php echo $text_default; ?>
                                 <?php } else { ?>
                                 <input type="checkbox" name="category_store[]" value="0" />
                                 <?php echo $text_default; ?>
                                 <?php } ?>
                                 </label>
                              </div>
                              <?php foreach ($stores as $store) { ?>
                              <div class="checkbox">
                                 <label>
                                 <?php if (in_array($store['store_id'], $category_store)) { ?>
                                 <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                 <?php echo $store['name']; ?>
                                 <?php } else { ?>
                                 <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" />
                                 <?php echo $store['name']; ?>
                                 <?php } ?>
                                 </label>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                           <thead>
                              <tr>
                                 <td class="text-left"><?php echo $entry_store; ?></td>
                                 <td class="text-left"><?php echo $entry_layout; ?></td>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td class="text-left"><?php echo $text_default; ?></td>
                                 <td class="text-left">
                                    <select name="category_layout[0]" class="form-control">
                                       <option value=""></option>
                                       <?php foreach ($layouts as $layout) { ?>
                                       <?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
                                       <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                       <?php } else { ?>
                                       <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                       <?php } ?>
                                       <?php } ?>
                                    </select>
                                 </td>
                              </tr>
                              <?php foreach ($stores as $store) { ?>
                              <tr>
                                 <td class="text-left"><?php echo $store['name']; ?></td>
                                 <td class="text-left">
                                    <select name="category_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                                       <option value=""></option>
                                       <?php foreach ($layouts as $layout) { ?>
                                       <?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']) { ?>
                                       <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                       <?php } else { ?>
                                       <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                       <?php } ?>
                                       <?php } ?>
                                    </select>
                                 </td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div>
      </div>
   </div>
   <script type="text/javascript"><!--
      <?php foreach ($languages as $language) { ?>
      $('#input-description<?php echo $language['language_id']; ?>').summernote({
        height: 300
      });
      <?php } ?>
      //--></script>
   <script type="text/javascript"><!--
      $('input[name=\'penblog_path\']').autocomplete({
        'source': function(request, response) {
          $.ajax({
            url: 'index.php?route=penblog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
              json.unshift({
                category_id: 0,
                name: '<?php echo $text_none; ?>'
              });

              response($.map(json, function(item) {
                return {
                  label: item['name'],
                  value: item['category_id']
                }
              }));
            }
          });
        },
        'select': function(item) {
          $('input[name=\'penblog_path\']').val(item['label']);
          $('input[name=\'parent_id\']').val(item['value']);
        }
      });
      //--></script>
   <script type="text/javascript"><!--
      $('#language a:first').tab('show');
      //--></script>
</div>
<?php echo $footer; ?>