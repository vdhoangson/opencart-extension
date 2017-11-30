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
					<!-- Title -->
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title; ?></label>
						<div class="col-sm-10">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" name="testimonial_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($testimonial_description[$language['language_id']]) ? $testimonial_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title" class="form-control" /></div>
							<?php } ?>
						</div>
					</div>
					<!-- Description -->
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-text"><?php echo $entry_description; ?></label>
						<div class="col-sm-10">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><textarea name="testimonial_description[<?php echo $language['language_id']; ?>][description]" cols="60" rows="8" placeholder="<?php echo $entry_title; ?>" class="form-control"><?php echo isset($testimonial_description[$language['language_id']]) ? $testimonial_description[$language['language_id']]['description'] : ''; ?></textarea>
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- Description -->
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-text"><?php echo $entry_reply; ?></label>
						<div class="col-sm-10">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><textarea name="testimonial_description[<?php echo $language['language_id']; ?>][reply]" cols="60" rows="8" placeholder="<?php echo $entry_reply; ?>" id="input-reply<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($testimonial_description[$language['language_id']]) ? $testimonial_description[$language['language_id']]['reply'] : ''; ?></textarea>
							</div>
							<?php } ?>
						</div>
					</div>
					<!-- Name -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
						<div class="col-sm-10"><input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
						</div>
					</div>
					<!-- City -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_city; ?></label>
						<div class="col-sm-10">
							<input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
						</div>
					</div>
					<!-- Email -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_email; ?></label>
						<div class="col-sm-10">
							<input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="status" id="input-status" class="form-control">
								<?php if ($status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
						<div class="col-sm-3">
							<div class="input-group date">
								<input type="text" name="date_added" value="<?php echo $date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
								<span class="input-group-btn">
									<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating; ?></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<?php if ($rating == 1) { ?>
									<input type="radio" name="rating" value="1" checked="checked" />
									1
									<?php } else { ?>
									<input type="radio" name="rating" value="1" />
									1
								<?php } ?>
							</label>
							<label class="radio-inline">
								<?php if ($rating == 2) { ?>
									<input type="radio" name="rating" value="2" checked="checked" />
									2
									<?php } else { ?>
									<input type="radio" name="rating" value="2" />
									2
								<?php } ?>
							</label>
							<label class="radio-inline">
								<?php if ($rating == 3) { ?>
									<input type="radio" name="rating" value="3" checked="checked" />
									3
									<?php } else { ?>
									<input type="radio" name="rating" value="3" />
									3
								<?php } ?>
							</label>
							<label class="radio-inline">
								<?php if ($rating == 4) { ?>
									<input type="radio" name="rating" value="4" checked="checked" />
									4
									<?php } else { ?>
									<input type="radio" name="rating" value="4" />
									4
								<?php } ?>
							</label>
							<label class="radio-inline">
								<?php if ($rating == 5) { ?>
									<input type="radio" name="rating" value="5" checked="checked" />
									5
									<?php } else { ?>
									<input type="radio" name="rating" value="5" />
									5
								<?php } ?>
							</label>
							<?php if ($error_rating) { ?>
								<div class="text-danger"><?php echo $error_rating; ?></div>
							<?php } ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript"><!--

<?php foreach ($languages as $language) { ?>
<?php if ($ckeditor) { ?>
	ckeditorInit('input-reply<?php echo $language['language_id']; ?>', '<?php echo $token; ?>');
<?php } else { ?>
$('#input-reply<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
<?php } ?>

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
<?php echo $footer; ?>