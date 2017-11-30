<input type="hidden" name="block" value="tab_category">
<div class="form-group">
	<label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
	<div class="col-sm-10">
	<div class="col-sm-4">
		<select name="" class="multiselect_category form-control" size="8" multiple="multiple" data-right="#multiselect_to_category" data-right-all="#right_All_category" data-right-selected="#right_Selected_category" data-left-all="#left_All_category" data-left-selected="#left_Selected_category">
			<?php if($categories){ ?>
			<?php foreach($categories as $category){ ?>
			<?php if(!in_array($category['category_id'], $block_categories)){ ?>
			<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
			<?php } ?>
			<?php } ?>
			<?php } ?>
		</select>
	</div>

	<div class="col-sm-2">
		<button type="button" id="right_All_category" class="btn btn-block btn-primary"><i class="fa fa-angle-double-right fa-2x"></i></button>
		<button type="button" id="right_Selected_category" class="btn btn-block"><i class="fa fa-angle-right fa-2x"></i></button>
		<button type="button" id="left_Selected_category" class="btn btn-block"><i class="fa fa-angle-left fa-2x"></i></button>
		<button type="button" id="left_All_category" class="btn btn-block btn-danger"><i class="fa fa-angle-double-left fa-2x"></i></button>
	</div>

	<div class="col-xs-4">
		<select name="block_data[block_categories][]" id="multiselect_to_category" class="form-control" size="8" multiple="multiple">
			<?php foreach($categories as $category){ ?>
			<?php if(in_array($category['category_id'], $block_categories)){ ?>
			<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
			<?php } ?>
			<?php } ?>
		</select>
	</div>
	</div>
</div>
<div class="form-group">
	<div class="col-md-4">
		<label class="col-sm-2 control-label" for="input-display"><?php echo $entry_display; ?></label>
		<div class="col-sm-10">
			<select name="block_data[display]" id="input-display" class="form-control">
				<?php if($display == "list"){ ?>
	        <option value="list" selected="selected"><?php echo $text_display_list; ?></option>
	        <option value="grid"><?php echo $text_display_grid; ?></option>
	        <?php } else { ?>
	        <option value="list"><?php echo $text_display_list; ?></option>
	        <option value="grid" selected="selected"><?php echo $text_display_grid; ?></option>
	        <?php } ?>
			</select>
		</div>

	</div>
	<div class="col-md-4">
		<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
		<div class="col-sm-10">
			<input type="text" name="block_data[limit]" value="<?php echo $limit; ?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
        <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
        <div class="col-sm-10">
			<div class="form-inline">
				<div class="input-group col-md-6">
  					<span class="input-group-addon">Width: </span>
          				<input name="block_data[image_width]" type="text" class="form-control" value="<?php echo $image_width; ?>">
				    <span class="input-group-addon">px </span>
  				</div>
  				<div class="input-group col-md-6">
  					<span class="input-group-addon">Height: </span>
      				<input name="block_data[image_height]" type="text" class="form-control" value="<?php echo $image_height; ?>">
      				<span class="input-group-addon">px </span>
  				</div>
  			</div>
  		</div>
  	</div>
</div>