<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-reviews" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-reviews" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_admin_approved; ?></label>
						<div class="col-sm-10">
							<?php if ($testimonial_admin_approved!=0) { ?>
								<input type="checkbox" name="testimonial_admin_approved" value="1" checked="checked" />
								<?php } else { ?>
								<input type="checkbox" name="testimonial_admin_approved" value="1" />
							<?php } ?>
						</div>
					</div>
					<?php if (!isset($default_rating)) $default_rating = '3'; ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_default_rating; ?></label>
						<div class="col-sm-10">
								<span><?php echo $entry_bad; ?></span>&nbsp;
								<input type="radio" name="testimonial_default_rating" value="1" style="margin: 0;" <?php if ( $testimonial_default_rating == 1 ) echo 'checked="checked"';?> />
								&nbsp;
								<input type="radio" name="testimonial_default_rating" value="2" style="margin: 0;" <?php if ( $testimonial_default_rating == 2 ) echo 'checked="checked"';?> />
								&nbsp;
								<input type="radio" name="testimonial_default_rating" value="3" style="margin: 0;" <?php if ( $testimonial_default_rating == 3 ) echo 'checked="checked"';?> />
								&nbsp;
								<input type="radio" name="testimonial_default_rating" value="4" style="margin: 0;" <?php if ( $testimonial_default_rating == 4 ) echo 'checked="checked"';?> />
								&nbsp;
								<input type="radio" name="testimonial_default_rating" value="5" style="margin: 0;" <?php if ( $testimonial_default_rating == 5 ) echo 'checked="checked"';?> />
								&nbsp;
								<span><?php echo $entry_good; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_send_to_admin; ?></label>
							<div class="col-sm-10">
								<?php if (isset($testimonial_send_to_admin)) { ?>
									<input type="checkbox" name="testimonial_send_to_admin" value="1" checked="checked" />
									<?php } else { ?>
									<input type="checkbox" name="testimonial_send_to_admin" value="1" />
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_all_page_limit; ?></label>
							<div class="col-sm-10">
								<input type="text" name="testimonial_all_page_limit" value="<?php if (isset($testimonial_all_page_limit)) echo $testimonial_all_page_limit; else echo "20"; ?>" placeholder="<?php echo $entry_all_page_limit; ?>" id="input-limit" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title; ?></label>
							<div class="col-sm-10">
								<input type="text" name="testimonial_name" value="<?php echo $testimonial_name; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
							<div class="col-sm-10">
								<input type="text" name="testimonial_limit" value="<?php echo $testimonial_limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_random; ?></label>
							<div class="col-sm-10">
								<?php if (isset($testimonial_random) && !empty($testimonial_random)) { ?>
									<input type="checkbox" name="testimonial_random" value="1" checked="checked" />
									<?php } else { ?>
									<input type="checkbox" name="testimonial_random" value="1" />
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-character_limit"><?php echo $entry_character_limit; ?></label>
							<div class="col-sm-10">
								<input type="text" name="testimonial_character_limit" value="<?php if (isset($testimonial_character_limit)) echo $testimonial_character_limit; ?>" placeholder="<?php echo $entry_character_limit; ?>" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="testimonial_status" id="input-status" class="form-control">
									<?php if ($testimonial_status) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php echo $footer; ?>