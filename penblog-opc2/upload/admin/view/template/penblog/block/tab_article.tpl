<input type="hidden" name="block" value="tab_article">
<div class="form-group">
	<label class="col-sm-2 control-label" for="input-article"><?php echo $entry_article; ?></label>
	<div class="col-sm-10">
    <div class="col-sm-4">
		<select name="" class="multiselect_article form-control" size="8" multiple="multiple" data-right="#multiselect_to_article" data-right-all="#right_All_article" data-right-selected="#right_Selected_article" data-left-all="#left_All_article" data-left-selected="#left_Selected_article">
			<?php if($articles){ ?>
			<?php foreach($articles as $article){ ?>
			<?php if(!in_array($article['article_id'], $block_articles)){ ?>
			<option value="<?php echo $article['article_id']; ?>"><?php echo $article['name']; ?></option>
			<?php } ?>
			<?php } ?>
			<?php } ?>
		</select>
	</div>

	<div class="col-sm-2">
		<button type="button" id="right_All_article" class="btn btn-block btn-primary" data-toggle="tooltip" title="Select All"><i class="fa fa-angle-double-right fa-2x"></i></button>
		<button type="button" id="right_Selected_article" class="btn btn-block" data-toggle="tooltip" title="Select"><i class="fa fa-angle-right fa-2x"></i></button>
		<button type="button" id="left_Selected_article" class="btn btn-block" data-toggle="tooltip" title="Unselect"><i class="fa fa-angle-left fa-2x"></i></button>
		<button type="button" id="left_All_article" class="btn btn-block btn-danger" data-toggle="tooltip" title="Unselect All"><i class="fa fa-angle-double-left fa-2x"></i></button>
	</div>

	<div class="col-xs-4">
		<select name="block_data[block_articles][]" id="multiselect_to_article" class="form-control" size="8" multiple="multiple">
			<?php foreach($articles as $article){ ?>
			<?php if(in_array($article['article_id'], $block_articles)){ ?>
			<option value="<?php echo $article['article_id']; ?>"><?php echo $article['name']; ?></option>
			<?php } ?>
			<?php } ?>
		</select>
	</div>
	</div>
</div>
<div class="form-group">
	<div class="col-md-12">
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