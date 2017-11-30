<input type="hidden" name="block" value="slider">
<div class="thumb-img">
	<img src="view/penblog/image/slider.png" class="img-responsive" />
</div>
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
	<div class="col-md-4">
		<label class="col-sm-4 control-label"><?php echo $entry_autoscroll; ?></label>
		<div class="btn-group col-md-8" data-toggle="buttons">
			<label class="btn <?php echo $autoscroll==1?'btn-primary active':'btn-default'; ?>">
			<input type="radio" name="block_data[autoscroll]" value="1" <?php echo $autoscroll==1?'checked':''; ?>><?php echo $text_on; ?></label>
			<label class="btn <?php echo $autoscroll==0?'btn-danger active':'btn-default'; ?>">
			<input type="radio" name="block_data[autoscroll]" value="0" <?php echo $autoscroll==0?'checked':''; ?>><?php echo $text_off; ?></label>
		</div>
		<br>
		<label class="col-sm-4 control-label"><?php echo $entry_pauseonhover; ?></label>
		<div class="btn-group col-md-8" data-toggle="buttons">
			<label class="btn <?php echo $pauseonhover==1?'btn-primary active':'btn-default'; ?>">
			<input type="radio" name="block_data[pauseonhover]" value="1" <?php echo $pauseonhover==1?'checked':''; ?>><?php echo $text_on; ?></label>
			<label class="btn <?php echo $pauseonhover==0?'btn-danger active':'btn-default'; ?>">
			<input type="radio" name="block_data[pauseonhover]" value="0" <?php echo $pauseonhover==0?'checked':''; ?>><?php echo $text_off; ?></label>
		</div>
	</div>
	<div class="col-md-4">
		<label class="col-sm-4 control-label"><?php echo $entry_nav; ?></label>
		<div class="btn-group col-md-8" data-toggle="buttons">
			<label class="btn <?php echo $show_nav==1?'btn-primary active':'btn-default'; ?>">
			<input type="radio" name="block_data[show_nav]" value="1" <?php echo $show_nav==1?'checked':''; ?>><?php echo $text_on; ?></label>
			<label class="btn <?php echo $show_nav==0?'btn-danger active':'btn-default'; ?>">
			<input type="radio" name="block_data[show_nav]" value="0" <?php echo $show_nav==0?'checked':''; ?>><?php echo $text_off; ?></label>
		</div>
		<br>
		<label class="col-sm-4 control-label"><?php echo $entry_dot; ?></label>
		<div class="btn-group col-md-8" data-toggle="buttons">
			<label class="btn <?php echo $show_dot==1?'btn-primary active':'btn-default'; ?>">
			<input type="radio" name="block_data[show_dot]" value="1" <?php echo $show_dot==1?'checked':''; ?>><?php echo $text_on; ?></label>
			<label class="btn <?php echo $show_dot==0?'btn-danger active':'btn-default'; ?>">
			<input type="radio" name="block_data[show_dot]" value="0" <?php echo $show_dot==0?'checked':''; ?>><?php echo $text_off; ?></label>
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