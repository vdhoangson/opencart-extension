<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-attribute" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary">
          <i class="fa fa-save"></i>
        </button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default">
          <i class="fa fa-reply"></i>
        </a>
      </div>
      <h1>
        <?php echo $heading_title; ?>
      </h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li>
          <a href="<?php echo $breadcrumb['href']; ?>">
            <?php echo $breadcrumb['text']; ?>
          </a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger">
      <i class="fa fa-exclamation-circle"></i>
      <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">
          <i class="fa fa-pencil"></i>
          <?php echo $text_form; ?>
        </h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li>
              <a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab">
                <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>"
                />
                <?php echo $language['name']; ?>
              </a>
            </li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php foreach ($languages as $language) { ?>
            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>">
                  <?php echo $entry_title; ?>
                </label>
                <div class="col-sm-10">
                  <input type="text" name="tab_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($tab_description[$language['language_id']]) ? $tab_description[$language['language_id']]['title'] : ''; ?>"
                    class="form-control" />
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                  <span class="text-danger">
                    <?php echo $error_title[$language['language_id']]; ?>
                  </span>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>">
                  <?php echo $entry_content; ?>
                </label>
                <div class="col-sm-10">
                  <textarea name="tab_description[<?php echo $language['language_id']; ?>][content]" id="content<?php echo $language['language_id']; ?>"
                    class="form-control summernote">
                    <?php echo isset($tab_description[$language['language_id']]) ? $tab_description[$language['language_id']]['content'] : ''; ?>
                  </textarea>
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="control-label col-sm-2">
                <?php echo $entry_position; ?>
              </label>
              <div class="col-sm-10">
                <select name="position" class="form-control">
                  <option value="1" <?php echo $position=='1' ? 'selected="selected"': ''; ?>>Before all default tabs</option>
                  <option value="2" <?php echo $position=='2' ? 'selected="selected"': ''; ?>>After Description tab</option>
                  <option value="3" <?php echo $position=='3' ? 'selected="selected"': ''; ?>>After Specification tab</option>
                  <option value="4" <?php echo $position=='4' ? 'selected="selected"': ''; ?>>After Reviews tab</option>
                  <option value="5" <?php echo $position=='5' ? 'selected="selected"': ''; ?>>After all default tabs</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2">
                <?php echo $entry_add_to_compare; ?>
              </label>
              <div class="col-sm-10">
                <select name="compare" class="form-control">
                  <option value="1" <?php echo $compare==1? 'selected="selected"': ''; ?>>
                    <?php echo $text_yes; ?>
                  </option>
                  <option value="0" <?php echo $compare==0? 'selected="selected"': ''; ?>>
                    <?php echo $text_no; ?>
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2">
                <?php echo $entry_sort_order; ?>
              </label>
              <div class="col-sm-10">
                <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2">
                <?php echo $entry_status; ?>
              </label>
              <div class="col-sm-10">
                <select name="status" class="form-control">
                  <option value="1" <?php echo $status==1? 'selected="selected"': ''; ?>>
                    <?php echo $text_enabled; ?>
                  </option>
                  <option value="0" <?php echo $status==0? 'selected="selected"': ''; ?>>
                    <?php echo $text_disabled; ?>
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
              <div class="col-sm-10">
                <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                <div id="tab-category" class="well well-sm" style="height: 150px; overflow: auto;">
                  <?php foreach ($tab_categories as $category) { ?>
                  <div id="tab-category<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                    <input type="hidden" name="category[]" value="<?php echo $category['category_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-product"><?php echo $entry_product; ?></label>
              <div class="col-sm-10">
                <input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
                <div id="tab-product" class="well well-sm" style="height: 150px; overflow: auto;">
                  <?php foreach ($tab_products as $product) { ?>
                  <div id="tab-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                    <input type="hidden" name="product[]" value="<?php echo $product['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  <!--
  $('#language a:first').tab('show');
  // Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
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
		$('input[name=\'category\']').val('');

		$('#tab-category' + item['value']).remove();

		$('#tab-category').append('<div id="tab-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category[]" value="' + item['value'] + '" /></div>');
	}
});

$('#tab-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
// Product
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val('');

		$('#tab-product' + item['value']).remove();

		$('#tab-product').append('<div id="tab-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');
	}
});

$('#tab-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
  //-->
</script>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>