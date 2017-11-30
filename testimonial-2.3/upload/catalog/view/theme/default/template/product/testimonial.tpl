<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
	<div class="row">
		<?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
			<?php $class = 'col-sm-6'; ?>
			<?php } elseif ($column_left || $column_right) { ?>
			<?php $class = 'col-sm-9'; ?>
			<?php } else { ?>
			<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>">
			<?php echo $content_top; ?>
			<?php if ($testimonials) { ?>
				<div class="text-right" align="right"><a class="btn btn-info" href="<?php echo $write_url;?>" data-toggle="tooltip" title="" ><span><?php echo $text_write;?></span></a></div></br>
				<?php foreach ($testimonials as $testimonial) { ?>
					<div class="table">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="text-left" width="100">
									<h4><?php echo $testimonial['name']; ?></h4>
									</td>
									<td class="text-left">
									<?php echo $testimonial['description']; ?>
								</td>
							</td>
						</tr>
						<?php if(!empty($testimonial['reply'])){ ?>
							<tr>
								<td class="text-left" width="100">
								<b><?php echo $text_admin_reply; ?></b>
								</td>
								<td class="text-left">
									<i><?php echo $testimonial['reply']; ?></i>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="2" style="font-size: 0.9em; text-align: right;">
								<?php if ($testimonial['rating']) { ?>
									<?php echo $text_average; ?><br>
									<img src="catalog/view/theme/default/image/testimonials/stars-<?php echo $testimonial['rating'] . '.png'; ?>" style="margin-top: 2px;" />
								<?php } ?><br>
								-&nbsp;<i><?php echo $testimonial['name'].' '.$testimonial['city'].' '.$testimonial['date_added']; ?></i>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
		<?php if ( isset($pagination)) { ?>
			<div class="pagination"><?php echo $pagination;?></div>
		<?php }?>
		<?php if (isset($showall_url)) { ?>
			<div class="buttons" align="right"><a class="button" href="<?php echo $write_url;?>" title="<?php echo $write;?>"><span><?php echo $text_write;?></span></a> &nbsp;<a class="button" href="<?php echo $showall_url;?>" title="<?php echo $showall;?>"><span><?php echo $showall;?></span></a></div>
		<?php } ?>
	<?php } ?>
</div>
<div class="bottom">
	<div class="left"></div>
	<div class="right"></div>
	<div class="center"></div>
</div>
</div>
<?php echo $footer; ?>