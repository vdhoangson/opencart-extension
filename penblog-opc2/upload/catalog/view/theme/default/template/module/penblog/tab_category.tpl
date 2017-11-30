<div class="tab-set set-ctab">
	<ul class="nav nav-tabs" id="tab-set-category">
	<?php if($categories){ ?>
		<?php foreach($categories as $category){ ?>
	  		<li><a data-toggle="tab" id="<?php echo $category['category_id']; ?>" href="#category_<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a></li>
		<?php } ?>
	<?php } ?>
	</ul>

	<div class="tab-content">
	<?php if($categories){ ?>
		<?php foreach($categories as $category){ ?>
		<div id="category_<?php echo $category['category_id']; ?>" class="tab-pane fade"></div>
		<?php } ?>
	<?php } ?>
	</div>
	<script type="text/javascript"><!--
	$(document).ready(function(){
		$('#tab-set-category a:first').trigger("click");
	});

	//--></script>
	<script type="text/javascript"><!--

        $( "#tab-set-category a" ).click(function(){
        	var category_id = $(this).attr('id');

			$.ajax({
				url: 'index.php?route=module/penblog_block/tab_item&category_id=' +  category_id + '&<?php echo http_build_query($block_data, '', '&'); ?>',
				type: "GET",
				dataType: 'html',
				success: function(html){
					$('#category_' + category_id).html(html);
				}
			});

        });
--></script>
</div>