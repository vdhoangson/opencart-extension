<input type="hidden" name="block" value="category">
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
