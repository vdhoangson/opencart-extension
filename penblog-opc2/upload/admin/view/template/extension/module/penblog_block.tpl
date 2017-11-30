<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<script type="text/javascript" src="view/penblog/js/multiselect.js"></script>
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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="row">
	    <div class="col-md-3">
	    	<div class="panel panel-default">
	    		<div class="panel-heading">
			        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_installed_block; ?></h3>
		      	</div>
		      	<div class="panel-body">
		      		<?php if(!empty($modules_installed)){ ?>
		      		<div class="list-group">
		      		<?php foreach ($modules_installed as $module) { ?>
						<a href="<?php echo $module['edit']; ?>" class="list-group-item <?php echo $module_id == $module['module_id']?'active':''; ?>"><?php echo $module['name']; ?></a>
					<?php } ?>
					</div>
					<?php } else { ?>
						<?php echo $text_empty; ?>
					<?php } ?>
		      	</div>
		      	<div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div>
	    	</div>
	    </div>
	    <div class="col-md-9">
	    	<form action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data" id="form-article-set" class="form-horizontal">
			    <div class="panel panel-default">
			      <div class="panel-heading">
			        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			        <div class="pull-right">
			        	<?php if($block){ ?>
			        	<a href="<?php echo $add_new_module; ?>" data-toggle="tooltip" title="<?php echo $button_add_module; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?php echo $button_add_module; ?></a>
				        <button type="submit" form="form-article-set" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary btn-xs"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
				        <?php } ?>
				        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default btn-xs"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
				    </div>
			      </div>
			      <div class="panel-body">
			      	<div class="row">
			      		<?php $col = 6; if($module_id!=0){$col=12;} ?>
			      		<div class="col-md-<?php echo $col; ?>">
			      			<div class="form-group required">
				      			<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
					            <div class="col-sm-10">
					              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
					              <?php if ($error_name) { ?>
					              <div class="text-danger"><?php echo $error_name; ?></div>
					              <?php } ?>
					            </div>
					        </div>
					        <div class="form-group required">
								<label class="col-sm-2 col-md-2 control-label"><?php echo $entry_title; ?></label>
								<div class="col-md-10 col-sm-10">
			                	<?php foreach ($languages as $language) { ?>
				                	<div class="input-group">
										<span class="input-group-addon" id="language-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" aria-describedby="language-<?php echo $language['language_id']; ?>" />
									</div>
									<?php if (isset($error_title[$language['language_id']])) { ?>
			                      		<div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
			                      	<?php } ?>
				            	<?php } ?>
				            	</div>
				            </div>
				            <div class="form-group">
					            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
					            <div class="btn-group col-md-10" data-toggle="buttons">
		                            <label class="btn <?php echo $status==1?'btn-primary active':'btn-default'; ?>">
		                            <input type="radio" name="status" value="1" <?php echo $status==1?'checked':''; ?>><?php echo $text_on; ?></label>
		                            <label class="btn <?php echo $status==0?'btn-danger active':'btn-default'; ?>">
		                            <input type="radio" name="status" value="0" <?php echo $status==0?'checked':''; ?>><?php echo $text_off; ?></label>
		                        </div>
					        </div>
			      		</div>
			      		<?php if($module_id==0){ ?>
			      		<div class="col-md-6">
				      		<?php echo $text_select; ?>
				    		<select multiple="multiple" style="width:100%; height:150px;" class="form-control">
				    			<?php foreach($elements as $element){ ?>
				    			<option value="<?php echo $element['href']; ?>" onclick="window.location = this.value;" <?php echo $element['key']==$block?'selected':''; ?>><?php echo $element['title']; ?></option>
				    			<?php } ?>
				    		</select>
			    		</div>
			    		<?php } ?>
			    	</div>
			    	<hr/>
			    	<div class="row">
			    		<div class="col-md-12">
			    			<?php echo $module_content; ?>
			    		</div>
			    	</div>
			      </div>
			      <div class="panel-footer">Pen Blog &copy; 2016 - <a href="http://pencms.com" target="_blank">pencms.com</a></div>
			    </div>
		    </form>
	    </div>
    </div>
  </div>
 </div>

 <script type="text/javascript">

    jQuery(document).ready(function($) {
    	$('.multiselect_category').multiselect({
			search: {
				left: '<input type="text" class="form-control" placeholder="Search..." />',
				right: '<input type="text" class="form-control" placeholder="Search..." />',
			}
    	});
    });

    jQuery(document).ready(function($) {
    	$('.multiselect_article').multiselect({
			search: {
				left: '<input type="text" class="form-control" placeholder="Search..." />',
				right: '<input type="text" class="form-control" placeholder="Search..." />',
			}
    	});
    });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#input-theme").trigger('change');
		$("#input-order").trigger('change');
	});

	$("#input-order").change(function(){
		var value = $('#input-order').val();

		switch(value){
			//Default
			case 'default':
				$('.tab_article').removeClass('hidden');
				$('#multiselect_to_article').prop('disabled', false);
			break;
			//Latest
			case 'latest':
				$('.tab_article').addClass('hidden');
				$('#multiselect_to_article').prop('disabled', true);
			break;
			//Most view
			case 'most_view':
				$('.tab_article').addClass('hidden');
				$('#multiselect_to_article').prop('disabled', true);
			break;
		}
	});

	$("#input-theme").change(function(){
		var val = $('#input-theme').val();

		switch(val){
			//Default
			case 'default':
				$('.tab_article').addClass('hidden');
				$('.tab_category').addClass('hidden');
				$('.slider').addClass('hidden');
				$('#multiselect_to_article').prop('disabled', false);
				$('#multiselect_to_category').prop('disabled', true);
				$('.default').removeClass('hidden');
				break;
			// Tab article
			case 'tab_article':
				$('.tab_category').addClass('hidden');
				$('.default').addClass('hidden');
				$('.slider').addClass('hidden');
				$('#multiselect_to_category').prop('disabled', true);
				$('#multiselect_to_article').prop('disabled', false);
				$('.tab_article').removeClass('hidden');
				break;
			// Tab category
			case 'tab_category':
				$('.default').addClass('hidden');
				$('.tab_article').addClass('hidden');
				$('.slider').addClass('hidden');
				$('#multiselect_to_article').prop('disabled', true);
				$('#multiselect_to_category').prop('disabled', false);
				$('.tab_category').removeClass('hidden');
				break;
			// Carousel
			case 'article_carousel':
				$('.default').addClass('hidden');
				$('.tab_category').addClass('hidden');
				$('.slider').addClass('hidden');
				$('#multiselect_to_category').prop('disabled', true);
				$('#multiselect_to_article').prop('disabled', false);
				$('.article_carousel').removeClass('hidden');
				break;
			//slide show
			case 'slider':
				$('.default').addClass('hidden');
				$('.tab_article').addClass('hidden');
				$('.tab_category').addClass('hidden');
				$('#multiselect_to_category').prop('disabled', true);
				$('#multiselect_to_article').prop('disabled', false);
				$('.slider').removeClass('hidden');
				break;
			//category
			case 'category':
				$('.default').addClass('hidden');
				$('.tab_article').addClass('hidden');
				$('.tab_category').addClass('hidden');
				$('#multiselect_to_category').prop('disabled', false);
				$('#multiselect_to_article').prop('disabled', true);
				$('.category').removeClass('hidden');
				break;
		}
	});
</script>
<script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>