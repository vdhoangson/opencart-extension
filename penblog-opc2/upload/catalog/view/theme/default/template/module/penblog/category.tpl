<div class="list-group">
  <?php foreach ($categories as $category) { ?>
	<?php if($category['children']){ ?>
		<a href="#cat<?php echo $category['category_id']; ?>" data-toggle="collapse" class="list-group-item"><?php echo $category['name']; ?> <i class="fa fa-sort-desc pull-right"></i></a>

		<div id="cat<?php echo $category['category_id']; ?>" class="panel-collapse collapse">
			<?php foreach ($category['children'] as $child) { ?>
				<?php if ($child['category_id'] == $child_id) { ?>
			  	<a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
			  	<?php } else { ?>
			  	<a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
			  	<?php } ?>
			<?php } ?>
		</div>
  	<?php } else { ?>
  		<a href="<?php echo $category['href']; ?>"class="list-group-item"><?php echo $category['name']; ?></a>
  	<?php } ?>
  <?php } ?>
</div>