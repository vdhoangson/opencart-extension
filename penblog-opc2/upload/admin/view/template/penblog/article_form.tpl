<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-article" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-article" class="form-horizontal">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
						<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
						<li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
						<li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?> & <?php echo $entry_store; ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-general">
							<ul class="nav nav-tabs" id="language">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
									<div class="col-sm-8">
										<div class="form-group required">
											<div class="col-sm-12">
												<label class="control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
												<input type="text" name="article_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
												<?php if (isset($error_name[$language['language_id']])) { ?>
												<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<label class="control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_short_description; ?></label>
												<textarea name="article_description[<?php echo $language['language_id']; ?>][short_description]" rows="5" placeholder="<?php echo $entry_short_description; ?>" id="input-short-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['short_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group required">
											<div class="col-sm-12">
												<label class="control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
												<textarea name="article_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['description'] : ''; ?></textarea>
												<?php if (isset($error_description[$language['language_id']])) { ?>
												<div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<div class="col-sm-12">
												<label class="control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
												<textarea name="article_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<label class="control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
												<textarea name="article_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<label class="control-label" for="input-tag<?php echo $language['language_id']; ?>"><?php echo $entry_tag; ?></label>
												<input type="text" name="article_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" class="form-control" />
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="tab-pane" id="tab-data">
							<div class="form-group">
								<div class="col-sm-4">
									<label class="control-label" for="input-date-add"><?php echo $entry_date_added; ?></label>
									<div class="input-group date">
										<input type="text" name="date_added" value="<?php echo $date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" class="form-control" data-date-format="YYYY-MM-DD">
										<span class="input-group-btn">
										<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
								<div class="col-sm-4">
									<label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
									<div class="input-group date">
										<input type="text" name="date_modified" value="<?php echo $date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" class="form-control" data-date-format="YYYY-MM-DD">
										<span class="input-group-btn">
										<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
								<div class="col-sm-4">
									<label class="control-label" for="input-date-public"><?php echo $entry_date_public; ?></label>
									<div class="input-group date">
										<input type="text" name="date_public" value="<?php echo $date_public; ?>" placeholder="<?php echo $entry_date_public; ?>" class="form-control" data-date-format="YYYY-MM-DD">
										<span class="input-group-btn">
										<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<!-- Author -->
									<div class="form-group">
										<label class="col-sm-4 control-label" for="input-author"><?php echo $entry_author; ?></label>
										<div class="col-sm-8">
											<select name="article_author" id="input-author" class="form-control">
												<?php foreach($authors as $author){ ?>
												<?php if($author['user_id'] == $article_author){ ?>
												<option value="<?php echo $author['user_id']; ?>" selected="selected"><?php echo $author['username']; ?></option>
												<?php } else { ?>
												<option value="<?php echo $author['user_id']; ?>" ><?php echo $author['username']; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<!-- Keyword -->
									<div class="form-group">
										<label class="col-sm-4 control-label" for="input-keyword"><?php echo $entry_keyword; ?></label>
										<div class="col-sm-8">
											<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
										</div>
									</div>
									<!-- Sortorder -->
									<div class="form-group">
										<label class="col-sm-4 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
										<div class="col-sm-8">
											<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4"><?php echo $entry_login_to_view; ?></label>
										<div class="col-md-8">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn <?php echo $login_to_view==1?'btn-primary active':'btn-default'; ?>">
												<input type="radio" name="login_to_view" value="1" <?php echo $login_to_view==1?'checked':''; ?>><?php echo $text_on; ?></label>
												<label class="btn <?php echo $login_to_view==0?'btn-primary active':'btn-default'; ?>">
												<input type="radio" name="login_to_view" value="0" <?php echo $login_to_view==0?'checked':''; ?>><?php echo $text_off; ?></label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-4"><?php echo $entry_allow_comment; ?></label>
										<div class="col-md-8">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn <?php echo $allow_comment==1?'btn-primary active':'btn-default'; ?>">
												<input type="radio" name="allow_comment" value="1" <?php echo $allow_comment==1?'checked':''; ?>><?php echo $text_on; ?></label>
												<label class="btn <?php echo $allow_comment==0?'btn-primary active':'btn-default'; ?>">
												<input type="radio" name="allow_comment" value="0" <?php echo $allow_comment==0?'checked':''; ?>><?php echo $text_off; ?></label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-4"><?php echo $entry_status; ?></label>
										<div class="col-md-8">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn <?php echo $status==1?'btn-primary active':'btn-default'; ?>">
												<input type="radio" name="status" value="1" <?php echo $status==1?'checked':''; ?>><?php echo $text_on; ?></label>
												<label class="btn <?php echo $status==0?'btn-primary active':'btn-default'; ?>">
												<input type="radio" name="status" value="0" <?php echo $status==0?'checked':''; ?>><?php echo $text_off; ?></label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label class="control-label" for="input-category"><?php echo $entry_category; ?></label>
									<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
									<div id="article-category" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($article_categories as $article_category) { ?>
										<div id="article-category<?php echo $article_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $article_category['name']; ?>
											<input type="hidden" name="article_category[]" value="<?php echo $article_category['category_id']; ?>" />
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-sm-6">
									<label class="control-label" for="input-related"><?php echo $entry_related; ?></label>
									<input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />
									<div id="article-related" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($article_relateds as $article_related) { ?>
										<div id="article-related<?php echo $article_related['article_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $article_related['name']; ?>
											<input type="hidden" name="article_related[]" value="<?php echo $article_related['article_id']; ?>" />
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<!-- Product -->
								<div class="col-md-6">
									<label class="control-label" for="input-related"><?php echo $entry_product; ?></label>
									<input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="product" class="form-control" />
									<div id="article-product" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($products as $product) { ?>
										<div id="article-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
											<input type="hidden" name="article_product[]" value="<?php echo $product['product_id']; ?>" />
										</div>
										<?php } ?>
									</div>
								</div>
								<!-- Download -->
								<div class="col-md-6">
									<label class="control-label" for="input-related"><?php echo $entry_download; ?></label>
									<input type="text" name="download" value="" placeholder="<?php echo $entry_download; ?>" id="download" class="form-control" />
									<div id="article-download" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($downloads as $download) { ?>
										<div id="article-download<?php echo $download['download_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $download['name']; ?>
											<input type="hidden" name="article_download[]" value="<?php echo $download['download_id']; ?>" />
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<label class="control-label" for="input-related"><?php echo $entry_poll; ?></label>
									<select name="poll_id" class="form-control">
										<option value=""><?php echo $text_none; ?></option>
										<?php foreach($polls as $poll){ ?>
										<option value="<?php echo $poll['poll_id']; ?>" <?php echo ($poll_id==$poll['poll_id'])?'selected':''; ?>><?php echo $poll['question']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<!-- Tab Image -->
						<div class="tab-pane" id="tab-image">
							<div class="form-group">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="col-sm-4 control-label" for="image-type"><?php echo $entry_image_type; ?></label>
										<div class="col-sm-8">
											<select name="image[type]" id="image-type" class="form-control">
												<?php foreach($image_types as $value){ ?>
												<?php if($value == $image['type']){ ?>
												<option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
												<?php } else { ?>
												<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<label class="col-sm-4 control-label" for="input-featured-image"><?php echo $entry_image; ?></label>
									<div class="col-sm-8">
										<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail image_featured"><img src="<?php echo $thumb; ?>" data-placeholder="<?php echo $placeholder; ?>" /></a>
										<input type="hidden" name="image[image]" value="<?php echo $image['image']; ?>" id="input-featured-image" />
										<input type="text" name="image[youtube]" value="<?php echo $image['youtube']; ?>" class="form-control youtube_featured hidden" data-placeholder="Youtube" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="col-sm-4 control-label" for="image-main-type"><?php echo $entry_image_type; ?></label>
										<div class="col-sm-8">
											<select name="main_image[type]" id="main-type" class="form-control">
												<?php foreach($image_types as $value){ ?>
												<?php if($value == $main_image['type']){ ?>
												<option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
												<?php } else { ?>
												<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<label class="col-sm-4 control-label" for="input-main-image"><?php echo $entry_main_image; ?></label>
									<div class="col-sm-8">
										<a href="" id="thumb-main-image" data-toggle="image" class="img-thumbnail main_image"><img src="<?php echo $thumb_main_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
										<input type="hidden" name="main_image[image]" value="<?php echo $main_image['image']; ?>" id="input-main-image" />
										<input type="text" name="main_image[youtube]" value="<?php echo $main_image['youtube']; ?>" class="form-control main_youtube hidden" data-placeholder="Youtube" />
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table id="images" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<td class="text-left"><?php echo $entry_image; ?></td>
											<td class="text-right"><?php echo $entry_sort_order; ?></td>
											<td></td>
										</tr>
									</thead>
									<tbody>
										<?php $image_row = 0; ?>
										<?php foreach ($article_images as $article_image) { ?>
										<tr id="image-row<?php echo $image_row; ?>">
											<td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $article_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="article_image[<?php echo $image_row; ?>][image]" value="<?php echo $article_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
											<td class="text-right"><input type="text" name="article_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $article_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
											<td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
										</tr>
										<?php $image_row++; ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2"></td>
											<td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<!-- Tab design -->
						<div class="tab-pane" id="tab-design">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
								<div class="col-sm-10">
									<div class="well well-sm" style="height: 150px; overflow: auto;">
										<div class="checkbox">
											<label>
											<?php if (in_array(0, $article_store)) { ?>
											<input type="checkbox" name="article_store[]" value="0" checked="checked" />
											<?php echo $text_default; ?>
											<?php } else { ?>
											<input type="checkbox" name="article_store[]" value="0" />
											<?php echo $text_default; ?>
											<?php } ?>
											</label>
										</div>
										<?php foreach ($stores as $store) { ?>
										<div class="checkbox">
											<label>
											<?php if (in_array($store['store_id'], $article_store)) { ?>
											<input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
											<?php echo $store['name']; ?>
											<?php } else { ?>
											<input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" />
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
												<select name="article_layout[0]" class="form-control">
													<option value=""></option>
													<?php foreach ($layouts as $layout) { ?>
													<?php if (isset($article_layout[0]) && $article_layout[0] == $layout['layout_id']) { ?>
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
												<select name="article_layout[<?php echo $store['store_id']; ?>]" class="form-control">
													<option value=""></option>
													<?php foreach ($layouts as $layout) { ?>
													<?php if (isset($article_layout[$store['store_id']]) && $article_layout[$store['store_id']] == $layout['layout_id']) { ?>
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
		$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
		<?php } ?>
		//--></script>
	<script type="text/javascript"><!--
		function image_upload(field, thumb) {
		  $('#dialog').remove();
		
		  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
		
		  $('#dialog').dialog({
		    name: '<?php echo $text_image_manager; ?>',
		    close: function (event, ui) {
		      if ($('#' + field).attr('value')) {
		        $.ajax({
		          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
		          dataType: 'text',
		          success: function(text) {
		            $('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
		          }
		        });
		      }
		    },
		    bgiframe: false,
		    width: 800,
		    height: 400,
		    resizable: false,
		    modal: false
		  });
		};
		//--></script>
	<script type="text/javascript">
		// Related
		$('input[name=\'related\']').autocomplete({
		  'source': function(request, response) {
		    $.ajax({
		      url: 'index.php?route=penblog/article/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
		      dataType: 'json',
		      success: function(json) {
		        response($.map(json, function(item) {
		          return {
		            label: item['name'],
		            value: item['article_id']
		          }
		        }));
		      }
		    });
		  },
		  'select': function(item) {
		    $('input[name=\'related\']').val('');
		
		    $('#article-related' + item['value']).remove();
		
		    $('#article-related').append('<div id="article-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_related[]" value="' + item['value'] + '" /></div>');
		  }
		});
		
		$('#article-related').delegate('.fa-minus-circle', 'click', function() {
		  $(this).parent().remove();
		});
		
		// Category
		$('input[name=\'category\']').autocomplete({
		  'source': function(request, response) {
		    $.ajax({
		      url: 'index.php?route=penblog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
		
		    $('#article-category' + item['value']).remove();
		
		    $('#article-category').append('<div id="article-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_category[]" value="' + item['value'] + '" /></div>');
		  }
		});
		
		$('#article-category').delegate('.fa-minus-circle', 'click', function() {
		  $(this).parent().remove();
		});
		
		
		$('#article-related div img').delegate('.fa-minus-circle', 'click', function() {
			$(this).parent().remove();
		});
		
		// Download
		$('input[name=\'download\']').autocomplete({
		  'source': function(request, response) {
		    $.ajax({
		      url: 'index.php?route=penblog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
		      dataType: 'json',
		      success: function(json) {
		        response($.map(json, function(item) {
		          return {
		            label: item['name'],
		            value: item['download_id']
		          }
		        }));
		      }
		    });
		  },
		  'select': function(item) {
		    $('input[name=\'download\']').val('');
		
		    $('#article-download' + item['value']).remove();
		
		    $('#article-download').append('<div id="article-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_download[]" value="' + item['value'] + '" /></div>');
		  }
		});
		
		$('#article-download').delegate('.fa-minus-circle', 'click', function() {
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
		
		    $('#article-product' + item['value']).remove();
		
		    $('#article-product').append('<div id="article-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_product[]" value="' + item['value'] + '" /></div>');
		  }
		});
		
		$('#article-product').delegate('.fa-minus-circle', 'click', function() {
		  $(this).parent().remove();
		});

		// Poll
		$('input[name=\'poll\']').autocomplete({
		  'source': function(request, response) {
		    $.ajax({
		      url: 'index.php?route=penblog/poll/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
		      dataType: 'json',
		      success: function(json) {
		        response($.map(json, function(item) {
		          return {
		            label: item['question'],
		            value: item['poll_id']
		          }
		        }));
		      }
		    });
		  },
		  'select': function(item) {
		    $('input[name=\'poll\']').val('');
		
		    $('#article-poll' + item['value']).remove();
		
		    $('#article-poll').append('<div id="article-poll' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_poll[]" value="' + item['value'] + '" /></div>');
		  }
		});
		
		$('#article-poll').delegate('.fa-minus-circle', 'click', function() {
		  $(this).parent().remove();
		});
	</script>
	<script type="text/javascript"><!--
		var image_row = <?php echo $image_row; ?>;
		
		function addImage() {
			html  = '<tr id="image-row' + image_row + '">';
			html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="article_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
			html += '  <td class="text-right"><input type="text" name="article_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
			html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
			html += '</tr>';
		
			$('#images tbody').append(html);
		
			image_row++;
		}
		//--></script>
	<script type="text/javascript"><!--
		$('.date').datetimepicker({
			pickTime: false
		});
		
		$('.time').datetimepicker({
			pickDate: false
		});
		
		$('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});
		//--></script>
	<script type="text/javascript"><!--
		$('#language a:first').tab('show');
		$('#option a:first').tab('show');
		//--></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#image-type").trigger("change");
			$("#main-type").trigger("change");
		});
	</script>
	<script type="text/javascript">
		$("#image-type").change(function(){
			var val = $("#image-type").val();
			if(val=='image'){
				$('.image_featured').removeClass('hidden');
				$('.youtube_featured').addClass('hidden');
			} else if(val=='youtube'){
				$('.image_featured').addClass('hidden');
				$('.youtube_featured').removeClass('hidden');
			}
		
		});
		
		$("#main-type").change(function(){
			var val = $("#main-type").val();
			if(val=='image'){
				$('.main_image').removeClass('hidden');
				$('.main_youtube').addClass('hidden');
			} else if(val=='youtube'){
				$('.main_image').addClass('hidden');
				$('.main_youtube').removeClass('hidden');
			}
		});
	</script>
</div>
<?php echo $footer; ?>